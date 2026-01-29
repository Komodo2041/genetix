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
        
        $calco = Calculation::selectRaw('COUNT(id) AS count, area_id, level, MAX(obtainedresult) as max')->groupBy('area_id', 'level')->orderBy("level")->get()->toArray();
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
        set_time_limit(5000);
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $table = json_decode($area->data);
        $headPoints = $gtx->calcPoints(100, $table);

        $population0 = []; 
        if ($lvl == 1) {
            $population0 = $gtx->getFirstGeneration(10, 1, 500);
            $lvl = $lvl - 1;
        } else {
            $lvl = $lvl - 1;
            $calculations = Calculation::where("area_id", $id)->where("level", $lvl)->take(10)->orderByRaw('RAND()')->get();
            $population0 = [];
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data);
            }
        }

        $power = $gtx->getPower($population0);
 
        $res = $gtx->calcPopulation($population0, $headPoints);
        $maxQ = $res[0]['sum'];
        $oldQ = $res[0]['sum'];
        $repeatQ = 0;
        $maxPoints = $gtx->getmaxPoints(100);
        $nrPop = 0;
        $maxPop = 65;
 
        $usedmodify = [];
        $t3 = microtime(true);        
        while ($repeatQ < 4 && $nrPop < $maxPop) {   
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

       return redirect("/")->with('success', 'Dokonano obliczeń dla obszaru '.$id." Wynik: ". $result. " Level: ".($lvl + 1));  

    }


}
