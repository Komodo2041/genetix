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

    public function getZeroTable($size) {
        $table = [];
        for ($i = 0; $i < $size; $i++) {
           for ($j = 0; $j < $size; $j++) {
               for ($z = 0; $z < $size; $z++) {
                   $table[$i][$j][$z] = 0;
               }
           }
        }
        return $table; 
    }

    public function upSomePoint($data) {
       $nr = rand(2, 4);
       $n = 0;
       while ($nr > 0 && $n < 100) {
          $x = rand(0, $size - 1);
          $y = rand(0, $size - 1);
          $z = rand(0, $size - 1);
          if ($data[$x][$y][$z] == 0) {
              $data[$x][$y][$z] = 1;
              $nr--;
          } 
          $n++;
       }
       return $data;
    }

    public function downSomePoint($data) {
       $nr = rand(2, 4);
       $n = 0;
       while ($nr > 0 && $n < 100) {
          $x = rand(0, $size - 1);
          $y = rand(0, $size - 1);
          $z = rand(0, $size - 1);
          if ($data[$x][$y][$z] == 1) {
              $data[$x][$y][$z] = 0;
              $nr--;
          } 
          $n++;
       }
       return $data;
    }

}