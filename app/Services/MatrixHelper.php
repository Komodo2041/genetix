<?php

namespace App\Services;
 
 
class MatrixHelper {

    public function SetLayer($data, $tryb, $size) {

        $res = $data;
        $pom = rand(0, $size - 1);
        for ($i = 0; $i < $size; $i++) {
           for ($j = 0; $j < $size; $j++) {
               for ($z = 0; $z < $size; $z++) {
                    switch ($tryb) {
                       case 1:
                           if ($i == $pom) {
                              $res[$i][$j][$z] = 1;
                           }
                        break;
                       case 2:
                           if ($j == $pom) {
                              $res[$i][$j][$z] = 1;
                           }                        
                        break;
                       case 3:
                           if ($z == $pom) {
                              $res[$i][$j][$z] = 1;
                           }                        
                        break;                                                
                    }
                }
            }
        }

        return $res;

    }


}