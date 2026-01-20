<?php

namespace App\Services;

 

class GenetixDataGenerator
{

    public float $G = 6.67430e-11; // 
    public $probe = 10000;
    public $block = 1e6;


    public function getFirstGeneration($size, $max, $numbers) {

       $allGeneration = [];
       $table = [];
       for ($dist = 0; $dist < $numbers; $dist++) {
            for ($i = 0; $i < $size; $i++) {
                for ($j = 0; $j < $size; $j++) {
                    for ($z = 0; $z < $size; $z++) {
                        $table[$i][$j][$z] = rand(0, $max);
                    }
                }
            }
            $allGeneration[] =  $table;    
       }
       return $allGeneration;
    }

    public function calcPopulation($population0, $headPoints) {
        $res = [];
        foreach ($population0 AS $area) {
            $record = [];
            $pointsIndividual = $this->calcIndividualPoints($area, $headPoints);
            $record['points'] = $pointsIndividual;
            $record['area'] = $area;
            $record['sum'] = $this->calcAreaPoints($pointsIndividual);
            
            $res[] = $record;
        }

        usort($res, function($a, $b) { return $a['sum'] < $b['sum']; } );

        return $res;
    }

    private function calcAreaPoints($pointsIndividual) {
        $res = 0;
        foreach ($pointsIndividual AS $p) {
            $res += $p['fit'];
        }
        return $res;
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

    private function calcIndividualPoints($area, $headPoints) {
 
       $nr = 10; 
       $allPoints = [];
        foreach ($headPoints AS $point) {
      
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
            $point['v2'] = $allForce;
            $point['fit'] = $this->calcFit( $point['v'], $point['v2'], );
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

    private function calcFit($v1, $v2) {
        $diff = abs($v1 - $v2);
        $change = $diff / $v1;
        $result = 0;
        if ($change <= 1) {
            $result = 10000 - $change * 10000;
        }
        return $result;

    }

    public function getmaxPoints($nrpoints) {
        return 10000 * $nrpoints;
    }

    public function getindyvidual($res, $nr) {
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            $table[] = $res[$i]['area'];
        }
        return $table;
    }

 

}