<?php

namespace App\Services;

class MeerDataGenerator
{
 
    public function generateMeer($nr) {
        
       $level = rand(0,9);
       $table = [];
       for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
               for ($z = 0; $z < $nr; $z++) {
                   $vol = 0;
                   if ($z < $level) {
                      $vol = 1;
                   } elseif ($z > $level) {
                      $vol = 0;
                   } elseif ($z == $level) {
                       $vol = rand(0,1);
                   }
                   $table[$i][$j][$z] = $vol;
               }     
           }       
       }
       return ["name" => "Dno morza sz-".$nr, "data" => $table ];

    }

    public function generate0and1($nr) {
 
       $table = [];
       for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
               for ($z = 0; $z < $nr; $z++) { 
                   $table[$i][$j][$z] = rand(0,1);
               }     
           }       
       }
       return ["name" => "Obszar 0 i 1 - sz-".$nr, "data" => $table ];

    }
 


   public function generateprzekladaniecZ($nr) {
       $zlevel = [];
       for ($i = 0; $i < $nr; $i++) {
          $zlevel[$i] = rand(0,1);
       }

       $table = [];
       for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
               for ($z = 0; $z < $nr; $z++) { 
                   $table[$i][$j][$z] = $zlevel[$z];
               }
           }
       }
       return ["name" => "Przekladaniec Z sz-".$nr, "data" => $table ];

   }

   public function generateprzekladaniecX($nr) {
       $zlevel = [];
       for ($i = 0; $i < $nr; $i++) {
          $zlevel[$i] = rand(0,1);
       }

       $table = [];
       for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
               for ($z = 0; $z < $nr; $z++) { 
                   $table[$i][$j][$z] = $zlevel[$i];
               }
           }
       }
       return ["name" => "Przekladaniec X sz-".$nr, "data" => $table ];

   }   
    
    public function generateprzekladaniecY($nr) {
       $zlevel = [];
       for ($i = 0; $i < $nr; $i++) {
          $zlevel[$i] = rand(0,1);
       }

       $table = [];
       for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
               for ($z = 0; $z < $nr; $z++) { 
                   $table[$i][$j][$z] = $zlevel[$j];
               }
           }
       }
       return ["name" => "Przekladaniec Y sz-".$nr, "data" => $table ];

   }


    public function generateCave($nr) {
        
       $level = rand(0,9);
       $table = [];
       for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
               for ($z = 0; $z < $nr; $z++) {
                   $vol = 0;
                   if ($z > $level) {
                      $vol = 1;
                   } elseif ($z < $level) {
                      $vol = 0;
                   } elseif ($z == $level) {
                       $vol = rand(0,1);
                   }
                   $table[$i][$j][$z] = $vol;
               }     
           }       
       }
       return ["name" => "Jaskinia sz-".$nr, "data" => $table ];

    }   


   public function generateprze3otherLayerZ($nr) {
       $zlevel = [];
       for ($i = 0; $i < $nr; $i++) {
          $zlevel[$i] = rand(0,2);
       }

       $table = [];
       for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
               for ($z = 0; $z < $nr; $z++) {
                   if ($zlevel[$z] == 2) {
                      $table[$i][$j][$z] = rand(0, 1);
                   } else {
                      $table[$i][$j][$z] = $zlevel[$z];
                   }
               }
           }
       }
       return ["name" => "Przekladaniec Z sz-".$nr, "data" => $table ];

   }

     
}