<?php

namespace App\Http\Controllers;

use App\Services\MeerDataGenerator;
use App\Services\GenetixDataGenerator;
use App\Services\CrossingData;
use App\Services\MutationData; 

use Illuminate\Http\Request;

use App\Models\Area; 
use App\Models\Calculation; 
use App\Models\Clones;
use App\Models\Diamond;
use App\Models\Diamondcalc;
 
class MainController extends Controller
{

    public $startPopulation = 800;

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
 
    public function calcarea_level($id, $lvl, Request $request, GenetixDataGenerator $gtx, CrossingData $cross, MutationData $mutation, $dId = null) {
        
        set_time_limit(8000);
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $table = json_decode($area->data);
        $headPoints = $gtx->calcPoints(120, $table);

        $population0 = [];

        if (!$dId) {
            $randomDoing = rand(0, 8);
        } else {
            $randomDoing = rand(9, 10);
            $diamonds = ["diamond_id" => $dId];
        }

        $clones = ["area_id" => $id];
         
 
        $individual = 10;
        $lvl = $lvl - 1;
        if ($lvl == 0) {
            
            $population0 = $gtx->getFirstGeneration(10, 1, $this->startPopulation);
        
    
        } elseif ($randomDoing == 0 || $lvl <= 3) {
        
            $calculations = $this->getCalculationLevel($id, $lvl, 10);  
            $population0 = [];
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data);
            }
        } elseif ($randomDoing == 1) {
          
            $calculations = $this->getCalculationLevel($id, $lvl, 5); 
            $population0 = [];
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data);
            }
            $ix = rand(1, $lvl-1);
            $calculations = Calculation::where("area_id", $id)->where("level", $ix)->take(5)->orderByRaw('RAND()')->get();
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data);
            }               
        } elseif ($randomDoing == 2) {
             
            $calculations = $this->getCalculationLevel($id, $lvl, 50, 0);  
            $population0 = [];
            $mostdifferent = $this->getmostdifferent($calculations, 2);  
            foreach ($mostdifferent AS $c) {
                $population0[] = json_decode($c->data);
            }
            $individual = 2;
                
        } elseif ($randomDoing == 3) {
         
            $calculations = $this->getCalculationLevel($id, $lvl, 50, 0);  
            $population0 = [];
            $number = rand(3, 10);
            $mostdifferent = $this->getmostdifferent($calculations, $number);  
            foreach ($mostdifferent AS $c) {
                $population0[] = json_decode($c->data);
            }
            $individual = count($population0);            
        } elseif ($randomDoing == 4) {
            $calculations = $this->getCalculationLevel($id, $lvl, 50, 0);
            $usedpercent = rand(70,99);
     
            $stiffPattern = $gtx->getStiffPattern($calculations, $usedpercent, 10);
 
            $population0 = $gtx->getStableGeneration(10, $this->startPopulation, $stiffPattern[0], $stiffPattern[1]);
 
        } elseif ($randomDoing == 5) { 
        
            $calculations = $this->getCalculationLevel($id, $lvl, 50, 0, true);
            $usedpercent = rand(70,99);
     
            $stiffPattern = $gtx->getStiffPattern($calculations, $usedpercent, 10);
 
            $population0 = $gtx->getStableGeneration(10, $this->startPopulation, $stiffPattern[0], $stiffPattern[1]);

        } elseif ($randomDoing == 6) { // inversion
            $calculations = $this->getCalculationLevel($id, $lvl, 50, 0);
            $usedpercent = rand(70,99); 
            $stiffPattern = $gtx->getStiffPattern($calculations, $usedpercent, 10);  
            $population0[] = $gtx->getInvertStill($stiffPattern[0], $stiffPattern[1]);
            $calculations = $this->getCalculationLevel($id, $lvl, 50, 0);
            $usedpercent = rand(70,99); 
            $stiffPattern = $gtx->getStiffPattern($calculations, $usedpercent, 10);  
            $population0[] = $gtx->getInvertStill($stiffPattern[0], $stiffPattern[1]); 
            $individual = count($population0);  
        }  elseif ($randomDoing == 7) {  // clone

            $calculations = $this->getCalculationLevel($id, $lvl, 50, 0, true);
            $area = json_decode($calculations[0]->data);
            $change = rand(1, 20);
            $res = $gtx->clonePattern($area, 1, $change);
            $population0 = [$area, $res[0]];
            $individual = count($population0);  

            $clones["calc_id"] = $calculations[0]->id;
            $clones["oldresult"] = $calculations[0]->obtainedresult;
            $clones["change"] = $change;

        }  elseif ($randomDoing == 8) { // multiple clone

            $calculations = $this->getCalculationLevel($id, $lvl, 50, 0);
            $area = json_decode($calculations[0]->data);
            $change = rand(1, 5);
            $size = rand(6, 12);
            $res = $gtx->clonePattern($area, $size, $change);
            $population0 = $res;
            $individual = count($population0);
            
            $clones["calc_id"] = $calculations[0]->id;
            $clones["oldresult"] = $calculations[0]->obtainedresult;
            $clones["change"] = $change;     
        } elseif ($randomDoing == 9) {  // clone

            $calculations = $this->getDiamond($dId);
            $area = json_decode($calculations->data);
            $change = rand(1, 20);
            $res = $gtx->clonePattern($area, 1, $change);
            $population0 = [$area, $res[0]];
            $individual = count($population0);  

            $clones["calc_id"] = $calculations->id;
            $clones["oldresult"] = $calculations->obtainedresult;
            $clones["change"] = $change;
        } elseif ($randomDoing == 10) { // multiple clone

            $calculations = $this->getDiamond($dId);
            $area = json_decode($calculations->data);
            $change = rand(1, 10);
            $size = 10;
            $res = $gtx->clonePattern($area, $size, $change);
            $population0 = $res;
            $individual = count($population0);
            
            $clones["calc_id"] = $calculations->id;
            $clones["oldresult"] = $calculations->obtainedresult;
            $clones["change"] = $change;     
        }         

        $power = $gtx->getPower($population0);
 
        $res = $gtx->calcPopulation($population0, $headPoints);

        unset($population0);

        $maxQ = $res[0]['sum'];
        $oldQ = $res[0]['sum'];
        $repeatQ = 0;
        $maxPoints = $gtx->getmaxPoints(120);
        $nrPop = 0;
        $maxPop = 120;
 
        $usedmodify = [];
        $t3 = microtime(true);        
        while ($repeatQ < 10 && $nrPop < $maxPop) {   
            $selectedIndividuals = $gtx->getindyvidual($res, $individual);
            $individual = 10;
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
       
        $result2 = $maxQ / $maxPoints; 
        $name = "Wynik w pokoleniu ".$nrPop." Wynik: ". $result2 ." Czas generacji ".($t4 - $t3)." s";
        $cred = Calculation::create(["result" => $name, "data" => json_encode($res[0]['area']), "area_id" => $id, "level" => $lvl + 1, "obtainedresult" => $result2,
         "usedmod" => json_encode($usedmodify)  ]);

        if ($randomDoing == 7 || $randomDoing == 8 || $randomDoing == 9 || $randomDoing == 10 ) {
            $clones["result"] = $result2;
            Clones::create($clones);
        } 
        if ( $randomDoing == 9 || $randomDoing == 10 ) {
            $diamonds["result"] = $result2;
            $diamonds["calc_id"] = $cred->id;
            Diamondcalc::create($diamonds);
        }

        $additionalresultsmsg = "\n\n";  
        $usedcalculations = [$res[0]['area']];
        for ($i = 1; $i < count($res); $i++) {
            if ($result2 * 0.999999  >= $res[$i]['sum']/$maxPoints) {
               $additionalresultsmsg .= "Przerwano ze względu na słabsze wyniki dla ".$i." potega ".($result2 * 0.999999 )." resu ".($res[$i]['sum'] / $maxPoints)." \n";
               break;
            }
            
            $diff = $this->checkedSameResultsinLine($usedcalculations, $res[$i]['area']);
            if ($diff === 0) {
                $usedcalculations[] = $res[$i]['area'];
                $result =  $res[$i]['sum'] / $maxPoints;
                Calculation::create(["result" => $name, "data" => json_encode($res[$i]['area']), "area_id" => $id, "level" => $lvl + 1, "obtainedresult" => $result, "nrcalc" => $i + 1 ]);
                $additionalresultsmsg .= "Dodano dodatkowe obliczenie Result : ".$i." Wynik: ".$result."\n";
            } 
        } 

       return redirect("/")->with('success', 'Dokonano obliczeń dla obszaru '.$id." Wynik: ". $result2. " Level: ".($lvl + 1). " Wynik w pokoleniu : ".$nrPop. $additionalresultsmsg);  

    }

    private function getmostdifferent($calculations, $nr) {
 
       $count = count($calculations);
       $results = [];
       $res = [];
       $used = [];
       for ($i = 0; $i < $count; $i++) {
          for ($j = 0; $j < $count; $j++) {
             if ($i == $j) {
                 $results[$i][$j] = 0;
                 continue;
             }
             $results[$i][$j] = 1000 - $this->calcpointer(json_decode($calculations[$i]->data), json_decode($calculations[$j]->data));
          }
       }

       $maxpairs = [];
       $max = 0;
       for ($i = 0; $i < $count; $i++) {
          for ($j = 0; $j < $count; $j++) {
             if ($i == $j) { 
                 continue;
             }
             if ($results[$i][$j] > $max) {
                $maxpairs = [$i, $j];
                $max = $results[$i][$j];
             }
          }
       }       
 
 
       for ($i = 2; $i <= $nr; $i++) {
           $max = 0;
           for ($j = 0; $j < $count; $j++) {
              if (in_array($j, $maxpairs)) {
                 continue;
              }
              $sum = 0;
              $newNumber = -1;
              foreach ($maxpairs AS $m) {
                  $sum += $results[$j][$m];
              }
              if ($sum > $max) {
                $max = $sum;
                $newNumber = $j;
              }

           }
           if ($newNumber > -1) {
               $maxpairs[] = $newNumber;
           }
       }

       foreach ($maxpairs AS $m) {
          $res[] = $calculations[$m];
       }

       return $res;

    }

    private function getCalculationLevel($id, $lvl, $nr, $norepeat = 1, $obtain = false) {
        $used = [];
        $newcalc = [];
        if (!$obtain) {
            $calc = Calculation::where("area_id", $id)->where("level", $lvl)->orderByRaw('RAND()')->get();
        } else {
            $calc = Calculation::where("area_id", $id)->where("level", $lvl)->orderByRaw('obtainedresult DESC')->get();
        }
        foreach ($calc AS $c) {
           if (in_array($c->same, $used)) {
            continue;
           } 
           $newcalc[] = $c;
           if ($c->same) {
             $used[] = $c->same;
           }
           if (count($newcalc) >= $nr) {
            break;
           }
        }
        if ($norepeat != 0) {
            if (count($newcalc) < $nr) {
                $newcalc = array_merge($newcalc, $newcalc);
            }
        }
        return $newcalc;
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
              'id' => $c->id,
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

 
    private function checkedSameResultsinLine($usedcalculations, $area) {
       $res = 0;
       foreach ($usedcalculations AS $one ) {
          $all = $this->calcpointer($one, $area);
          
          if ($all > 999) {
            $res = $all;
            break;
          }
       }
        
       return $res;
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

        $calculations = Calculation::wherenull("nrcalc" )->take(10)->orderBy("id", "desc")->get();
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
            $levels[$i]["show_histogram"] = $this->gethistogram($levels[$i]['histogram'], $levels[$i]['all']);
        }
 
        $samecalculations = Calculation::selectRaw(' count(id) AS count, level')->where("area_id", $id)->whereNotNull("same")->groupBy( 'level')->orderBy("level")->get();
        $samecalculations = $samecalculations->pluck("count", "level")->toArray();
         

        return view("histogram", ['calco' => $calc, 'levels' => $levels, 'samecalc' => $samecalculations]);

    }


    public function samecalculations() {
        $calculations = Calculation::where("same", null)->orderBy("id", "asc")->get();
        $used = [];
       
        foreach ($calculations AS $c) {
            if (in_array($c->id, $used)) {
                continue;                    
            }            
            $samecalculations = Calculation::where("data", $c->data)->where("id", "!=", $c->id)->get();
             
            if ($samecalculations->count() > 0) {
                foreach ($samecalculations AS $same) {
                    $used[] = $same->id;
                }
                Calculation::where("data", $c->data)->update(["same" => $c->id]);
            }

        }
        return redirect("/")->with('success', 'Szukano takich samych obliczeń. Znaleziono '.count($used)." takich samych obliczeń "); 
    }

    public function adddiamond($id) {
       $calc = Calculation::find($id);
       if (!$calc) {
          return redirect("/")->with('error',  "Nie znaleziono obliczenia"); 
       }
       $d = Diamond::create(["area_id" => $calc->area_id, "calc_id" => $id]);
       Diamondcalc::create(["calc_id" => $id, "result" => $calc->obtainedresult, "diamond_id" => $d->id ]);
       return redirect("/")->with('success',  "Dodano diament");
    }

    private function getDiamond($dId) {
        $dc = Diamondcalc::where("diamond_id", $dId)->orderByRaw("result DESC")->first();
        if (!$dc) {
          return redirect("/")->with('error',  "Nie znaleziono obliczenia"); 
        }
        $calc = Calculation::find($dc->calc_id);
        if (!$calc) {
          return redirect("/")->with('error',  "Nie znaleziono obliczenia"); 
        }        
        return $calc;
    }

}
