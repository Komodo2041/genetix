<?php

namespace App\Http\Controllers;

use App\Services\MeerDataGenerator;
use App\Services\GenetixDataGenerator;

 
use Illuminate\Http\Request;

use App\Models\Area; 

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

    public function calcarea($id, Request $request, MeerDataGenerator $mdg, GenetixDataGenerator $gtx) {

        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $table = json_decode($area->data);

        $headPoints = $gtx->calcPoints(100, $table);
        
        $population0 = $gtx->getFirstGeneration(10, 1, 500);
        $res = $gtx->calcPopulation($population0, $headPoints);
        $maxQ = $res[0]['sum'];
        $repeatQ = 0;
        $maxPoints = $gtx->getmaxPoints();
  

    }


}
