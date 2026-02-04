<?php

namespace App\Services;
 
class MutationData
{

    public $nrmutation = 45;    

    public function addmutation($pop, $crossing) {
       $max = count($pop);
       $methods = [ "shufflecolumnXZ", "shufflecolumnYZ", "exchangecolumnXY", "exchangecolumnXZ", "shufflecolumnYZgo6", "shufflecolumnXZgo6" ];
       $choosemutation = rand(0, 1);
       if ($choosemutation == 1) {   
            $methods = [ "shufflecolumnYZgo4", "shufflecolumnXYgo4", "shufflecolumnXZgo4", "changecolumnXYgo4", "changecolumnXZgo4", "changecolumnYZgo4" ];   
       }

       $choosemutation = rand(0, 12);
       if ($choosemutation == 5 || $choosemutation == 6 || $choosemutation == 7) {
          $methods = [ "shufflecolumnXYgo6", "changecolumnXYgo6", "changecolumnXZgo6", "changecolumnYZgo6", "changecolumnXZ" , "changecolumnYZ"];
       } elseif ($choosemutation == 8 || $choosemutation == 9) {
            $methods = ["goupanddown1x1", "goup1x1", "exchangefarcolumnXZ", "exchangecolumnYZ", "exchangefarcolumnXY", "neighbourchange"]; 
       } elseif ($choosemutation == 10 || $choosemutation == 11) {
             $methods = ["shuffleRand4x4", "changeRand4x4", "shuffleRand16x16", "exchangefarcolumnYZ", "shuffleRand9x9", "godown1x1"];
       }  elseif ($choosemutation == 12) {            
            $methods = ["shufflecolumnXY", "changecolumnXY", "neighbourchange10", "changeRand16x16", "neighbourchange5", "changeRand9x9" ];
       }   


       foreach ($methods AS $m) {
          for ($i = 0; $i < $this->nrmutation; $i++) {
            $go = rand(0, $max - 1); 
            $area = $this->$m($pop[$go]);
            $pop[] = $area;
            $crossing[] = $m;
          }
       }
       
       return [$pop, $crossing];
    }

    private function godown1x1($pop, $nr = 10) {
       $x = rand(0, $nr - 1);
       $y = rand(0, $nr - 1);
       $z = rand(0, $nr - 1);
       $pop[$x][$y][$z] = 0;
       return  $pop;
    }

    private function goup1x1($pop, $nr = 10) {
       $x = rand(0, $nr - 1);
       $y = rand(0, $nr - 1);
       $z = rand(0, $nr - 1);
       $pop[$x][$y][$z] = 1;
       return  $pop;
    }    

    private function goupanddown1x1($pop, $nr = 10) {
       $pop = $this->godown1x1($pop, $nr);
       $pop = $this->goup1x1($pop, $nr);
       return $pop; 
    }    

