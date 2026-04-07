<?php

namespace App\Services;
 
class MutationData
{

    public $nrmutation = 270;    

    private $mutationList = [
        "shufflecolumnXZ", "shufflecolumnYZ", "exchangecolumnXY", "exchangecolumnXZ", "shufflecolumnYZgo6", "shufflecolumnXZgo6",
        "mirrorXY", "mirrorXZ", "mirrorYZ", "mirrorXY_d", "mirrorXZ_d", "mirrorYZ_d",
        "clockwiseXYleft", "clockwiseXZleft", "clockwiseYZleft", "clockwiseXYright", "clockwiseXZright", "clockwiseYZright",
        "shufflecolumnYZgo4", "shufflecolumnXYgo4", "shufflecolumnXZgo4", "changecolumnXYgo4", "changecolumnXZgo4", "changecolumnYZgo4",
        "shufflecolumnXYgo6", "changecolumnXYgo6", "changecolumnXZgo6", "changecolumnYZgo6", "changecolumnXZ" , "changecolumnYZ",
        "goupanddown1x1", "goup1x1", "exchangefarcolumnXZ", "exchangecolumnYZ", "exchangefarcolumnXY", "neighbourchange",
        "shuffleRand4x4", "changeRand4x4", "shuffleRand16x16", "exchangefarcolumnYZ", "shuffleRand9x9", "godown1x1",
        "shufflecolumnXY", "changecolumnXY", "neighbourchange10", "changeRand16x16", "neighbourchange5", "changeRand9x9",
        "changeOneLayerZ", "changeOneLayerX", "changeOneLayerY", "changeOneLayerZ2", "changeOneLayerX2", "changeOneLayerY2",
        "jointwopointsZ", "dividepointsZ", "jointwopointsZ5", "dividepointsZ5", "mixingLayers",
        "mixingVerticalLayersZ", "mixingVerticalLayersX", "mixingVerticalLayersY"
    ];

