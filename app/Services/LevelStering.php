<?php

namespace App\Services;
 
use App\Models\LevelAvg;
use App\Models\Calculation; 
use App\Models\NosaveCalc; 
 

class LevelStering {

    public function calclevel($id, $lvl) {
        $average = Calculation::where("area_id", $id)
        ->where("level", $lvl)
        ->avg('obtainedresult');

        LevelAvg::updateOrCreate(
            ['area_id' => $id, 'level' => $lvl],  
            ['avg' => $average]
        );
    }

    public function calcarea($id) {
 
        $calco = Calculation::selectRaw(' level, AVG(obtainedresult) as avg')->where("area_id", $id)->groupBy( 'level')->orderBy("level")->get()->toArray();
        if (empty($calco)) return;

        foreach ($calco AS $c) {
           LevelAvg::updateOrCreate(
            ['area_id' => $id, 'level' => $c['level']],  
            ['avg' => $c['avg']]
           );          
        }
 
    }

}



