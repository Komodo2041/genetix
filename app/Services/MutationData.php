<?php

namespace App\Services;
 
class MutationData
{

    public $nrmutation = 60;    

    public function addmutation($pop) {
       $max = count($pop);
      
       $methods = ["goup1x1", "godown1x1", "goupanddown1x1", "changecolumnXY" , "changecolumnXZ" , "changecolumnYZ" ];
       $choosemutation = rand(0, 4);
       if ($choosemutation == 2) {
            $methods = [ "shufflecolumnXY" , "shufflecolumnXZ" , "shufflecolumnYZ", "changeRand4x4", "changeRand9x9", "changeRand16x16" ];
       } elseif ($choosemutation == 1) {
            $methods = [ "neighbourchange10" ,  "neighbourchange5" ,   "neighbourchange",  "shuffleRand4x4", "shuffleRand9x9", "shuffleRand16x16" ];
       }  elseif ($choosemutation == 3) {
            $methods = [ "exchangecolumnXY" , "exchangecolumnXZ" , "exchangecolumnYZ", "exchangefarcolumnXY" , "exchangefarcolumnXZ" , "exchangefarcolumnYZ" ];
       }   


       foreach ($methods AS $m) {
          for ($i = 0; $i < $this->nrmutation; $i++) {
            $go = rand(0, $max - 1); 
            $area = $this->$m($pop[$go]);
            $pop[] = $area;
          }
       }
       
       return $pop;
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


}