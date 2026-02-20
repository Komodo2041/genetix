<?php

namespace App\Services;

 

class BigMutatorData
{
    
    public $numbers = 600;
    public $allMethods = ["bigLayerMutation", "bigLayerMutationMediumSquere", "bigLayerMutationMiniSquere", "bigLayerMutationMiniRandomSquere",
                "bigLayerMutationStripRandom5x1Y", "bigLayerMutationStripRandom5x1X", "bigLayerMutationStrip5x1Y", "bigLayerMutationStrip5x1X"];

    public function createNewPopulation($population) {
       $max = count($population);
       $res = $population;
       $mutting = [];
       $nrmethos = count($this->allMethods);

       for ($i = 0; $i < $this->numbers; $i++) {
 
            $ch = rand(0, $nrmethos-1);
            $m = $this->allMethods[$ch];
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



}