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

    public function UpLayers($data, $tryb = 1,  $size = 10) {

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
            $pom = rand(0, floor($size/2) + 1);
            break;              
       }

        for ($i = 0; $i < $size; $i++) {
           for ($j = 0; $j < $size; $j++) {
               for ($z = 0; $z < $size; $z++) {

                  if ($z == $size - 1) {
                      $res[$i][$j][$z] = 0;
                  } elseif ($pom >= $z) {
                      $res[$i][$j][$z] = $data[$i][$j][$z + 1];
                  } else {
                      $res[$i][$j][$z] = $data[$i][$j][$z];
                  }
               }
           }
        }       
        return $res;

    }

    public function zeroBlock($data, $size, $block) {

        $res = $data;

        $max = $size - $block - 1;
        $pom1 = rand(0, $max);
        $pom2 = rand(0, $max);
        $pom3 = rand(0, $max);

        for ($i = 0; $i < $size; $i++) {
           for ($j = 0; $j < $size; $j++) {
               for ($z = 0; $z < $size; $z++) {

                     if (($i >= $pom1 && $i <= $pom1 + $block - 1 )
                          && ($j >= $pom2 && $j <= $pom2 + $block - 1 )
                          && ($z >= $pom3 && $z <= $pom3 + $block - 1 )) {
                           $res[$i][$j][$z] = 0;
                     } 
               }
           }
        }       


        return $res;

    }

    public function getInversion($data, $size = 10) {
        $table = []; 
        for ($i = 0; $i < $size; $i++) {
           for ($j = 0; $j < $size; $j++) {
               for ($z = 0; $z < $size; $z++) {
                  if ($data[$i][$j][$z] == 0) {
                     $table[$i][$j][$z] = 1;
                  } else {
                     $table[$i][$j][$z] = 0;
                  }
               }
           }
        }
        return $table;       

    }

    public function getmostdifferent($calculations, $nr) {
 
       $count = count($calculations);
       $results = [];
       $res = [];
       $used = [];
       for ($i = 0; $i < $count; $i++) {
          for ($j = 0; $j < $count; $j++) {
             if ($i == $j) {
                 $results[$i][$j] = 0;
                 continue;
             }
             $results[$i][$j] = 1000 - $this->calcpointer(json_decode($calculations[$i]->data), json_decode($calculations[$j]->data));
          }
       }

       $maxpairs = [];
       $max = 0;
       for ($i = 0; $i < $count; $i++) {
          for ($j = 0; $j < $count; $j++) {
             if ($i == $j) { 
                 continue;
             }
             if ($results[$i][$j] > $max) {
                $maxpairs = [$i, $j];
                $max = $results[$i][$j];
             }
          }
       }       
 
 
       for ($i = 2; $i <= $nr; $i++) {
           $max = 0;
           for ($j = 0; $j < $count; $j++) {
              if (in_array($j, $maxpairs)) {
                 continue;
              }
              $sum = 0;
              $newNumber = -1;
              foreach ($maxpairs AS $m) {
                  $sum += $results[$j][$m];
              }
              if ($sum > $max) {
                $max = $sum;
                $newNumber = $j;
              }

           }
           if ($newNumber > -1) {
               $maxpairs[] = $newNumber;
           }
       }

       foreach ($maxpairs AS $m) {
          $res[] = $calculations[$m];
       }

       return $res;

    }

 
 
    public function calcpointer($one, $two) {
        $sum = 0;
        $nr = 10;
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($one[$i][$j][$z] == $two[$i][$j][$z]) {
                       $sum++;
                    }
                }
            }
        }
        return $sum;
    }

 
    public function checkedSameResultsinLine($usedcalculations, $area) {
       $res = 0;
       foreach ($usedcalculations AS $one ) {
          $all = $this->calcpointer($one, $area);
          
          if ($all > 999) {
            $res = $all;
            break;
          }
       }
        
       return $res;
    }
 

 


}