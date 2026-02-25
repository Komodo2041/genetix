<?php

namespace App\Services;

 

class BigMutatorData
{
    
    public $numbers = 660;
    public $allMethods = ["bigLayerMutation", "bigLayerMutationMediumSquere", "bigLayerMutationMiniSquere", "bigLayerMutationMiniRandomSquere",
                "bigLayerMutationStripRandom5x1Y", "bigLayerMutationStripRandom5x1X", "bigLayerMutationStrip5x1Y", "bigLayerMutationStrip5x1X",
                "bigLayerMutationMiniSmallRandomSquere", "bigLayerMutationStripSmallRandom5x1Y", "bigLayerMutationStripSmallRandom5x1X", 
                "bigLayerMutationMiniVerySmallRandomSquere", "bigLayerMutationStripVerySmallRandom5x1X", "bigLayerMutationStripVerySmallRandom5x1Y",
                "bigLayerMutationTemplatePlusRandom", "bigLayerMutationTSquare3x3xRandom", "bigLayerMutationTSquare2x2xRandom", "bigLayerMutationTSquare4x4xRandom",
                "bigLayerMutationCircle" ];
    public $halfMethods = [ "bigLayerMutationMiniSmallRandomSquere", "bigLayerMutationStripSmallRandom5x1Y", "bigLayerMutationStripSmallRandom5x1X", 
                "bigLayerMutationMiniVerySmallRandomSquere", "bigLayerMutationStripVerySmallRandom5x1X", "bigLayerMutationStripVerySmallRandom5x1Y", 
                "bigLayerMutationTemplatePlusRandom", "bigLayerMutationTSquare3x3xRandom", "bigLayerMutationTSquare2x2xRandom", "bigLayerMutationTSquare4x4xRandom", 
                "bigLayerMutationCircle"];


    public function getAllMethod() {
        return $this->allMethods;
    }

    public function createNewPopulation($population, $usem = 1) {
       $max = count($population);
       $res = $population;
       $mutting = [];
       if ($usem == 1 || $usem == 0) {
           $nrmethos = count($this->allMethods);
       } else {
           $nrmethos = count($this->halfMethods);
       }

       for ($i = 0; $i < $this->numbers; $i++) {
 
            $ch = rand(0, $nrmethos-1);
            if ($usem == 1) {
               $m = $this->allMethods[$ch];
            } else {
               $m = $this->halfMethods[$ch];
            }
            $select = rand(0, $max - 1);

            $areas = $this->$m(1, 10, $population[$select]);
            $res[] = $areas[1];
            $mutting[] = $m;
        }
   
       return [$res, $mutting];       
    }   


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

     /* 2 x 2 */ 
    public function bigLayerMutationMiniSquere($numbers, $size, $pop) {

        for ($i = 0; $i < $size; $i++) {
            $res[$i] = array_fill(0, 25, []);
        }
 
        for ($i = 0; $i < $size; $i++) {
           for ($j = 0; $j < $size; $j++) {
                for ($z = 0; $z < $size; $z++) {
                    $res[$z][ floor($i / 2) * 5 + floor($j / 2)][] = $pop[$i][$j][$z];
                }
            }
        }  

        $result = [$pop];
 
        for ($n = 0; $n < $numbers; $n++) {
            $used = $res;
            $table = [];
            for ($k = 0; $k < $size; $k++) { 
                for ($g = 0; $g < 25; $g++) {
                    shuffle($used[$k][$g]);  
                } 
            }
  
            for ($i = 0; $i < $size; $i++) {
                for ($j = 0; $j < $size; $j++) {
                    for ($z = 0; $z < $size; $z++) {
                        $table[$i][$j][$z] = array_shift($used[$z][floor($i / 2) * 5 + floor($j / 2)]);
                    }
                }
            }
            $result[] = $table;
        }

        return $result;
  
    }   


