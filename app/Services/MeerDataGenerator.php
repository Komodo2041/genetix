<?php

namespace App\Services;

class MeerDataGenerator
{
    
    public float $G = 6.67430e-11; // 
    public $probe = 10000;
    public $block = 1e6;


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


    public function calcPoints($nrPoints) {
 
        
    
        $point = ['x' => rand(0,1000), 'y' => rand(0,1000), 'z' => rand(0,10000)];
        
        $dist = calcDist($point, $i, $j, $k);

          $force = $this->block * $this->block * $this->G;
           
          $dist = 100 * 100; 
          return $force / $dist;


    } 


    

    


}