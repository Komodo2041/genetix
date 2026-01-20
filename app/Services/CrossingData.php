<?php

namespace App\Services;
 
class CrossingData
{

    public $nrcrossing = 50;

    public function createNewPopulation($population) {
       $max = count($population);
       $res = [];
       $methods = ["random50", "updown", "leftright", "leftright2", "tassingx", "tassingy", "tassingz", "cutting_xy", "cutting_xz", "cutting_yz", "cutting_xyz"];
       foreach ($methods AS $m) {
          for ($i = 0; $i < $this->nrcrossing; $i++) {
            $area = $this->$m($population, $max);
            $res[] = $area;
          }
       }
       return $res;

    }

    private function random50($population, $max, $nr = 10) {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if (rand(0, 1) == 0) {
                       $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                       $table[$i][$j][$z] = $two[$i][$j][$z];
                    }

                }
            }
        }
        return $table;
    }
     
    private function tassingz($population, $max, $nr = 10) {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($z % 2 == 0) {
                       $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                       $table[$i][$j][$z] = $two[$i][$j][$z];
                    }

                }
            }
        }
        return $table;
    }

    private function tassingx($population, $max, $nr = 10) {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
      
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i % 2 == 0) {
                       $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                       $table[$i][$j][$z] = $two[$i][$j][$z];
                    }

                }
            }
        }
        return $table;
    }    

    private function tassingy($population, $max, $nr = 10) {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
      
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($j % 2 == 0) {
                       $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                       $table[$i][$j][$z] = $two[$i][$j][$z];
                    }

                }
            }
        }
        return $table;
    }     

    private function updown($population, $max, $nr = 10) {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $zlevel = rand(1, $max - 1);
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($z <= $zlevel) {
                       $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                       $table[$i][$j][$z] = $two[$i][$j][$z];
                    }

                }
            }
        }
        return $table;
    }

    private function leftright($population, $max, $nr = 10) {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $xlevel = rand(1, $max - 1);
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i <= $xlevel) {
                       $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                       $table[$i][$j][$z] = $two[$i][$j][$z];
                    }

                }
            }
        }
        return $table;
    }

    private function leftright2($population, $max, $nr = 10) {
         
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $ylevel = rand(1, $max - 1);
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($j <= $ylevel) {
                       $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                       $table[$i][$j][$z] = $two[$i][$j][$z];
                    }

                }
            }
        }
        return $table;
    }

    private function cutting_xy($population, $max, $nr = 10) {
         
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $level = rand(3, $max * 2 - 3);
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i + $j <= $level) {
                       $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                       $table[$i][$j][$z] = $two[$i][$j][$z];
                    }

                }
            }
        }
        return $table;
    }

   private function cutting_xz($population, $max, $nr = 10) {
         
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $level = rand(3, $max * 2 - 3);
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i + $z <= $level) {
                       $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                       $table[$i][$j][$z] = $two[$i][$j][$z];
                    }

                }
            }
        }
        return $table;
    }

   private function cutting_yz($population, $max, $nr = 10) {
         
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $level = rand(3, $max * 2 - 3);
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($j + $z <= $level) {
                       $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                       $table[$i][$j][$z] = $two[$i][$j][$z];
                    }

                }
            }
        }
        return $table;
    }    

   private function cutting_xyz($population, $max, $nr = 10) {
         
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $level = rand(5, $max * 3 - 5);
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($j + $z + $i <= $level) {
                       $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                       $table[$i][$j][$z] = $two[$i][$j][$z];
                    }

                }
            }
        }
        return $table;
    }  

 


    private function getRand($max) {
        $res = [];
        for ($i = 0; $i < $max; $i++) {
           $res[] = $i;
        }
        shuffle($res);
        return $res;
        
    }
 
}

 