    public function addmutation($pop, $crossing, $method = NULL) {

       $max = count($pop);
       $mutationList = $this->mutationList;
       if ($method) {
            $mutationList = [$method];
       }
       $nrmed = count($mutationList) - 1;

       for ($i = 0; $i < $this->nrmutation; $i++) {
            $go = rand(0, $max - 1);
            $m = $mutationList[rand(0, $nrmed)];   
            $area = $this->$m($pop[$go]);
            $pop[] = $area;
            $crossing[] = $m;
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


    private function clockwiseXYleft($pop, $nr = 10) {
        $pom = rand(0, $nr - 1);
        $pop2 = $pop;
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) { 
                     if ($i == $pom) {
                        $pop2[$i][$j][$z] = $pop[$i][$z][$nr - $j - 1];
                     }
                }
            }
        }   
        return $pop2;     

    }      

    private function clockwiseXZleft($pop, $nr = 10) {
        $pom = rand(0, $nr - 1);
        $pop2 = $pop;
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) { 
                     if ($j == $pom) {
                        $pop2[$i][$j][$z] = $pop[$z][$j][$nr - $i - 1];
                     }
                }
            }
        }   
        return $pop2;     

    }   
    
    private function clockwiseYZleft($pop, $nr = 10) {
        $pom = rand(0, $nr - 1);
        $pop2 = $pop;
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) { 
                     if ($z == $pom) {
                        $pop2[$i][$j][$z] = $pop[$j][$nr - $i - 1][$z];
                     }
                }
            }
        }   
        return $pop2;     

    }       

    private function clockwiseXYright($pop, $nr = 10) {
        $pom = rand(0, $nr - 1);
        $pop2 = $pop;
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) { 
                     if ($i == $pom) {
                        $pop2[$i][$j][$z] =  $pop[$i][$nr - $z - 1][$j];
                     }
                }
            }
        }   
        return $pop2;     

    }      

    private function clockwiseXZright($pop, $nr = 10) {
        $pom = rand(0, $nr - 1);
        $pop2 = $pop;
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) { 
                     if ($j == $pom) {
                        $pop2[$i][$j][$z] = $pop[$nr - 1 - $z][$j][$i];
                     }
                }
            }
        }   
        return $pop2;     

    }   
    
    private function clockwiseYZright($pop, $nr = 10) {
        $pom = rand(0, $nr - 1);
        $pop2 = $pop;
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) { 
                     if ($z == $pom) {
                        $pop2[$i][$j][$z] = $pop2[$nr - 1 - $j][$i][$z];
                     }
                }
            }
        }   
        return $pop2;     

    }   


    private function mirrorXY($pop, $nr = 10) {
        $pom = rand(0, $nr - 1);
        $pop2 = $pop;
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) { 
                     if ($z == $pom) {
                        $pop2[$i][$j][$z] = $pop[$i][$j][$nr - 1 - $z];
                     }
                }
            }
        }   
        return $pop2;     

    }     
    
    private function mirrorXZ($pop, $nr = 10) {
        $pom = rand(0, $nr - 1);
        $pop2 = $pop;
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) { 
                     if ($j == $pom) {
                        $pop2[$i][$j][$z] = $pop[$i][$nr - 1 - $j][$z];
                     }
                }
            }
        }   
        return $pop2;     

    }     
    
    private function mirrorYZ($pop, $nr = 10) {
        $pom = rand(0, $nr - 1);
        $pop2 = $pop;
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) { 
                     if ($i == $pom) {
                        $pop2[$i][$j][$z] = $pop[$nr - 1 - $i][$j][$z];
                     }
                }
            }
        }   
        return $pop2;     

    }
    
    
    private function mirrorXY_d($pop, $nr = 10) {
        $pom = rand(0, $nr - 1);
        $pop2 = $pop;
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) { 
                     if ($z == $pom) {
                        $pop2[$i][$j][$z] = $pop[$nr - 1 - $j][$nr - 1 - $i][$z];
                     }
                }
            }
        }   
        return $pop2;     

    }     
    
    private function mirrorXZ_d($pop, $nr = 10) {
        $pom = rand(0, $nr - 1);
        $pop2 = $pop;
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) { 
                     if ($j == $pom) {
                        $pop2[$i][$j][$z] = $pop[$nr - 1 - $z][$j][10 - 1 -$i];
                     }
                }
            }
        }   
        return $pop2;     

    }     
    
    private function mirrorYZ_d($pop, $nr = 10) {
        $pom = rand(0, $nr - 1);
        $pop2 = $pop;
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) { 
                     if ($i == $pom) {
                        $pop2[$i][$j][$z] = $pop[$i][$nr - 1 - $z][$nr - 1 - $j];
                     }
                }
            }
        }   
        return $pop2;     

    }

     
    private function changeOneLayerZ($pop, $nr = 10) {
      
       $pop2 = $pop;

       $z1 = rand(0, $nr - 1);
       $z2 = rand(0, $nr - 1);


       for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) { 
                    if ($z != $z1 && $z != $z2) {
                       $pop2[$i][$j][$z] = $pop[$i][$j][$z];
                    } elseif ($z1 == $z) {
                       $pop2[$i][$j][$z] = $pop[$i][$j][$z2];
                    } elseif ($z2 == $z) {
                       $pop2[$i][$j][$z] = $pop[$i][$j][$z1];
                    }
                    
                }
            }
       }   
       return $pop2;  
 
    }

    private function changeOneLayerX($pop, $nr = 10) {
      
       $pop2 = $pop;

       $p1 = rand(0, $nr - 1);
       $p2 = rand(0, $nr - 1);


       for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) { 
                    if ($i != $p1 && $i != $p2) {
                       $pop2[$i][$j][$z] = $pop[$i][$j][$z];
                    } elseif ($p1 == $i) {
                       $pop2[$i][$j][$z] = $pop[$p2][$j][$z];
                    } elseif ($p2 == $i) {
                       $pop2[$i][$j][$z] = $pop[$p1][$j][$z];
                    }
                    
                }
            }
       }   
       return $pop2;  
 
    }
    
    private function changeOneLayerY($pop, $nr = 10) {
      
       $pop2 = $pop;

       $p1 = rand(0, $nr - 1);
       $p2 = rand(0, $nr - 1);


       for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) { 
                    if ($j != $p1 && $j != $p2) {
                       $pop2[$i][$j][$z] = $pop[$i][$j][$z];
                    } elseif ($p1 == $j) {
                       $pop2[$i][$j][$z] = $pop[$i][$p2][$z];
                    } elseif ($p2 == $j) {
                       $pop2[$i][$j][$z] = $pop[$i][$p1][$z];
                    }
                    
                }
            }
       }   
       return $pop2;  
 
    }

    private function changeOneLayerZ2($pop, $nr = 10) {
       $p1 = rand(1, 5);
       $pop2 = $pop;
       for ($i = 0; $i < $p1; $i++) {
          $pop2 = $this->changeOneLayerZ($pop2, $nr);
       }
        return $pop2; 
    }

    private function changeOneLayerX2($pop, $nr = 10) {
       $p1 = rand(1, 5);
       $pop2 = $pop;
       for ($i = 0; $i < $p1; $i++) {
          $pop2 = $this->changeOneLayerX($pop2, $nr);
       }
        return $pop2; 
    }
    
    private function changeOneLayerY2($pop, $nr = 10) {
       $p1 = rand(1, 5);
       $pop2 = $pop;
       for ($i = 0; $i < $p1; $i++) {
          $pop2 = $this->changeOneLayerY($pop2, $nr);
       }
        return $pop2; 
    }    

    private function jointwopointsZ($pop, $nr = 10) {
        $min = 1;
        $pop2 = $pop;
        $point1 = $this->searchPoint(1, $pop, $nr, $min);
        $point2 = $this->searchPoint(1, $pop, $nr, $min);
        if ($point1 == false || $point2 == false) {
            return $pop2;
        }
        $point3 = $this->searchPoint(0, $pop, min($point1['z'], $point2['z']), 1);
         
        if ($point3 == false ) {
           return $pop2;
        }
        $pop2[$point1['x']][$point1['y']][$point1['z']] = 0;
        $pop2[$point2['x']][$point2['y']][$point2['z']] = 0;
        $pop2[$point3['x']][$point3['y']][$point3['z']] = 1;
        return $pop2;
    }

    private function dividepointsZ($pop, $nr = 10) {
        $min = 0;
        $pop2 = $pop;
        $point1 = $this->searchPoint(1, $pop, $nr, $min);
        if ($point1 == false ) {
           return $pop2;
        }        
        $point2 = $this->searchPoint(0, $pop, $nr, $point1['z']);
        $point3 = $this->searchPoint(0, $pop, $nr, $point1['z']);
      
        if ($point2 == false || $point3 == false ) {
           return $pop2;
        }
        $pop2[$point1['x']][$point1['y']][$point1['z']] = 0;
        $pop2[$point2['x']][$point2['y']][$point2['z']] = 1;
        $pop2[$point3['x']][$point3['y']][$point3['z']] = 1;
        return $pop2;
    }
 

    private function searchPoint($found, $pop, $max, $min) {
        $try = 0;
        $point = false; 
        while ($try < 20) {
            $x = rand(0, $max - 1);
            $y = rand(0, $max - 1);
            $z = rand($min, $max - 1);
            if ($pop[$x][$y][$z] == $found) {
               $point = ['x' => $x, 'y' => $y, 'z' => $z]; 
               break;
            }
            $try++;
        }
        return $point;
    }

    private function jointwopointsZ5($pop, $nr = 10) {
       $p1 = rand(1, 8);
       $pop2 = $pop;
       for ($i = 0; $i < $p1; $i++) {
          $pop2 = $this->jointwopointsZ($pop2, $nr);
       }
        return $pop2; 
    }

    private function dividepointsZ5($pop, $nr = 10) {
       $p1 = rand(1, 8);
       $pop2 = $pop;
       for ($i = 0; $i < $p1; $i++) {
          $pop2 = $this->dividepointsZ($pop2, $nr);
       }
        return $pop2; 
    }

    private function mixingLayers($pop, $nr = 10) {
        $pom1 = rand(0, $nr - 2);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                     if ($z == $pom1 || $z == $pom1 + 1 ) {
                        $used[] = $pop[$i][$j][$z];  
                     }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($z == $pom1 || $z == $pom1 + 1 ) {
                         $pop[$i][$j][$z] = array_shift($used);
                     }
                }
            }
        }
        return $pop;

    }

    private function mixingVerticalLayersX($pop, $nr = 10) {
        $pom1 = rand(0, $nr - 1);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                     if ($i == $pom1) {
                        $used[] = $pop[$i][$j][$z];  
                     }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i == $pom1 ) {
                         $pop[$i][$j][$z] = array_shift($used);
                     }
                }
            }
        }
        return $pop;

    }    

    private function mixingVerticalLayersY($pop, $nr = 10) {
        $pom1 = rand(0, $nr - 1);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                     if ($j == $pom1) {
                        $used[] = $pop[$i][$j][$z];  
                     }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($j == $pom1 ) {
                         $pop[$i][$j][$z] = array_shift($used);
                     }
                }
            }
        }
        return $pop;

    } 

    private function mixingVerticalLayersZ($pop, $nr = 10) {
        $pom1 = rand(0, $nr - 1);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                     if ($z == $pom1) {
                        $used[] = $pop[$i][$j][$z];  
                     }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($z == $pom1 ) {
                         $pop[$i][$j][$z] = array_shift($used);
                     }
                }
            }
        }
        return $pop;

    }     

    public function getAllMethod() {
       return $this->mutationList;       
    }

    public function changeMutationList($methods) {
        $this->mutationList = $methods;
    }

    public function setNrMutation($nr) {
        $this->nrmutation = $nr;
    }

}