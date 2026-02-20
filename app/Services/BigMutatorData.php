<?php

namespace App\Services;

 

class BigMutatorData
{

    public function bigLayerMutation($numbers, $size, $pop) {
        for ($i = 0; $i < $size; $i++) {
            $res[$i] = []; 
        }  
 
        for ($i = 0; $i < $size; $i++) {
           for ($j = 0; $j < $size; $j++) {
                for ($z = 0; $z < $size; $z++) {
                    $res[$z][] = $pop[$i][$j][$z];
                }
            }
        }  

        $result = [$pop];
 
        for ($n = 0; $n < $numbers; $n++) {
            $used = $res;
            $table = [];
            for ($k = 0; $k < $size; $k++) { 
                shuffle($used[$k]); 
            }
  
            for ($i = 0; $i < $size; $i++) {
                for ($j = 0; $j < $size; $j++) {
                    for ($z = 0; $z < $size; $z++) {
                        $table[$i][$j][$z] = array_shift($used[$z]);
                    }
                }
            }
            $result[] = $table;
        }

        return $result;

    }


}