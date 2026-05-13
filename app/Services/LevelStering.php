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

    public function getminimum($id, $lvl, $t = 0) {
      
        if ($lvl == 0) {
            return 0;
        }
        
        $l = LevelAvg::where("area_id", $id)->where("level", $lvl + 1)->get()->toArray();
   
        if (!$l) {
            $l = LevelAvg::where("area_id", $id)->where("level", $lvl )->get()->toArray();
            
            if (!$l) {
                return 0;
            }
            $res = (1 - $l[0]['avg']) / 10;
            return $l[0]['avg'] + $res;
        }

        $res = (1 - $l[0]['avg']) / 4;
        if ($t == 1) {
           $res = (1 - $l[0]['avg']) / 3;
        }

        return $l[0]['avg'] - $res;

    }

    public function savenocalc($id, $lvl, $res, $min, $type) {

        $nc = NosaveCalc::create([
            'area_id' => $id,
            'level' => $lvl,
            'result' => $res,
            'avginlevel' => $min,
            'type' => $type
        ]);

        return [ LevelAvg::where("avg", "<", $res)->where("area_id", $id)->orderBy("avg", "DESC")->first()->toArray()["level"], $nc->id];
    }

    public function saveCalco($cID, $ncId) {
       $nc = NosaveCalc::find($ncId);
       $nc->calc_id = $cID;
       $nc->save();
    }

}



