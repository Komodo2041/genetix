<?php

namespace App\Http\Controllers;

use App\Services\MeerDataGenerator;
use App\Services\GenetixDataGenerator;
use App\Services\CrossingData;
use App\Services\MutationData; 

use Illuminate\Http\Request;

use App\Models\Area; 
use App\Models\Calculation; 
 

class MainController extends Controller
{
    public function list(Request $request, MeerDataGenerator $mdg) {

        $area = Area::with("calculations")->get();
        
        $calco = Calculation::selectRaw('COUNT(id) AS count, area_id, level, MAX(obtainedresult) as max, AVG(obtainedresult) as avg')->groupBy('area_id', 'level')->orderBy("level")->get()->toArray();
        $calcoData = [];
        foreach ($calco AS $c) {
           $calcoData[$c["area_id"]][] = $c; 
        }

        $save =  $request->input('save');
        if ($save) {
            $action = $request->input('action');
            switch($action) {
                case "Dodaj test Dno morza":
                    $res = $mdg->generateMeer(10);
                       Area::create(["name" => $res["name"], "data" => json_encode($res['data'])]);
                       return redirect("/")->with('success', 'Utworzono nowy obszar dna');
                    break;
                 case "Dodaj obszar 0 i 1":
                    $res = $mdg->generate0and1(10);
                       Area::create(["name" => $res["name"], "data" => json_encode($res['data'])]);
                       return redirect("/")->with('success', 'Utworzono obszar 0 i 1');
                    break;                   
            }
        }
 
        return view("main", ['area' => $area, 'calco' => $calcoData]);
    }
 