     /* 2 x 2 Random */ 
    public function bigLayerMutationMiniRandomSquere($numbers, $size, $pop) {

        for ($i = 0; $i < $size; $i++) {
            $res[$i] = array_fill(0, 25, []);
        }
        $rand = rand(0, 100);

        for ($i = 0; $i < $size; $i++) {
           for ($j = 0; $j < $size; $j++) {
                for ($z = 0; $z < $size; $z++) {
                    $res[$z][ floor($i / 2) * 5 + floor($j / 2)][] = $pop[$i][$j][$z];
                }
            }
        }  

        $result = [$pop];
 
        for ($n = 0; $n < $numbers; $n++) {
            $used = $res;
            $table = [];
            for ($k = 0; $k < $size; $k++) { 
                for ($g = 0; $g < 25; $g++) {
                    $go = rand(0, 100);
                    if ($go <= $rand) {
                       shuffle($used[$k][$g]);
                    }  
                } 
            }
  
            for ($i = 0; $i < $size; $i++) {
                for ($j = 0; $j < $size; $j++) {
                    for ($z = 0; $z < $size; $z++) {
                        $table[$i][$j][$z] = array_shift($used[$z][floor($i / 2) * 5 + floor($j / 2)]);
                    }
                }
            }
            $result[] = $table;
        }

        return $result;
  
    }   

     /* 2 x 2 Random */ 
    public function bigLayerMutationMiniSmallRandomSquere($numbers, $size, $pop) {

        for ($i = 0; $i < $size; $i++) {
            $res[$i] = array_fill(0, 25, []);
        }
 
        for ($i = 0; $i < $size; $i++) {
           for ($j = 0; $j < $size; $j++) {
                for ($z = 0; $z < $size; $z++) {
                    $res[$z][ floor($i / 2) * 5 + floor($j / 2)][] = $pop[$i][$j][$z];
                }
            }
        }  

        $result = [$pop];
 
        for ($n = 0; $n < $numbers; $n++) {
            $used = $res;
            $table = [];
            for ($k = 0; $k < $size; $k++) { 
                for ($g = 0; $g < 25; $g++) {
                    $go = rand(0, 100);
                    if ($go <= 20) {
                       shuffle($used[$k][$g]);
                    }  
                } 
            }
  
            for ($i = 0; $i < $size; $i++) {
                for ($j = 0; $j < $size; $j++) {
                    for ($z = 0; $z < $size; $z++) {
                        $table[$i][$j][$z] = array_shift($used[$z][floor($i / 2) * 5 + floor($j / 2)]);
                    }
                }
            }
            $result[] = $table;
        }

        return $result;
  
    }   


     /* Strip 5x1  */ 
    public function bigLayerMutationStrip5x1X($numbers, $size, $pop) {

        for ($i = 0; $i < $size; $i++) {
            $res[$i] = array_fill(0, 20, []);
        }
 
        for ($i = 0; $i < $size; $i++) {
           for ($j = 0; $j < $size; $j++) {
                for ($z = 0; $z < $size; $z++) {
                    $res[$z][ floor($i / 5) * 10 + $j][] = $pop[$i][$j][$z];
                }
            }
        }  

        $result = [$pop];
 
        for ($n = 0; $n < $numbers; $n++) {
            $used = $res;
            $table = [];
            for ($k = 0; $k < $size; $k++) { 
                for ($g = 0; $g < 20; $g++) {
                    shuffle($used[$k][$g]);  
                } 
            }
  
            for ($i = 0; $i < $size; $i++) {
                for ($j = 0; $j < $size; $j++) {
                    for ($z = 0; $z < $size; $z++) {
                        $table[$i][$j][$z] = array_shift($used[$z][floor($i / 5) * 10 + $j]);
                    }
                }
            }
            $result[] = $table;
        }

        return $result;
  
    } 
 
