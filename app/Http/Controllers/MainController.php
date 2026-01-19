<?php

namespace App\Http\Controllers;

use App\Services\MeerDataGenerator;

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

    public function calcarea($id, Request $request, MeerDataGenerator $mdg) {

        $res = $mdg->calcPoints(100);
print_r($res);


    }


}
