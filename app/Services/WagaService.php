<?php

namespace App\Services;
use App\Models\Waga; 
 

class WagaService
{
    static public function getdiffwaga($data, $headPoints, $areaId, $cId, $gtx) {
        $weightDiffo = [];
        $diff = 0.4;
        $points = 0;
        $step = 0;
        $size = 10;
        $maxpoints = round(0.1 * $size * $size * $size);
        while ($points < $maxpoints && $step < 50) {
             $weightDiffo = $gtx->getWeightScale($data, $headPoints, $size, $diff);
             $step++;
             $points = $gtx->calcpointinarea($weightDiffo, $size);
             $diff = $diff / 1.3; 
        }
  
        Waga::create(["data" => json_encode($weightDiffo), "area_id" => $areaId, "calculation_id" => $cId ]); 

        return $weightDiffo;        
    }



}