     /* Strip 5x1  */ 
    public function bigLayerMutationStrip5x1Y($numbers, $size, $pop) {

        for ($i = 0; $i < $size; $i++) {
            $res[$i] = array_fill(0, 20, []);
        }
 
        for ($i = 0; $i < $size; $i++) {
           for ($j = 0; $j < $size; $j++) {
                for ($z = 0; $z < $size; $z++) {
                    $res[$z][ floor($j / 5) * 10 + $i ][] = $pop[$i][$j][$z];
                }
            }
        }  

        $result = [$pop];
 
        for ($n = 0; $n < $numbers; $n++) {
            $used = $res;
            $table = [];
            for ($k = 0; $k < $size; $k++) { 
                for ($g = 0; $g < 20; $g++) {
                    shuffle($used[$k][$g]);  
                } 
            }
  
            for ($i = 0; $i < $size; $i++) {
                for ($j = 0; $j < $size; $j++) {
                    for ($z = 0; $z < $size; $z++) {
                        $table[$i][$j][$z] = array_shift($used[$z][floor($j / 5) * 10 + $i ]);
                    }
                }
            }
            $result[] = $table;
        }

        return $result;
  
    }     
 

     /* Strip 5x1 Random */ 
    public function bigLayerMutationStripRandom5x1X($numbers, $size, $pop) {

        for ($i = 0; $i < $size; $i++) {
            $res[$i] = array_fill(0, 20, []);
        }
 
        for ($i = 0; $i < $size; $i++) {
           for ($j = 0; $j < $size; $j++) {
                for ($z = 0; $z < $size; $z++) {
                    $res[$z][ floor($i / 5) * 10 + $j][] = $pop[$i][$j][$z];
                }
            }
        }  

        $result = [$pop];
        $rand = rand(0, 100);

        for ($n = 0; $n < $numbers; $n++) {
            $used = $res;
            $table = [];
            for ($k = 0; $k < $size; $k++) { 
                for ($g = 0; $g < 20; $g++) {
                    $go = rand(0, 100);
                    if ($go <= $rand) { 
                       shuffle($used[$k][$g]);  
                    }
                } 
            }
  
            for ($i = 0; $i < $size; $i++) {
                for ($j = 0; $j < $size; $j++) {
                    for ($z = 0; $z < $size; $z++) {
                        $table[$i][$j][$z] = array_shift($used[$z][floor($i / 5) * 10 + $j]);
                    }
                }
            }
            $result[] = $table;
        }

        return $result;
  
    } 

     /* Strip 5x1 Random */ 
    public function bigLayerMutationStripSmallRandom5x1X($numbers, $size, $pop) {

        for ($i = 0; $i < $size; $i++) {
            $res[$i] = array_fill(0, 20, []);
        }
 
        for ($i = 0; $i < $size; $i++) {
           for ($j = 0; $j < $size; $j++) {
                for ($z = 0; $z < $size; $z++) {
                    $res[$z][ floor($i / 5) * 10 + $j][] = $pop[$i][$j][$z];
                }
            }
        }  

        $result = [$pop];
 
        for ($n = 0; $n < $numbers; $n++) {
            $used = $res;
            $table = [];
            for ($k = 0; $k < $size; $k++) { 
                for ($g = 0; $g < 20; $g++) {
                    $go = rand(0, 100);
                    if ($go <= 20) { 
                       shuffle($used[$k][$g]);  
                    }
                } 
            }
  
            for ($i = 0; $i < $size; $i++) {
                for ($j = 0; $j < $size; $j++) {
                    for ($z = 0; $z < $size; $z++) {
                        $table[$i][$j][$z] = array_shift($used[$z][floor($i / 5) * 10 + $j]);
                    }
                }
            }
            $result[] = $table;
        }

        return $result;
  
    }     