    private function changecolumnXY($pop, $nr = 10) {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);

        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                     if ($i == $pom1 && $j == $pom2) {
                        $pop[$i][$j][$z] = rand(0,1);
                     }
                }
            }
        }   
        return $pop;     

    }

    private function changecolumnXZ($pop, $nr = 10) {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);

        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                     if ($i == $pom1 && $z == $pom2) {
                        $pop[$i][$j][$z] = rand(0,1);
                     }
                }
            }
        }   
        return $pop;     

    }

    private function changecolumnYZ($pop, $nr = 10) {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);

        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                     if ($z == $pom1 && $j == $pom2) {
                        $pop[$i][$j][$z] = rand(0,1);
                     }
                }
            }
        }   
        return $pop;     

    }    


    private function shufflecolumnXY($pop, $nr = 10) {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                     if ($i == $pom1 && $j == $pom2) {
                        $used[] = $pop[$i][$j][$z];  
                     }
                }
            }
        }   
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                     if ($i == $pom1 && $j == $pom2) {
                         $pop[$i][$j][$z] = array_shift($used);
                     }
                }
            }
        }          
        return $pop;     

    }
   

    private function shufflecolumnXZ($pop, $nr = 10) {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                     if ($i == $pom1 && $z == $pom2) {
                        $used[] = $pop[$i][$j][$z];  
                     }
                }
            }
        }   
         shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                     if ($i == $pom1 && $z == $pom2) {
                         $pop[$i][$j][$z] = array_shift($used);
                     }
                }
            }
        }          
        return $pop;     

    }    

    private function shufflecolumnYZ($pop, $nr = 10) {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                     if ($j == $pom1 && $z == $pom2) {
                        $used[] = $pop[$i][$j][$z];  
                     }
                }
            }
        }   
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                     if ($j == $pom1 && $z == $pom2) {
                         $pop[$i][$j][$z] = array_shift($used);
                     }
                }
            }
        }          
        return $pop;     

    }  


    private function changeRand4x4($pop, $nr = 10) {
        $pom1 = rand(0, $nr - 2);
        $pom2 = rand(0, $nr - 2);
        $pom3 = rand(0, $nr - 2);

        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                     if (($i == $pom1 && $i <= $pom1 + 1 )
                          && ($j == $pom2 && $j <= $pom2 + 1 )
                          && ($z == $pom3 && $z <= $pom3 + 1 )) {
                          $pop[$i][$j][$z] = rand(0,1);
                     }
                }
            }
        }   
        return $pop;     

    }   
 
    private function changeRand9x9($pop, $nr = 10) {
        $pom1 = rand(0, $nr - 3);
        $pom2 = rand(0, $nr - 3);
        $pom3 = rand(0, $nr - 3);

        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                     if (($i == $pom1 && $i <= $pom1 + 2 )
                          && ($j == $pom2 && $j <= $pom2 + 2 )
                          && ($z == $pom3 && $z <= $pom3 + 2 )) {
                          $pop[$i][$j][$z] = rand(0,1);
                     }
                }
            }
        }   
        return $pop;     

    }   
    
    private function changeRand16x16($pop, $nr = 10) {
        $pom1 = rand(0, $nr - 4);
        $pom2 = rand(0, $nr - 4);
        $pom3 = rand(0, $nr - 4);

        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                     if (($i == $pom1 && $i <= $pom1 + 3 )
                          && ($j == $pom2 && $j <= $pom2 + 3 )
                          && ($z == $pom3 && $z <= $pom3 + 3 )) {
                          $pop[$i][$j][$z] = rand(0,1);
                     }
                }
            }
        }   
        return $pop;     

    }      
    
    private function shuffleRand4x4($pop, $nr = 10) {
        $pom1 = rand(0, $nr - 2);
        $pom2 = rand(0, $nr - 2);
        $pom3 = rand(0, $nr - 2);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                     if (($i == $pom1 && $i <= $pom1 + 1 )
                          && ($j == $pom2 && $j <= $pom2 + 1 )
                          && ($z == $pom3 && $z <= $pom3 + 1 )) {
                          $used[] = $pop[$i][$j][$z];
                     }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                     if (($i == $pom1 && $i <= $pom1 + 1 )
                          && ($j == $pom2 && $j <= $pom2 + 1 )
                          && ($z == $pom3 && $z <= $pom3 + 1 )) {
                          $pop[$i][$j][$z] = array_shift($used);
                     }
                }
            }
        }
 
        return $pop;     

    }   

    private function shuffleRand9x9($pop, $nr = 10) {
        $pom1 = rand(0, $nr - 3);
        $pom2 = rand(0, $nr - 3);
        $pom3 = rand(0, $nr - 3);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                     if (($i == $pom1 && $i <= $pom1 + 2 )
                          && ($j == $pom2 && $j <= $pom2 + 2 )
                          && ($z == $pom3 && $z <= $pom3 + 2 )) {
                           $used[] = $pop[$i][$j][$z];
                     }
                }
            }
        }   
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                     if (($i == $pom1 && $i <= $pom1 + 2 )
                          && ($j == $pom2 && $j <= $pom2 + 2 )
                          && ($z == $pom3 && $z <= $pom3 + 2 )) {
                            $pop[$i][$j][$z] = array_shift($used);
                     }
                }
            }
        }   

        return $pop;     

    }  


    private function shuffleRand16x16($pop, $nr = 10) {
        $pom1 = rand(0, $nr - 4);
        $pom2 = rand(0, $nr - 4);
        $pom3 = rand(0, $nr - 4);
         $used = [];

        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                     if (($i == $pom1 && $i <= $pom1 + 3 )
                          && ($j == $pom2 && $j <= $pom2 + 3 )
                          && ($z == $pom3 && $z <= $pom3 + 3 )) {
                          $used[] = $pop[$i][$j][$z];
                     }
                }
            }
        }   
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                     if (($i == $pom1 && $i <= $pom1 + 3 )
                          && ($j == $pom2 && $j <= $pom2 + 3 )
                          && ($z == $pom3 && $z <= $pom3 + 3 )) {
                         $pop[$i][$j][$z] = array_shift($used);
                     }
                }
            }
        }          
        return $pop;     

    }      

 
    private function neighbourchange($pop, $nr = 10) {
        $pom1 = rand(1, $nr - 2);
        $pom2 = rand(1, $nr - 2);
        $pom3 = rand(1, $nr - 2);

        $changex = rand(-1, 1);
        $changey = rand(-1, 1);
        $changez = rand(-1, 1);

        $pom = $pop[$pom1][$pom2][$pom3]; 
        $pop[$pom1][$pom2][$pom3] = $pop[$pom1 + $changex][$pom2 + $changey][$pom3 + $changez];
        $pop[$pom1 + $changex][$pom2 + $changey][$pom3 + $changez] = $pom;

        return $pop;     

    }    

    private function neighbourchange5($pop, $nr = 10) {
       for ($i = 0; $i < 5; $i++) {
          $pop = $this->neighbourchange($pop, $nr);
       }
       return $pop;
    }

    private function neighbourchange10($pop, $nr = 10) {
       for ($i = 0; $i < 10; $i++) {
          $pop = $this->neighbourchange($pop, $nr);
       }
       return $pop;
    }    
 
 
 
    private function exchangecolumnXZ($pop, $nr = 10) {
        $pom1 = rand(1, $nr - 3);
        $pom2 = rand(1, $nr - 3);
        $used = 0;

        $changepom1 = rand(-1, 1);
        $changepom2 = rand(-1, 1);

        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                     if ($i == $pom1 && $z == $pom2) {
                        $used = $pop[$i][$j][$z];
                        $pop[$i][$j][$z] = $pop[$i + $changepom1][$j][$z + $changepom2];
                        $pop[$i + $changepom1][$j][$z + $changepom2] = $used;
                     }
                }
            }
        }
        return $pop;
    }     

    private function exchangecolumnXY($pop, $nr = 10) {
        $pom1 = rand(1, $nr - 3);
        $pom2 = rand(1, $nr - 3);
        $used = 0;

        $changepom1 = rand(-1, 1);
        $changepom2 = rand(-1, 1);

        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                     if ($i == $pom1 && $j == $pom2) {
                        $used = $pop[$i][$j][$z];
                        $pop[$i][$j][$z] = $pop[$i + $changepom1][$j + $changepom2][$z];
                        $pop[$i + $changepom1][$j + $changepom2][$z] = $used;
                     }
                }
            }
        }
        return $pop;
    }   

    private function exchangecolumnYZ($pop, $nr = 10) {
        $pom1 = rand(1, $nr - 3);
        $pom2 = rand(1, $nr - 3);
        $used = 0;

        $changepom1 = rand(-1, 1);
        $changepom2 = rand(-1, 1);

        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                     if ($j == $pom1 && $z == $pom2) {
                        $used = $pop[$i][$j][$z];
                        $pop[$i][$j][$z] = $pop[$i][$j + $changepom1][$z + $changepom2];
                        $pop[$i][$j + $changepom1][$z + $changepom2] = $used;
                     }
                }
            }
        }
        return $pop;
    }


    private function exchangefarcolumnXZ($pop, $nr = 10) {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $used = 0;

        $changepom1 = rand(0, $nr - 1);
        $changepom2 = rand(0, $nr - 1);

        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                     if ($i == $pom1 && $z == $pom2) {
                        $used = $pop[$i][$j][$z];
                        $pop[$i][$j][$z] = $pop[$changepom1][$j][$changepom2];
                        $pop[$changepom1][$j][$changepom2] = $used;
                     }
                }
            }
        }
        return $pop;
    }

    private function exchangefarcolumnXY($pop, $nr = 10) {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $used = 0;

        $changepom1 = rand(0, $nr - 1);
        $changepom2 = rand(0, $nr - 1);

        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                     if ($i == $pom1 && $j == $pom2) {
                        $used = $pop[$i][$j][$z];
                        $pop[$i][$j][$z] = $pop[$changepom1][$changepom2][$z];
                        $pop[$changepom1][$changepom2][$z] = $used;
                     }
                }
            }
        }
        return $pop;
    }

    private function exchangefarcolumnYZ($pop, $nr = 10) {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $used = 0;

        $changepom1 = rand(0, $nr - 1);
        $changepom2 = rand(0, $nr - 1);

        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                     if ($j == $pom1 && $z == $pom2) {
                        $used = $pop[$i][$j][$z];
                        $pop[$i][$j][$z] = $pop[$i][$changepom1][$changepom2];
                        $pop[$i][$changepom1][$changepom2] = $used;
                     }
                }
            }
        }
        return $pop;
    }
 
    private function changecolumnYZgo6($pop, $nr = 10) {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $pom3 = rand(0, 3);

        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                     if ($z == $pom1 && $j == $pom2 && ( $pom3 < $i && $pom3 + 6 >= $i) ) {
                        $pop[$i][$j][$z] = rand(0,1);
                     }
                }
            }
        }   
        return $pop;     

    } 
 
    private function changecolumnXZgo6($pop, $nr = 10) {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $pom3 = rand(0, 3);

        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                     if ($i == $pom1 && $j == $pom2  && ( $pom3 < $z && $pom3 + 6 >= $z)) {
                        $pop[$i][$j][$z] = rand(0,1);
                     }
                }
            }
        }   
        return $pop;     

    }     
 
    private function changecolumnXYgo6($pop, $nr = 10) {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $pom3 = rand(0, 3);

        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                     if ($z == $pom1 && $i == $pom2 && ( $pom3 < $j && $pom3 + 6 >= $j)) {
                        $pop[$i][$j][$z] = rand(0,1);
                     }
                }
            }
        }   
        return $pop;     

    }
 
    private function shufflecolumnXZgo6($pop, $nr = 10) {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $pom3 = rand(0, 3);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                     if ($i == $pom1 && $z == $pom2 && ( $pom3 < $j && $pom3 + 6 >= $j)) {
                        $used[] = $pop[$i][$j][$z];  
                     }
                }
            }
        }   
         shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                     if ($i == $pom1 && $z == $pom2 && ( $pom3 < $j && $pom3 + 6 >= $j)) {
                         $pop[$i][$j][$z] = array_shift($used);
                     }
                }
            }
        }          
        return $pop;     

    }
 
    private function shufflecolumnXYgo6($pop, $nr = 10) {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $pom3 = rand(0, 3);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                     if ($i == $pom1 && $j == $pom2 && ( $pom3 < $z && $pom3 + 6 >= $z)) {
                        $used[] = $pop[$i][$j][$z];  
                     }
                }
            }
        }   
         shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                     if ($i == $pom1 && $j == $pom2 && ( $pom3 < $z && $pom3 + 6 >= $z)) {
                         $pop[$i][$j][$z] = array_shift($used);
                     }
                }
            }
        }          
        return $pop;     

    }  

    private function shufflecolumnYZgo6($pop, $nr = 10) {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $pom3 = rand(0, 3);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                     if ($j == $pom1 && $z == $pom2 && ( $pom3 < $i && $pom3 + 6 >= $i)) {
                        $used[] = $pop[$i][$j][$z];  
                     }
                }
            }
        }   
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                     if ($j == $pom1 && $z == $pom2 && ( $pom3 < $i && $pom3 + 6 >= $i)) {
                         $pop[$i][$j][$z] = array_shift($used);
                     }
                }
            }
        }          
        return $pop;     

    }      
 
    private function changecolumnYZgo4($pop, $nr = 10) {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $pom3 = rand(0, 5);

        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                     if ($z == $pom1 && $j == $pom2 && ( $pom3 < $i && $pom3 + 4 >= $i) ) {
                        $pop[$i][$j][$z] = rand(0,1);
                     }
                }
            }
        }   
        return $pop;     

    } 
  
    private function changecolumnXZgo4($pop, $nr = 10) {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $pom3 = rand(0, 5);

        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                     if ($i == $pom1 && $j == $pom2  && ( $pom3 < $z && $pom3 + 4 >= $z)) {
                        $pop[$i][$j][$z] = rand(0,1);
                     }
                }
            }
        }   
        return $pop;     

    }     
  
    private function changecolumnXYgo4($pop, $nr = 10) {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $pom3 = rand(0, 5);

        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                     if ($z == $pom1 && $i == $pom2 && ( $pom3 < $j && $pom3 + 4 >= $j)) {
                        $pop[$i][$j][$z] = rand(0,1);
                     }
                }
            }
        }   
        return $pop;     

    }
  
    private function shufflecolumnXZgo4($pop, $nr = 10) {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $pom3 = rand(0, 5);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                     if ($i == $pom1 && $z == $pom2 && ( $pom3 < $j && $pom3 + 4 >= $j)) {
                        $used[] = $pop[$i][$j][$z];  
                     }
                }
            }
        }   
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                     if ($i == $pom1 && $z == $pom2 && ( $pom3 < $j && $pom3 + 4 >= $j)) {
                         $pop[$i][$j][$z] = array_shift($used);
                     }
                }
            }
        }          
        return $pop;     

    }
  
    private function shufflecolumnXYgo4($pop, $nr = 10) {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $pom3 = rand(0, 5);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                     if ($i == $pom1 && $j == $pom2 && ( $pom3 < $z && $pom3 + 4 >= $z)) {
                        $used[] = $pop[$i][$j][$z];  
                     }
                }
            }
        }   
         shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                     if ($i == $pom1 && $j == $pom2 && ( $pom3 < $z && $pom3 + 4 >= $z)) {
                         $pop[$i][$j][$z] = array_shift($used);
                     }
                }
            }
        }          
        return $pop;     

    }  

    private function shufflecolumnYZgo4($pop, $nr = 10) {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $pom3 = rand(0, 5);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                     if ($j == $pom1 && $z == $pom2 && ( $pom3 < $i && $pom3 + 4 >= $i)) {
                        $used[] = $pop[$i][$j][$z];  
                     }
                }
            }
        }   
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                     if ($j == $pom1 && $z == $pom2 && ( $pom3 < $i && $pom3 + 4 >= $i)) {
                         $pop[$i][$j][$z] = array_shift($used);
                     }
                }
            }
        }          
        return $pop;     

    }   


    public function getAllMethod() {
       $methods = ["goup1x1", "godown1x1", "goupanddown1x1", "changecolumnXY" , "changecolumnXZ" , "changecolumnYZ" ];
       $methods2 = [ "shufflecolumnXY" , "shufflecolumnXZ" , "shufflecolumnYZ", "changeRand4x4", "changeRand9x9", "changeRand16x16" ];
       $methods3 = [ "neighbourchange10" ,  "neighbourchange5" ,   "neighbourchange",  "shuffleRand4x4", "shuffleRand9x9", "shuffleRand16x16" ];
       $methods4 = [ "exchangecolumnXY" , "exchangecolumnXZ" , "exchangecolumnYZ", "exchangefarcolumnXY" , "exchangefarcolumnXZ" , "exchangefarcolumnYZ" ];
       $methods5 = ["shufflecolumnYZgo6", "shufflecolumnXYgo6", "shufflecolumnXZgo6", "changecolumnXYgo6", "changecolumnXZgo6", "changecolumnYZgo6"];
       $methods6 = [ "shufflecolumnYZgo4", "shufflecolumnXYgo4", "shufflecolumnXZgo4", "changecolumnXYgo4", "changecolumnXZgo4", "changecolumnYZgo4" ]; 
       return array_merge($methods, $methods2, $methods3, $methods4, $methods5, $methods6);         
              
    }

}