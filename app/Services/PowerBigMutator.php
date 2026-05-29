<?php

namespace App\Services;

use App\Services\CrossingData; 

class PowerBigMutator 
{
    private $percent = 100;

    public $numbers = 650;
    public $allMethods = ["powerBigLayerMutation200", "powerBigLayerMutation125", "powerBigLayerMutation100", "powerBigLayerMutation50",
       "powerBigLayerMutation25", "powerBigLayerMutation10", "powerBigLayerMutation5"];
    public $halfMethods = ["powerBigLayerMutation50", "powerBigLayerMutation25", "powerBigLayerMutation10", "powerBigLayerMutation5"];

    private $cross = null;

    public function __construct(CrossingData $c) {
        $this->cross = $c;
    }

    public function getAllMethod() {
        return $this->allMethods;
    }

    private function noChangeZ() {
        if ($this->percent == 100) {
            return 0;
        }
        $r = rand(0, 100);
        if ($r < $this->percent) {
            return 0;
        }
        return 1;
    }    

    public function createNewPopulation($population, $usem = 1 ) {

       $max = count($population);
       $res = $population;
       $mutting = [];
       $tablemethods = [];
       if ($usem == 1 || $usem == 0) {
           $nrmethos = count($this->allMethods);
           $tablemethods = $this->allMethods;
       } elseif ($usem == 2) {
           $nrmethos = count($this->halfMethods);
           $tablemethods = $this->halfMethods;
       } 

       for ($i = 0; $i < $this->numbers; $i++) {
 
            $ch = rand(0, $nrmethos - 1);
           
            $m = $tablemethods[$ch];
            $select = rand(0, $max - 1);

            $areas = $this->$m(1, 10, $population[$select]);
            $res[] = $areas[1];
            $mutting[] = $m;
        }
   
       return [$res, $mutting];       
    } 


    public function powerBigLayerMutation100($numbers, $size, $pop) {
       return $this->powerBigLayerMutationLine($numbers, $size, $pop, 100); 
    }

    public function powerBigLayerMutation200($numbers, $size, $pop) {
       return $this->powerBigLayerMutationLine($numbers, $size, $pop, 200); 
    }
    
    public function powerBigLayerMutation125($numbers, $size, $pop) {
       return $this->powerBigLayerMutationLine($numbers, $size, $pop, 125); 
    }
    
    public function powerBigLayerMutation50($numbers, $size, $pop) {
       return $this->powerBigLayerMutationLine($numbers, $size, $pop, 50); 
    }
    
    public function powerBigLayerMutation25($numbers, $size, $pop) {
       return $this->powerBigLayerMutationLine($numbers, $size, $pop, 25); 
    }
    
    public function powerBigLayerMutation10($numbers, $size, $pop) {
       return $this->powerBigLayerMutationLine($numbers, $size, $pop, 10); 
    }
    
    public function powerBigLayerMutation5($numbers, $size, $pop) {
       return $this->powerBigLayerMutationLine($numbers, $size, $pop, 5); 
    }    

    public function powerBigLayerMutationLine($numbers, $size, $pop, $value) {

        $orders = $this->cross->getOrders($size);
        $parts = $this->cross->getPartsOrders($orders, $value);
 
        for ($i = 0; $i < $size; $i++) {
            $res[$i] = []; 
        }  
 
        for ($i = 0; $i < $size; $i++) {
           for ($j = 0; $j < $size; $j++) {
                for ($z = 0; $z < $size; $z++) {
                    $res[$parts[$i."-".$j."-".$z]][] = $pop[$i][$j][$z];
                }
            }
        }  

        $result = [$pop];
 
        for ($n = 0; $n < $numbers; $n++) {
            $used = $res;
            $table = [];
            for ($k = 0; $k < $size; $k++) { 
                if ($this->noChangeZ()) {
                    continue;
                }                
                shuffle($used[$k]); 
            }
  
            for ($i = 0; $i < $size; $i++) {
                for ($j = 0; $j < $size; $j++) {
                    for ($z = 0; $z < $size; $z++) {
                        $table[$i][$j][$z] = array_shift($used[$parts[$i."-".$j."-".$z]]);
                    }
                }
            }
            $result[] = $table;
        }

        return $result;

    }

    public function setPercent($p) {
        $this->percent = $p;
    }


}

