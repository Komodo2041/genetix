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


    public function calcPoints($nrPoints, $area) {
 
        
       $nr = 10;
       $point = ['x' => rand(0,1000), 'y' => rand(0,1000), 'z' => rand(0,10000)];
       $allPoints = [];
       for ($pon = 0; $pon < $nrPoints; $pon++) {
            $point = ['x' => rand(0,1000), 'y' => rand(0,1000), 'z' => rand(0,10000), 'v' => 0];
            $allForce = 0;       
            $probeforce = $this->block * $this->probe * $this->G;
            for ($i = 0; $i < $nr; $i++) {
                for ($j = 0; $j < $nr; $j++) {
                    for ($z = 0; $z < $nr; $z++) {
                        $dist = $this->calcDist($point, $i, $j, $z);
                        $force = $probeforce * $area[$i][$j][$z];
                        $force = $force / ($dist * $dist);
                        
                        $allForce += $force;
                    }
                }
            }
            $point['v'] = $allForce;
            $allPoints[] = $point;
       }  
      
       return $allPoints;
    } 


    private function calcDist($point, $i, $j, $k) {

       $downx = 50 * $i * 100;
       $downy = 50 * $j * 100;
       $downz = 50 * $k * 100;
       $diffx = abs($point['x'] - $downx);
       $diffy = abs($point['y'] - $downy);
       $diffz = abs($point['z'] - $downz);
       $downDagonal = sqrt($diffx * $diffx + $diffy * $diffy );
       $dist = sqrt($diffz * $diffz + $downDagonal + $downDagonal);
       return $dist;
    }




    


}