<?php

namespace App\Services;
 
class CrossingData
{

    public $nrcrossing = 70;

    /**
     * nonused method "cutting_xyz"
     * 
     * 
     */

    public $multipleCrossings = ["blob6random",  "blob3random", "blob3", "blob6", "layersinx4", "layersinj4", "layersinz4"];
    public $bestCrossing = ["updown",  "tassingz", "joinwith0", "joinwith0", "tassingy",  "squerInSquere7AxX"];

    public function createNewPopulation($population) {
       $max = count($population);
       $res = [];
       $crossing = [];
     
       $methods = [ "updown",  "tassingz", "squerInSquere6AxX", "squerInSquere5AxZ", "squerInSquere6AxY", "squerInSquere7AxY", "squerInSquere7AxX" ];
       $choosecross = rand(0, 2);
       if ($choosecross == 1) {
          $methods = [ "blob6random",  "blob3random", "blob3", "blob6", "squerInSquere5AxX", "squerInSquere5AxY", "squerInSquere7AxX", "joinwith0" ];
       } elseif ($choosecross == 2) {
          $methods = [    "layersinx4", "layersinj4", "layersinz4", "layersinj2", "layersinz2", "layersinx2" , "layersin2xyz" ];
       }
 
       $choosecross = rand(0, 11);
       if ($choosecross == 7 || $choosecross == 8) {
          $methods = [ "chessboardrandom_xz", "squerInSquere6AxZ", "squerInSquere7AxZ", "chessboard_xy", "chessboard_xz", "chessboard_yz", "usedblockhalfhalfrandom"  ];
       }  elseif ($choosecross == 9 || $choosecross == 10) {
           $methods = [ "tassingx",  "chessboardradom_xy", "leftright", "leftright2", "random50", "usedblockhalfhalf", "chessboardrandom_yz"];
       }  elseif ($choosecross == 11) {
                   $methods = [  "joinwith0", "joinwith1",  "cutting_xy", "cutting_xz", "cutting_yz", "chessboardrandom_xyz", "tassingy"  ];
       }      
         foreach ($methods AS $m) {
          if (count($population) < 10) { 
              if (in_array($m, $this->multipleCrossings)) {
                  $m = $this->bestCrossing[rand(0, count($this->bestCrossing) - 1)];
              }
          }
        

          for ($i = 0; $i < $this->nrcrossing; $i++) {
 
            $area = $this->$m($population, $max);
            $res[] = $area;
            $crossing[] = $m;
          }
       }
       return [$res, $crossing];

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

    private function joinwith0($population, $max, $nr = 10) {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($one[$i][$j][$z] == 1 && $two[$i][$j][$z] == 1) {
                       $table[$i][$j][$z] = 1;
                    } else {
                       $table[$i][$j][$z] = 0;
                    }

                }
            }
        }
        return $table;
    }
    
    private function joinwith1($population, $max, $nr = 10) {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($one[$i][$j][$z] == 0 && $two[$i][$j][$z] == 0) {
                       $table[$i][$j][$z] = 0;
                    } else {
                       $table[$i][$j][$z] = 1;
                    }

                }
            }
        }
        return $table;
    }    

 

    private function chessboard_xy($population, $max, $nr = 10) {
         
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
      
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if (($i + $j) % 2 == 1) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
 
                }
            }
        }
        return $table;
    }

    private function chessboard_xz($population, $max, $nr = 10) {
         
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
      
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if (($i + $z) % 2 == 1) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
 
                }
            }
        }
        return $table;
    }

    private function chessboard_yz($population, $max, $nr = 10) {
         
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
      
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if (($z + $j) % 2 == 1) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
 
                }
            }
        }
        return $table;
    }    
 
    private function chessboardradom_xy($population, $max, $nr = 10) {
         
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $usedtwenty = $this->get20rand();


        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($usedtwenty[$i + $j]) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
 
                }
            }
        }
        return $table;
    }

    private function chessboardrandom_xz($population, $max, $nr = 10) {
         
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $usedtwenty = $this->get20rand();
 
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($usedtwenty[$i + $z]) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
 
                }
            }
        }
        return $table;
    }    

    private function chessboardrandom_yz($population, $max, $nr = 10) {
         
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $usedtwenty = $this->get20rand();
 
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($usedtwenty[$j + $z]) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
 
                }
            }
        }
        return $table;
    }       

     private function usedblockhalfhalf($population, $max, $nr = 10) {
         
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
 
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = floor($i / 5) + floor($j / 5) + floor($z / 5);
                    if ($sum % 2 == 1) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
 
                }
            }
        }
        return $table;
    }    

     private function usedblockhalfhalfrandom($population, $max, $nr = 10) {
         
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $usedtwenty = $this->get20rand();

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = floor($i / 5) * 4 + floor($j / 5) * 2 + floor($z / 5) * 1;
                    if ($usedtwenty[$sum]) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
 
                }
            }
        }
        return $table;
    }       

    private function chessboardrandom_xyz($population, $max, $nr = 10) {
         
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $usedtwenty = $this->get20rand();
 
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($usedtwenty[$i + $j + $z]) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
 
                }
            }
        }
        return $table;
    }  
     

    private function get20rand() {
        $table = [];
        for ($i = 0; $i < 30; $i++) {
           $table[] = rand(0, 1);
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
 
    private function squerInSquere7AxZ($population, $max, $nr = 10) {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        
        $pom1 = rand(0, 2);
        $pom2 = rand(0, 2);

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                   if ($i > $pom1 && $i <= $pom1 + 7 && $j > $pom2 && $j <= $pom2 + 7 ) {
                      $table[$i][$j][$z] = $one[$i][$j][$z];
                   } else {
                      $table[$i][$j][$z] = $two[$i][$j][$z];
                   }
  
                }
            }
        }
        return $table;
    }
 
    private function squerInSquere7AxY($population, $max, $nr = 10) {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        
        $pom1 = rand(0, 2);
        $pom2 = rand(0, 2);

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                   if ($i > $pom1 && $i <= $pom1 + 7 && $z > $pom2 && $z <= $pom2 + 7 ) {
                      $table[$i][$j][$z] = $one[$i][$j][$z];
                   } else {
                      $table[$i][$j][$z] = $two[$i][$j][$z];
                   }
  
                }
            }
        }
        return $table;
    }
     
    private function squerInSquere7AxX($population, $max, $nr = 10) {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        
        $pom1 = rand(0, 2);
        $pom2 = rand(0, 2);

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                   if ($j > $pom1 && $j <= $pom1 + 7 && $z > $pom2 && $z <= $pom2 + 7 ) {
                      $table[$i][$j][$z] = $one[$i][$j][$z];
                   } else {
                      $table[$i][$j][$z] = $two[$i][$j][$z];
                   }
  
                }
            }
        }
        return $table;
    }       
 
    private function squerInSquere6AxZ($population, $max, $nr = 10) {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        
        $pom1 = rand(0, 3);
        $pom2 = rand(0, 3);

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                   if ($i > $pom1 && $i <= $pom1 + 6 && $j > $pom2 && $j <= $pom2 + 6 ) {
                      $table[$i][$j][$z] = $one[$i][$j][$z];
                   } else {
                      $table[$i][$j][$z] = $two[$i][$j][$z];
                   }
  
                }
            }
        }
        return $table;
    }
  
    private function squerInSquere6AxY($population, $max, $nr = 10) {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        
        $pom1 = rand(0, 3);
        $pom2 = rand(0, 3);

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                   if ($i > $pom1 && $i <= $pom1 + 6 && $z > $pom2 && $z <= $pom2 + 6 ) {
                      $table[$i][$j][$z] = $one[$i][$j][$z];
                   } else {
                      $table[$i][$j][$z] = $two[$i][$j][$z];
                   }
  
                }
            }
        }
        return $table;
    }
    
    private function squerInSquere6AxX($population, $max, $nr = 10) {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        
        $pom1 = rand(0, 3);
        $pom2 = rand(0, 3);

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                   if ($j > $pom1 && $j <= $pom1 + 6 && $z > $pom2 && $z <= $pom2 + 6 ) {
                      $table[$i][$j][$z] = $one[$i][$j][$z];
                   } else {
                      $table[$i][$j][$z] = $two[$i][$j][$z];
                   }
  
                }
            }
        }
        return $table;
    }  
 
    private function squerInSquere5AxZ($population, $max, $nr = 10) {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        
        $pom1 = rand(0, 4);
        $pom2 = rand(0, 4);

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                   if ($i > $pom1 && $i <= $pom1 + 5 && $j > $pom2 && $j <= $pom2 + 5 ) {
                      $table[$i][$j][$z] = $one[$i][$j][$z];
                   } else {
                      $table[$i][$j][$z] = $two[$i][$j][$z];
                   }
  
                }
            }
        }
        return $table;
    }
 
    private function squerInSquere5AxY($population, $max, $nr = 10) {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        
        $pom1 = rand(0, 4);
        $pom2 = rand(0, 4);

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                   if ($i > $pom1 && $i <= $pom1 + 5 && $z > $pom2 && $z <= $pom2 + 5 ) {
                      $table[$i][$j][$z] = $one[$i][$j][$z];
                   } else {
                      $table[$i][$j][$z] = $two[$i][$j][$z];
                   }
  
                }
            }
        }
        return $table;
    }
    
    private function squerInSquere5AxX($population, $max, $nr = 10) {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        
        $pom1 = rand(0, 4);
        $pom2 = rand(0, 4);

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                   if ($j > $pom1 && $j <= $pom1 + 5 && $z > $pom2 && $z <= $pom2 + 5 ) {
                      $table[$i][$j][$z] = $one[$i][$j][$z];
                   } else {
                      $table[$i][$j][$z] = $two[$i][$j][$z];
                   }
  
                }
            }
        }
        return $table;
    }    

 
    private function blob3($population, $max, $nr = 10) {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $three = $population[$randNumbers[2]];
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = $one[$i][$j][$z] + $two[$i][$j][$z] + $three[$i][$j][$z];
                    if ($sum <= 1) {
                       $table[$i][$j][$z] = 0;
                    } else {
                       $table[$i][$j][$z] = 1;
                    }

                }
            }
        }
        return $table;
    }   

 
    private function blob3random($population, $max, $nr = 10) {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $three = $population[$randNumbers[2]];
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = $one[$i][$j][$z] + $two[$i][$j][$z] + $three[$i][$j][$z];
                    if ($sum < 1) {
                       $table[$i][$j][$z] = 0;
                    } elseif ($sum > 2) {
                       $table[$i][$j][$z] = 1;
                    } else {
                       $table[$i][$j][$z] = rand(0,1);
                    }

                }
            }
        }
        return $table;
    }      
   
    private function blob6($population, $max, $nr = 10) {
        $randNumbers = $this->getRand($max);
        $blob = [];
        for ($k =0; $k <= 6; $k++) {
            $blob[] = $population[$k];
        }
 
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = 0;
                    for ($k =0; $k <= 6; $k++) {
                        $sum += $blob[$k][$i][$j][$z];
                    }                    
                    if ($sum <= 3) {
                       $table[$i][$j][$z] = 0;
                    }  else {
                        $table[$i][$j][$z] = 1;
                    }

                }
            }
        }
        return $table;
    }     

    private function blob6random($population, $max, $nr = 10) {
        $randNumbers = $this->getRand($max);
        $blob = [];
        for ($k =0; $k <= 6; $k++) {
            $blob[] = $population[$k];
        }
 
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = 0;
                    for ($k =0; $k <= 6; $k++) {
                        $sum += $blob[$k][$i][$j][$z];
                    }                    
                    if ($sum <= 1) {
                       $table[$i][$j][$z] = 0;
                    } elseif ($sum >= 5) {
                       $table[$i][$j][$z] = 1;
                    } else {
                        $table[$i][$j][$z] = rand(0,1);
                    }

                }
            }
        }
        return $table;
    }     

  
    private function layersinz2($population, $max, $nr = 10) {
        $randNumbers = $this->getRand($max);
        for ($k =0; $k < 2; $k++) {
            $pom[] = $randNumbers[$k];
        }        
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];        


        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if (in_array($z, $pom)) {
                       $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                       $table[$i][$j][$z] = $two[$i][$j][$z];
                    }

                }
            }
        }
        return $table;
    }

    private function layersinx2($population, $max, $nr = 10) {
        $randNumbers = $this->getRand($max);
        for ($k =0; $k < 2; $k++) {
            $pom[] = $randNumbers[$k];
        }        
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];         

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if (in_array($i, $pom)) {
                       $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                       $table[$i][$j][$z] = $two[$i][$j][$z];
                    }

                }
            }
        }
        return $table;
    }
 
    private function layersinj2($population, $max, $nr = 10) {
        $randNumbers = $this->getRand($max);
        for ($k =0; $k < 2; $k++) {
            $pom[] = $randNumbers[$k];
        }        
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];         

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if (in_array($j, $pom)) {
                       $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                       $table[$i][$j][$z] = $two[$i][$j][$z];
                    }

                }
            }
        }
        return $table;
    }

    private function layersinz4($population, $max, $nr = 10) {
        $randNumbers = $this->getRand($max);
        for ($k =0; $k < 4; $k++) {
            $pom[] = $randNumbers[$k];
        }        
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];         

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if (in_array($z, $pom)) {
                       $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                       $table[$i][$j][$z] = $two[$i][$j][$z];
                    }

                }
            }
        }
        return $table;
    }
 
    private function layersinx4($population, $max, $nr = 10) {
        $randNumbers = $this->getRand($max);
        for ($k =0; $k < 4; $k++) {
            $pom[] = $randNumbers[$k];
        }        
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];         

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if (in_array($i, $pom)) {
                       $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                       $table[$i][$j][$z] = $two[$i][$j][$z];
                    }

                }
            }
        }
        return $table;
    }

    private function layersinj4($population, $max, $nr = 10) {
        $randNumbers = $this->getRand($max);
        for ($k =0; $k < 4; $k++) {
            $pom[] = $randNumbers[$k];
        }        
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];         

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if (in_array($j, $pom)) {
                       $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                       $table[$i][$j][$z] = $two[$i][$j][$z];
                    }

                }
            }
        }
        return $table;
    }    

 
    private function layersin2xyz($population, $max, $nr = 10) {
        $randNumbers = $this->getRand($max);
        for ($k =0; $k < 2; $k++) {
            $pom[] = $randNumbers[$k];
        }
        $randNumbers = $this->getRand($max);
        for ($k =0; $k < 2; $k++) {
            $pom1[] = $randNumbers[$k];
        }    
        $randNumbers = $this->getRand($max);
        for ($k =0; $k < 2; $k++) {
            $pom2[] = $randNumbers[$k];
        }                            
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];         

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if (in_array($i, $pom) || in_array($j, $pom1) || in_array($z, $pom2)) {
                       $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                       $table[$i][$j][$z] = $two[$i][$j][$z];
                    }

                }
            }
        }
        return $table;
    }     

    public function getAllMethod() {
       $methods = ["random50", "updown", "leftright", "leftright2", "tassingx", "tassingy", "tassingz", "cutting_xy", "cutting_xz", "cutting_yz", "cutting_xyz"];
       $methods2 = [  "joinwith0", "joinwith1",  "chessboard_xy", "chessboard_xz", "chessboard_yz", "chessboardradom_xy", "chessboardrandom_xz", "chessboardrandom_yz",   
                  "usedblockhalfhalf", "usedblockhalfhalfrandom", "chessboardrandom_xyz" ];
       $methods3 = ["squerInSquere5AxZ", "squerInSquere6AxX", "squerInSquere6AxY", "squerInSquere6AxZ", "squerInSquere7AxX", "squerInSquere7AxY", "squerInSquere7AxZ"];
       $methods4 = [ "blob6random",  "blob3random", "blob3", "blob6", "squerInSquere5AxX", "squerInSquere5AxY", "squerInSquere7AxX", "joinwith0" ];
       $methods5 = [ "layersin2xyz",  "layersinx4", "layersinj4", "layersinz4", "layersinj2", "layersinz2", "layersinx2" ];
        return array_merge($methods, $methods2, $methods3, $methods4, $methods5);          
              
    }

}

 