     /* Strip 1x5 Random */ 
    public function bigLayerMutationStripRandom5x1Y($numbers, $size, $pop) {

        for ($i = 0; $i < $size; $i++) {
            $res[$i] = array_fill(0, 20, []);
        }
 
        for ($i = 0; $i < $size; $i++) {
           for ($j = 0; $j < $size; $j++) {
                for ($z = 0; $z < $size; $z++) {
                    $res[$z][ floor($j / 5) * 10 + $i ][] = $pop[$i][$j][$z];
                }
            }
        }  

        $rand = rand(0, 100); 
        $result = [$pop];
 
        for ($n = 0; $n < $numbers; $n++) {
            $used = $res;
            $table = [];
            for ($k = 0; $k < $size; $k++) { 
                for ($g = 0; $g < 20; $g++) {
                    $go = rand(0, 100);
                    if ($go <= $rand) { 
                        shuffle($used[$k][$g]);
                    }
                } 
            }
  
            for ($i = 0; $i < $size; $i++) {
                for ($j = 0; $j < $size; $j++) {
                    for ($z = 0; $z < $size; $z++) {
                        $table[$i][$j][$z] = array_shift($used[$z][floor($j / 5) * 10 + $i ]);
                    }
                }
            }
            $result[] = $table;
        }

        return $result;
  
    }     
 
     /* Strip 1x5 Random */ 
    public function bigLayerMutationStripSmallRandom5x1Y($numbers, $size, $pop) {

        for ($i = 0; $i < $size; $i++) {
            $res[$i] = array_fill(0, 20, []);
        }
 
        for ($i = 0; $i < $size; $i++) {
           for ($j = 0; $j < $size; $j++) {
                for ($z = 0; $z < $size; $z++) {
                    $res[$z][ floor($j / 5) * 10 + $i ][] = $pop[$i][$j][$z];
                }
            }
        }  

 
        $result = [$pop];
 
        for ($n = 0; $n < $numbers; $n++) {
            $used = $res;
            $table = [];
            for ($k = 0; $k < $size; $k++) { 
                for ($g = 0; $g < 20; $g++) {
                    $go = rand(0, 100);
                    if ($go <= 20) { 
                        shuffle($used[$k][$g]);
                    }
                } 
            }
  
            for ($i = 0; $i < $size; $i++) {
                for ($j = 0; $j < $size; $j++) {
                    for ($z = 0; $z < $size; $z++) {
                        $table[$i][$j][$z] = array_shift($used[$z][floor($j / 5) * 10 + $i ]);
                    }
                }
            }
            $result[] = $table;
        }

        return $result;
  
    }  

     /* Strip 1x5 Random */ 
    public function bigLayerMutationStripVerySmallRandom5x1Y($numbers, $size, $pop) {

        for ($i = 0; $i < $size; $i++) {
            $res[$i] = array_fill(0, 20, []);
        }
 
        for ($i = 0; $i < $size; $i++) {
           for ($j = 0; $j < $size; $j++) {
                for ($z = 0; $z < $size; $z++) {
                    $res[$z][ floor($j / 5) * 10 + $i ][] = $pop[$i][$j][$z];
                }
            }
        }  

 
        $result = [$pop];
 
        for ($n = 0; $n < $numbers; $n++) {
            $used = $res;
            $table = [];
            for ($k = 0; $k < $size; $k++) { 
                for ($g = 0; $g < 20; $g++) {
                    $go = rand(0, 100);
                    if ($go <= 10) { 
                        shuffle($used[$k][$g]);
                    }
                } 
            }
  
            for ($i = 0; $i < $size; $i++) {
                for ($j = 0; $j < $size; $j++) {
                    for ($z = 0; $z < $size; $z++) {
                        $table[$i][$j][$z] = array_shift($used[$z][floor($j / 5) * 10 + $i ]);
                    }
                }
            }
            $result[] = $table;
        }

        return $result;
  
    }  
 
