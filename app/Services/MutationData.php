<?php

namespace App\Services;
 
class MutationData
{

    public $nrmutation = 100;    

    public function addmutation($pop) {
       $max = count($pop);
       echo "Populacja do muatacji ".$max."<br/>";
       $methods = ["goup1x1", "godown1x1", "goupanddown1x1", "changecolumnXY" /*, "changecolumnXZ", "changecolumnYZ" */];
       foreach ($methods AS $m) {
          for ($i = 0; $i < $this->nrmutation; $i++) {
            $go = rand(0, $max - 1); 
            $area = $this->$m($pop[$go]);
            $pop[] = $area;
          }
       }
        echo "Populacja po muatacji ".count($pop)."<br/>";
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


}