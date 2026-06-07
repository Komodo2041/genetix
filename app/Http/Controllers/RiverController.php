<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Area; 
use App\Models\Calculation; 

use App\Services\LevelStering;

class RiverController extends Controller
{

    public function __construct() {
        $this->ls = new LevelStering();
    }


    public function cloneRiver($id) {
        $area = Area::find($id);
        if (!$area || !$area->river) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area lub nie ma rzeki');
        }
        $newArea = Area::create([
            "data" => $area->data,
            "name" => "Klon: ".$area->name,
            "river" => $area->river,
            "hide" => 0
        ]);

        $calco = Calculation::where("area_id", $id)->get();
        foreach ($calco AS $c) {
          Calculation::create([
             "area_id" => $newArea->id,
             "result" => $c->result,
             "data" => $c->data,
             "level" => $c->level, 
             "obtainedresult" => $c->obtainedresult,
             "typecalc" => $c->typecalc
          ]);
        }

        $this->ls->calcarea($newArea->id);
        return redirect("/")->with('success', 'Sopiowano rzekę');           

    }

    public function showRiver($id) {
   
        $area = Area::find($id);
        if (!$area ) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area lub nie ma rzeki');
        }

        $table = json_decode($area->data);        
        $res = []; 
        $calculations = $this->getCalculationMaxBest($id, 10);  
        $population0 = []; 
        foreach ($calculations AS $c) {
            $data = json_decode($c->data);
            $record = [
                "name" => $area->name,
                "area_id" => $id,
                'level' => $c->level,
                'sum' => $c->obtainedresult,
                'points' => $this->calcpointer( $table, $data)
            ];
            $res[] = $record;
        }

        $areas = Area::where("river", $id)->get();
        foreach ($areas AS $ar) {
            $calculations = $this->getCalculationMaxBest($ar->id, 10);
            foreach ($calculations AS $c) {
                $data = json_decode($c->data);
                $record = [
                    "name" => $ar->name,
                    "area_id" => $ar->id,
                    'level' => $c->level,
                    'sum' => $c->obtainedresult,
                    'points' => $this->calcpointer( $table, $data)
                ];
                $res[] = $record;            
            }
        }

        return view("showriver", ['calco' => $res, "area" => $area]);    

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

    public function pourRiver($id) {
        $area = Area::find($id);
        if (!$area || !$area->river) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area lub nie ma rzeki');
        }

        $maxArea = Calculation::where("area_id", $id)->max("level");
        $maxRiver = Calculation::where("area_id", $area->river)->max("level");
        $maxRiver--;

        $calco = Calculation::where("area_id", $id)->where("level", $maxArea)->get();
        foreach ($calco AS $c) {
          Calculation::create([
             "area_id" => $area->river,
             "result" => $c->result,
             "data" => $c->data,
             "level" => $maxRiver, 
             "obtainedresult" => $c->obtainedresult,
             "typecalc" => -2
          ]);
        }

        $this->ls->calcarea($area->river);
        return redirect("/")->with('success', 'Wlano rzekę');
    }

    public function addRiver($id) {
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        Area::create(["name" => $area->name." - rzeka", "data" => $area->data, "river" => $id ]);
        return redirect("/")->with('success', 'Utworzono rzekę');
    }

    public function getCalculationMaxBest($id, $number) {
        return  Calculation::where("area_id", $id)->orderByDesc("obtainedresult" )->limit(max(0, $number))->get();
    }


    public function riverSettings($id) {
   
        $area = Area::find($id);
        if (!$area ) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area lub nie ma rzeki');
        }

        $areas = Area::where("hide", 0)->where("river", $id)->get();
        $sett = 0;
        $gen0 = Area::where("river", $id)->where("gen0set", 1)->first();
        if ($gen0) {
            $sett = $gen0->id;
        } 
        return view("showriverSettings", [ "area" => $area, "areas" => $areas, "sett" => $sett]);    

    }

    public function changeName($id, Request $request) {
       $name = $request->input("title");
       $area = Area::find($id);
       if ($name) {
        Area::where("id", $id)->update(["name" => $name]);
       }
       return redirect("/riverSettings/".$area->river)->with('success', 'Zmieniono Nazwę rzeki');
    }

    public function settingGen0Box($id, Request $request) {

        $area = Area::find($id);
        if (!$area ) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area lub nie ma rzeki');
        } 
        $sett = $request->input("setto");
        Area::where("river", $id)->update(["gen0set" => 0]);
        Area::where("id", $sett)->update(["gen0set" => 1]);
        return redirect("/riverSettings/".$area->id)->with('success', 'Zmieniono Ustawienia Gen0');
    }

}