     /* Strip 5x1 Random */ 
    public function bigLayerMutationStripVerySmallRandom5x1X($numbers, $size, $pop) {

        for ($i = 0; $i < $size; $i++) {
            $res[$i] = array_fill(0, 20, []);
        }
 
        for ($i = 0; $i < $size; $i++) {
           for ($j = 0; $j < $size; $j++) {
                for ($z = 0; $z < $size; $z++) {
                    $res[$z][ floor($i / 5) * 10 + $j][] = $pop[$i][$j][$z];
                }
            }
        }  

        $result = [$pop];
 
        for ($n = 0; $n < $numbers; $n++) {
            $used = $res;
            $table = [];
            for ($k = 0; $k < $size; $k++) { 
                for ($g = 0; $g < 20; $g++) {
                    $go = rand(0, 100);
                    if ($go <= 10) { 
                       shuffle($used[$k][$g]);  
                    }
                } 
            }
  
            for ($i = 0; $i < $size; $i++) {
                for ($j = 0; $j < $size; $j++) {
                    for ($z = 0; $z < $size; $z++) {
                        $table[$i][$j][$z] = array_shift($used[$z][floor($i / 5) * 10 + $j]);
                    }
                }
            }
            $result[] = $table;
        }

        return $result;
  
    }


     /* 2 x 2 Random */ 
    public function bigLayerMutationMiniVerySmallRandomSquere($numbers, $size, $pop) {

        for ($i = 0; $i < $size; $i++) {
            $res[$i] = array_fill(0, 25, []);
        }
 
        for ($i = 0; $i < $size; $i++) {
           for ($j = 0; $j < $size; $j++) {
                for ($z = 0; $z < $size; $z++) {
                    $res[$z][ floor($i / 2) * 5 + floor($j / 2)][] = $pop[$i][$j][$z];
                }
            }
        }  

        $result = [$pop];
 
        for ($n = 0; $n < $numbers; $n++) {
            $used = $res;
            $table = [];
            for ($k = 0; $k < $size; $k++) { 
                for ($g = 0; $g < 25; $g++) {
                    $go = rand(0, 100);
                    if ($go <= 10) {
                       shuffle($used[$k][$g]);
                    }  
                } 
            }
  
            for ($i = 0; $i < $size; $i++) {
                for ($j = 0; $j < $size; $j++) {
                    for ($z = 0; $z < $size; $z++) {
                        $table[$i][$j][$z] = array_shift($used[$z][floor($i / 2) * 5 + floor($j / 2)]);
                    }
                }
            }
            $result[] = $table;
        }

        return $result;
  
    }     


     /* +++ */ 
    public function bigLayerMutationTemplatePlusRandom($numbers, $size, $pop) {
 
        $result = [$pop];
        for ($n = 0; $n < $numbers; $n++) {
 
            $table = $pop;
 
            for ($z = 0; $z < $size; $z++) {
                $change = rand(1, 10);
                for ($ch = 0; $ch < $change; $ch++) {
                    $x = rand(1, $size-2);
                    $y = rand(1, $size-2);

                    $used = [$pop[$x - 1][$y][$z], $pop[$x][$y - 1][$z], $pop[$x][$y][$z], $pop[$x + 1][$y][$z], $pop[$x][$y + 1][$z]];
                    shuffle($used);
                    $table[$x - 1][$y][$z] = $used[0];
                    $table[$x][$y - 1][$z] = $used[1]; 
                    $table[$x][$y][$z] = $used[2]; 
                    $table[$x + 1][$y][$z] = $used[3]; 
                    $table[$x][$y + 1][$z] = $used[4]; 
                }
            }
 
            $result[] = $table;
        }

        return $result;
  
    }   

     /*  squere 3 x 3 */ 
    public function bigLayerMutationTSquare3x3xRandom($numbers, $size, $pop) {
 
        $result = [$pop];
        for ($n = 0; $n < $numbers; $n++) {
 
            $table = $pop;
 
            for ($z = 0; $z < $size; $z++) {
                $change = rand(1, 10);
                for ($ch = 0; $ch < $change; $ch++) {
                    $x = rand(0, $size - 3);
                    $y = rand(0, $size - 3);
 
                    $used = [];
                    for ($m = 0; $m < 3; $m++) {
                        for ($n = 0; $n < 3; $n++) {
                            $used[] = $pop[$x + $m][$y + $n][$z];
                        }
                    }
               
                    shuffle($used);
                    for ($m = 0; $m < 3; $m++) {
                        for ($n = 0; $n < 3; $n++) {
                            $table[$x + $m][$y + $n][$z] = array_shift($used);
                        }
                    }
                }
            }
 
            $result[] = $table;
        }

        return $result;
  
    } 
 
