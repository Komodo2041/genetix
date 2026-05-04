<?php

namespace App\Services;
 
 
class MatrixHelper {

    public function SetLayer($data, $tryb, $size, $value = 1, $percent = 50) {

        $res = $data;
        $pom = rand(0, $size - 1);
 
        for ($i = 0; $i < $size; $i++) {
           for ($j = 0; $j < $size; $j++) {
               for ($z = 0; $z < $size; $z++) {

                    if ($percent < 100) {
                        $r = rand(0, 100);
                        if ($r < $percent) {
                            continue;
                        }
                    }

                    switch ($tryb) {
                       case 1:
                           if ($i == $pom) {
                              $res[$i][$j][$z] = $value;
                           }
                        break;
                       case 2:
                           if ($j == $pom) {
                              $res[$i][$j][$z] = $value;
                           }                        
                        break;
                       case 3:
                           if ($z == $pom) {
                              $res[$i][$j][$z] = $value;
                           }                        
                        break;                                                
                    }
                }
            }
        }

        return $res;

    }

    public function getZeroTable($size, $val = 0) {
        $table = [];
        for ($i = 0; $i < $size; $i++) {
           for ($j = 0; $j < $size; $j++) {
               for ($z = 0; $z < $size; $z++) {
                   $table[$i][$j][$z] = $val;
               }
           }
        }
        return $table; 
    }

    public function upSomePoint($data, $size = 10) {
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

    public function downSomePoint($data, $size = 10) {
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

    public function ZeroLayer($data, $tryb, $size, $percent = 50) {

       $res = $data;
       $pom = 0;
       switch ($tryb) {
          case 1: 
            $pom = $size - 3;
            break;
          case 2:
            $pom = rand(floor($size/2), $size - 1);
            break;
          case 3:
            $pom = rand(3, floor($size/2) + 1);
            break;              
       }
 
        for ($i = 0; $i < $size; $i++) {
           for ($j = 0; $j < $size; $j++) {
               for ($z = 0; $z < $size; $z++) {

                    if ($percent < 100) {
                        $r = rand(0, 100);
                        if ($r < $percent) {
                            continue;
                        }
                    }

                   if ($z >= $pom) {
                       $res[$i][$j][$z] = 0;
                   }
               }
            }
        }
        
        return $res;

    }

}