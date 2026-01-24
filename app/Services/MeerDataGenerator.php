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
        
       $level = rand(0,9);
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
 




    


}