     /*  squere 4 x 4 */ 
    public function bigLayerMutationTSquare4x4xRandom($numbers, $size, $pop) {
 
        $result = [$pop];
        for ($n = 0; $n < $numbers; $n++) {
 
            $table = $pop;
 
            for ($z = 0; $z < $size; $z++) {
                $change = rand(1, 2);
                for ($ch = 0; $ch < $change; $ch++) {
                    $x = rand(0, $size - 4);
                    $y = rand(0, $size - 4);
 
                    $used = [];
                    for ($m = 0; $m < 4; $m++) {
                        for ($n = 0; $n < 4; $n++) {
                            $used[] = $pop[$x + $m][$y + $n][$z];
                        }
                    }
               
                    shuffle($used);
                    for ($m = 0; $m < 4; $m++) {
                        for ($n = 0; $n < 4; $n++) {
                            $table[$x + $m][$y + $n][$z] = array_shift($used);
                        }
                    }
                }
            }
 
            $result[] = $table;
        }

        return $result;
  
    } 


     /*  squere 2 x 2 */ 
    public function bigLayerMutationTSquare2x2xRandom($numbers, $size, $pop) {
 
        $result = [$pop];
        for ($n = 0; $n < $numbers; $n++) {
 
            $table = $pop;
 
            for ($z = 0; $z < $size; $z++) {
                $change = rand(1, 10);
                for ($ch = 0; $ch < $change; $ch++) {
                    $x = rand(0, $size - 2);
                    $y = rand(0, $size - 2);
 
                    $used = [];
                    for ($m = 0; $m < 2; $m++) {
                        for ($n = 0; $n < 2; $n++) {
                            $used[] = $pop[$x + $m][$y + $n][$z];
                        }
                    }
               
                    shuffle($used);
                    for ($m = 0; $m < 2; $m++) {
                        for ($n = 0; $n < 2; $n++) {
                            $table[$x + $m][$y + $n][$z] = array_shift($used);
                        }
                    }
                }
            }
 
            $result[] = $table;
        }

        return $result;
  
    }     

  
    public function bigLayerMutationCircle($numbers, $size, $pop) {
      $result = [$pop];
        for ($n = 0; $n < $numbers; $n++) {
            $table = $pop;

            for ($z = 0; $z < $size; $z++) {
                $x = rand(0, $size - 1);
                $y = rand(0, $size - 1);

                $length = rand(1, floor($size/2));
                $changePoints = rand(2, 10); 
                $used = [];
                $usedp = [];
                $points = [];
                for ($i = 0; $i < $changePoints; $i++) {
                    $diffx = rand(0, $length);
                    $random = ceil($length / 3);
                    $diffy = $length - $diffx + rand(-$random, $random);
                    $up = rand(0, 1);
                    $le = rand(0, 1);
                    if ($up == 1) {
                        $diffy *= -1;
                    }
                    if ($le == 1) {
                        $diffx *= -1;
                    }
                    $newx = $x -  $diffx;
                    $newy = $y - $diffy;
                    $key = $newx."-".$newy; 
                    if ($newx >= 0 && $newx < $size &&  $newy >= 0 && $newy < $size && !isset($usedp[$key]) ) {
                       $p = ['x' => $newx, 'y' => $newy ];
                       $usedp[] = $key;
                       $points[] = $p;
                       $used[] = $pop[$newx][$newy][$z];
                    } else {
                       $ch = rand(0,1);
                       if ($ch == 1) {
                          $changePoints--;
                       }
                    } 
                }
                shuffle($used);
                $d = count($used);
                for ($l = 0; $l < $d; $l++) {
                    $newx = $points[$l][$x];
                    $newy = $points[$l][$y];
                    $table[$newx][$newy][$z] = array_shift($used);
                } 
            }
            $result[] = $table;
        }

        return $result;            
    }


}