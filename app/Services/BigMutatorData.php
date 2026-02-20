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


    /* 5 x 5 */ 
    public function bigLayerMutationMediumSquere($numbers, $size, $pop) {

        for ($i = 0; $i < $size; $i++) {
            $res[$i] = array_fill(0, 4, []);
        }
 
        for ($i = 0; $i < $size; $i++) {
           for ($j = 0; $j < $size; $j++) {
                for ($z = 0; $z < $size; $z++) {
                    if ($i < 5 && $j < 5) {
                       $res[$z][0][] = $pop[$i][$j][$z];
                    } elseif ($i >= 5 && $j < 5) {
                        $res[$z][1][] = $pop[$i][$j][$z];
                    } elseif ($i >= 5 && $j >= 5) {
                        $res[$z][2][] = $pop[$i][$j][$z];
                    } elseif ($i < 5 && $j >= 5) {
                        $res[$z][3][] = $pop[$i][$j][$z];
                    }
                }
            }
        }  

        $result = [$pop];
 
        for ($n = 0; $n < $numbers; $n++) {
            $used = $res;
            $table = [];
            for ($k = 0; $k < $size; $k++) { 
                for ($g = 0; $g < 4; $g++) {
                    shuffle($used[$k][$g]);  
                } 
            }
  
            for ($i = 0; $i < $size; $i++) {
                for ($j = 0; $j < $size; $j++) {
                    for ($z = 0; $z < $size; $z++) {
                        if ($i < 5 && $j < 5) {
                           $table[$i][$j][$z] = array_shift($used[$z][0]);
                        } elseif ($i >= 5 && $j < 5) {
                            $table[$i][$j][$z] = array_shift($used[$z][1]);
                        } elseif ($i >= 5 && $j >= 5) {
                            $table[$i][$j][$z] = array_shift($used[$z][2]);
                        } elseif ($i < 5 && $j >= 5) {
                            $table[$i][$j][$z] = array_shift($used[$z][3]);
                        }
 
                    }
                }
            }
            $result[] = $table;
        }

        return $result;
  
    }    

  


}