<?php

namespace App\Services;




class CrossingData
{

    public $nrcrossing = 50;

    public function createNewPopulation($population) {
       $max = count($population);
       $res = [];
       $methods = ["random50", "updown", "leftright", "tassingx", "tassingy", "tassingz"];
       foreach ($methods AS $m) {
          for ($i = 0; $i < $this->nrcrossing; $i++) {
            $area = $this->$m($population, $max);
            $res[] = $area;
          }
       }
       return $res;

    }
     

}

 