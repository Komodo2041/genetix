<?php

namespace App\Services;
 
use App\Models\LevelAvg;
use App\Models\Calculation; 

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

}