    public function calcarea_level($id, $lvl, Request $request, GenetixDataGenerator $gtx, CrossingData $cross, MutationData $mutation) {
        set_time_limit(8000);
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $table = json_decode($area->data);
        $headPoints = $gtx->calcPoints(120, $table);

        $population0 = [];
        // $randomDoing = rand(0,1);
        $randomDoing = 1;
        if ($lvl == 1) {
            $population0 = $gtx->getFirstGeneration(10, 1, 400);
            $lvl = $lvl - 1;
        } elseif ($randomDoing == 0 || $lvl <= 3) {
            $lvl = $lvl - 1;
            $calculations = Calculation::where("area_id", $id)->where("level", $lvl)->take(10)->orderByRaw('RAND()')->get();
            $population0 = [];
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data);
            }
        } else {
            $lvl = $lvl - 1;
            $calculations = Calculation::where("area_id", $id)->where("level", $lvl)->take(5)->orderByRaw('RAND()')->get();
            $population0 = [];
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data);
            }   
            $calculations = Calculation::where("area_id", $id)->where("level", $lvl - 2)->take(5)->orderByRaw('RAND()')->get();
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data);
            }               
        }

        $power = $gtx->getPower($population0);
 
        $res = $gtx->calcPopulation($population0, $headPoints);
        $maxQ = $res[0]['sum'];
        $oldQ = $res[0]['sum'];
        $repeatQ = 0;
        $maxPoints = $gtx->getmaxPoints(120);
        $nrPop = 0;
        $maxPop = 80;
 
        $usedmodify = [];
        $t3 = microtime(true);        
        while ($repeatQ < 8 && $nrPop < $maxPop) {   
            $selectedIndividuals = $gtx->getindyvidual($res, 10);
            $gtx->choosemodify($res, 10, $usedmodify);
            $pop_result = $cross->createNewPopulation($selectedIndividuals);
 
            $newpopulaton = $gtx->usepower($pop_result[0], $power);
 
            $pop_result = $mutation->addmutation($newpopulaton, $pop_result[1]);
            $res = $gtx->calcPopulation($pop_result[0], $headPoints, $pop_result[1]);
 
            $power = $gtx->getPowerfromarea($res);
 
            $maxQ = $res[0]['sum'];
            if ($maxQ == $oldQ) {
                $repeatQ++; 
            } else {
                $repeatQ = 0;
            }    
            $power = $gtx->getPowerfromarea($res);
            $oldQ = $maxQ;
            $nrPop++;             
        } 
        $t4 = microtime(true);
        arsort($usedmodify); 
       
        $result = $maxQ / $maxPoints; 
        $name = "Wynik w pokoleniu ".$nrPop." Wynik: ". $result ." Czas generacji ".($t4 - $t3)." s";
        Calculation::create(["result" => $name, "data" => json_encode($res[0]['area']), "area_id" => $id, "level" => $lvl + 1, "obtainedresult" => $result,
         "usedmod" => json_encode($usedmodify)  ]);

       return redirect("/")->with('success', 'Dokonano obliczeń dla obszaru '.$id." Wynik: ". $result. " Level: ".($lvl + 1). " Wynik w pokoleniu : ".$nrPop);  

    }


    public function percentshow($id) {
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $calc = [];
        $table = json_decode($area->data);

 
        $maxlevel = 1;
        foreach ($area->calculations AS $c) {
           $pc = json_decode($c->data);
 
           $calc[] = [
              'level' => $c->level,
              'sum' => $c->obtainedresult,
              'points' => $this->calcpointer( $table, $pc)
           ]; 
           if ( $c->level > $maxlevel) {
              $maxlevel = $c->level;
           }
           
        }
 
 
        return view("percent", ['calco' => $calc ]);

    }

    private function calcpointer($one, $two) {
        $sum = 0;
        $nr = 10;
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($one[$i][$j][$z] == $two[$i][$j][$z]) {
                       $sum++;
                    }
                }
            }
        }
        return $sum;
    }

    private function getnumber2inarea($one) {
        $sum = 0;
        $nr = 10;
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($one[$i][$j][$z] == 2) {
                       $sum++;
                    }
                }
            }
        }
        return $sum;
    }

 

    private function calcallinLevel($one, $two) {
        $nr = 10;
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($one[$i][$j][$z] == $two[$i][$j][$z]) {
                       $one[$i][$j][$z] = 2;
                    }
                }
            }
        }
        return $one;

    }
     
    private function calcallinHistogramLevel($one, $two, $res) {
        $nr = 10;
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($one[$i][$j][$z] == $two[$i][$j][$z]) {
                       if (!isset($res[$i][$j][$z])) {
                           $res[$i][$j][$z] = 1;
                       } else {
                           $res[$i][$j][$z]++;
                       }
                    } else {
                       if (!isset($res[$i][$j][$z])) {
                           $res[$i][$j][$z] = 0;
                       }
                    }
                }
            }
        }
        return $res;

    }

    private function gethistogram($hist, $maxo = 30) {
        $nr = 10;
        for ($i= 0; $i < $maxo; $i++ ) {
            $res[$i] = 0;
        }
        $maxLevel = 0;
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $h = $hist[$i][$j][$z];
                    if (!isset($res[$h])) {
                       $res[$h] = 1;                       
                    } else {
                       $res[$h]++;
                    }
                    if ($h > $maxLevel) {
                        $maxLevel = $h;
                    }
                } 
            }
        }
        for ($i = $maxLevel + 1; $i < $maxo; $i++) {
            unset($res[$i]);
        }
        return $res;
    }

    public function mutations(CrossingData $cross, MutationData $mutation) {

        $calculations = Calculation::take(10)->orderBy("id", "desc")->get();
        $result = [];
        foreach ($calculations AS $c) {
           if ($c->usedmod) {
              $table = json_decode($c->usedmod);
              foreach ($table AS $key => $value) {
                if (isset($result[$key])) {
                   $result[$key] += $value;
                } else {
                   $result[$key] = $value;
                }
              }
           }
        }
        $all = 0;
        arsort($result);
        foreach ($result AS $key => $value) {
            $all += $value;
        }
        $crossings = $cross->getAllMethod();
        $mutations = $mutation->getAllMethod();
        $nonusedcross = [];
        $nonusedmutations = [];
        foreach ($crossings AS $c) {
           if (!isset($result[$c])) {
             $nonusedcross[] = $c;
           }
        }
        foreach ($mutations AS $m) {
           if (!isset($result[$m])) {
             $nonusedmutations[] = $m;
           }
        }        
        
        return view("mutations", ['mutations' => $result, "all" => $all, 'cross' => $crossings, 'mutaions' => $mutations, 
           "nc" => implode(", ", $nonusedcross ), "nm" => implode(", ", $nonusedmutations )   ]);

    }


    public function histogram($id) {
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $calc = [];
        $table = json_decode($area->data);

        $levels = [[
              'sum' => 0,
              'all' => 0,
              'avg' => 0
           ]];
        $maxlevel = 1;
        foreach ($area->calculations AS $c) {
           $pc = json_decode($c->data);
           if (!isset($levels[$c->level])) {
            $levels[$c->level] = [
                'sum' => 0,
                'all' => 0,
                'avg' => 0,
                'areabulb' => $table,
                'histogram' => [],
                'tohistogram' => $table,
                'sameinlevel' => 0
            ];
           }
           $levels[$c->level]['sum'] += $c->obtainedresult;
           $levels[$c->level]['all'] += 1;
           $calc[] = [
              'level' => $c->level,
              'sum' => $c->obtainedresult,
              'points' => $this->calcpointer( $table, $pc)
           ]; 
           if ( $c->level > $maxlevel) {
              $maxlevel = $c->level;
           }
           $levels[$c->level]['areabulb'] = $this->calcallinLevel($levels[$c->level]['areabulb'], $pc);
           $levels[$c->level]['histogram'] = $this->calcallinHistogramLevel($levels[$c->level]['tohistogram'], $pc, $levels[$c->level]['histogram']);
        }
 
        foreach ($levels AS $key => $value) {
            if ($levels[$key]["all"] > 0) {
                $levels[$key]["avg"] = $levels[$key]["sum"] /  $levels[$key]["all"];
            } else {
                $levels[$key]["avg"] = 0;
            }
            $levels[$key]["divlvl"] = 1;
        }
        for ($i = 1; $i <= $maxlevel; $i++) {
            $levels[$i]["divlvl"] = $levels[$i]["avg"] - $levels[$i - 1]["avg"];
            $levels[$i]["toone"] = $levels[$i]["divlvl"] / (1 - $levels[$i - 1]["avg"]);
            $levels[$i]["sameinlevel"] = $this->getnumber2inarea($levels[$i]['areabulb']);
            $levels[$i]["show_histogram"] = $this->gethistogram($levels[$i]['histogram']);
        }
 
        return view("histogram", ['calco' => $calc, 'levels' => $levels]);

    }


}
