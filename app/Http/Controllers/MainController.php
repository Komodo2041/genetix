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

        $area = Area::all();

        $save =  $request->input('save');
        if ($save) {
            $action = $request->input('action');
            switch($action) {
                case "Dodaj test Dno morza":
                    $res = $mdg->generateMeer(10);
                       Area::create(["name" => $res["name"], "data" => json_encode($res['data'])]);
                       return redirect("/")->with('success', 'Utworzono nowy obszar dna');
                    break;
            }
        }
 
        return view("main", ['area' => $area]);
    }

    public function calcarea($id, Request $request, GenetixDataGenerator $gtx, CrossingData $cross, MutationData $mutation) {
        set_time_limit(3600);
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $table = json_decode($area->data);

        $headPoints = $gtx->calcPoints(100, $table);
        $t1 = microtime(true);
        $population0 = $gtx->getFirstGeneration(10, 1, 500);
        $t2 = microtime(true);
        echo ($t2 - $t1)." s<br/>";
        $res = $gtx->calcPopulation($population0, $headPoints);
        $maxQ = $res[0]['sum'];
        $oldQ = $res[0]['sum'];
        $repeatQ = 0;
        $maxPoints = $gtx->getmaxPoints(100);
        $nrPop = 0;
        $maxPop = 60;
        $t3 = microtime(true);

        while ($repeatQ < 4 && $nrPop < $maxPop) {
            $t1 = microtime(true);
            $selectedIndividuals = $gtx->getindyvidual($res, 10);
            $newpopulaton = $cross->createNewPopulation($selectedIndividuals);
            $newpopulaton = $mutation->addmutation($newpopulaton);
 
            $res = $gtx->calcPopulation($newpopulaton, $headPoints);
            $maxQ = $res[0]['sum'];
            if ($maxQ == $oldQ) {
                $repeatQ++; 
            } else {
                $repeatQ = 0;
            }    
            echo $repeatQ." powtorzeniea <br/>";    
            $oldQ = $maxQ;
            $nrPop++;
             $t2 = microtime(true);
              echo ($t2 - $t1)." s - Wynik POP: ".$nrPop." - ". $maxQ ."<br/>";
        } 
          $t4 = microtime(true);
 
        $name = "Wynik w pokoleniu ".$nrPop." Wynik: ".($maxQ / $maxPoints)." Czas generacji ".($t4 - $t3)." s";
        Calculation::create(["name" => $name, "data" => json_encode($res[0]['area']), "area_id" => $id]);
        return redirect("/")->with('success', 'Dokonano obliczeń dla obszaru '.$id);  
 
    }


}
