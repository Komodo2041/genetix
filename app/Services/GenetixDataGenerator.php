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

    public function calcPopulation($population0, $headPoints, $usedcrossing = []) {
        $res = [];
        $i = 0;
        foreach ($population0 AS $area) {
            $record = [];
            $pointsIndividual = $this->calcIndividualPoints($area, $headPoints);
            $record['points'] = $pointsIndividual;
            $record['area'] = $area;
            $record['sum'] = $this->calcAreaPoints($pointsIndividual);
            $record['id'] = $i;
             
            if (isset($usedcrossing[$i])) {
                $record['howitwascreated'] = $usedcrossing[$i];
            }
            $i++;
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
       // Better Results
       $zOs = rand(0, 200);
       $allPoints = [];
       for ($pon = 0; $pon < $nrPoints; $pon++) {
            if ($pon % 3 == 0) {
                $zOs = rand(0, 200);
            }
            $point = ['x' => rand(0,1000), 'y' => rand(0,1000), 'z' => $zOs, 'v' => 0];
           
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
            $result = 100000000 - $change * 100000000;
        }
        return $result;

    }

    public function getmaxPoints($nrpoints) {
        return 100000000 * $nrpoints;
    }

    public function getindyvidual($res, $nr = 10) {
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            $table[] = $res[$i]['area'];
        }
        return $table;
    }


    public function getPower($population0) {
    
        $sum = 0;
        $nr = count($population0);
        for ($n = 0; $n < $nr; $n++) { 
           $sum += $this->calcpowerone($population0[$n]);
        }
        return round($sum/$nr);      
    }

    public function getPowerfromarea($population0, $nr = 10) {
    
        $sum = 0;
        for ($n = 0; $n < $nr; $n++) { 
           $sum += $this->calcpowerone($population0[$n]['area']);
        }
        return round($sum/$nr);      
    }    
     

    public function calcpowerone($area) {
        $sum = 0;
        $nr = 10;
        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
               for ($z = 0; $z < $nr; $z++) {
                    $sum += $area[$i][$j][$z];
                 }
             }
         }
         return $sum;         
    }
 
    public function usepower($newpopulaton, $power) {

       $res = [];
       foreach ($newpopulaton AS $area) {
           $p = $this->calcpowerone($area);
           $diff = $p - $power;
           $abs = abs($diff);
           if ($abs <= 10) {
              $res[] = $area;
           } else {
              $change = $abs + rand(-5, 5);

              if ($diff < 0) {
                 $area = $this->addpower($area, $change);
              } else {
                 $area = $this->removepower($area, $change);
              }
              $res[] = $area;
           }

       }
 
       return $res; 
    }

    private function addpower($pop, $change, $nr = 10) {
        for ($n = 0; $n <= $change; $n++ ) {
            $x = rand(0, $nr - 1);
            $y = rand(0, $nr - 1);
            $z = rand(0, $nr - 1);
            if ($pop[$x][$y][$z] > 0) {
               $n--;
            } else {
                $pop[$x][$y][$z] = 0;
            }
 
        }
        return $pop;
    }

    private function removepower($pop, $change, $nr = 10) {
        for ($n = 0; $n <= $change; $n++ ) {
            $x = rand(0, $nr - 1);
            $y = rand(0, $nr - 1);
            $z = rand(0, $nr - 1);
            if ($pop[$x][$y][$z] > 0) {
               $pop[$x][$y][$z] = 0;
            } else {
               $n--;
            }
 
        }
        return $pop;
    }

    public function choosemodify($res, $nr, &$usedmodify) {
             
        for ($i = 0; $i < $nr; $i++) {
            if (isset($res[$i]['howitwascreated'])) {
               $hd = $res[$i]['howitwascreated'];
               if (isset($usedmodify[$hd])) {
                  $usedmodify[$hd]++;
               } else {
                  $usedmodify[$hd] = 1;
               }
            }
        }
        
    }


    public function getStiffPattern($calculations, $usedpercent, $nr = 10) {
        $blobAll = [];
        $stablePoints = [];
        $all = [];
        $count = count($calculations);
        $diff = 1 - $usedpercent / 100;
 
        foreach ($calculations AS $c) {
            $data = json_decode($c->data);
            for ($i = 0; $i < $nr; $i++) {
                for ($j = 0; $j < $nr; $j++) {
                    for ($z = 0; $z < $nr; $z++) {
                        if (isset($all[$i][$j][$z])) {
                            $all[$i][$j][$z] += $data[$i][$j][$z];
                        } else {
                            $all[$i][$j][$z] = $data[$i][$j][$z];
                        }
                    }
                }
            }            
        }

       for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
               for ($z = 0; $z < $nr; $z++) { 
                   $all[$i][$j][$z] = $all[$i][$j][$z] / $count;
                   $ch = $all[$i][$j][$z];
                   $blobAll[$i][$j][$z] = round($ch);
                   if ($ch - $diff < 0 || $ch + $diff > 1) {
                      $stablePoints[$i][$j][$z] = 1;
                   } else {
                      $stablePoints[$i][$j][$z] = 0;
                   }

               }
            }
       }             

       return [$stablePoints, $blobAll];

    }


   
    public function getStableGeneration($size, $numbers, $stable, $blob ) {

       $allGeneration = [];
 
       $max = 1;
       for ($dist = 0; $dist < $numbers; $dist++) {
            $table = [];
            for ($i = 0; $i < $size; $i++) {
                for ($j = 0; $j < $size; $j++) {
                    for ($z = 0; $z < $size; $z++) {
                        if ($stable[$i][$j][$z] == 1) {
                            $table[$i][$j][$z] = $blob[$i][$j][$z]; 
 
                        } else {
                            $table[$i][$j][$z] = rand(0, 1);
                        } 
                         
                    }
                }
            }
            $allGeneration[] =  $table;    
       }
       return $allGeneration;
    }

    public function getInvertStill($stable, $blob) {
        $table = [];
        $size = 10;
            for ($i = 0; $i < $size; $i++) {
                for ($j = 0; $j < $size; $j++) {
                    for ($z = 0; $z < $size; $z++) {
                        if ($stable[$i][$j][$z] == 1) {
                            $table[$i][$j][$z] = $blob[$i][$j][$z];
                        } elseif ($blob[$i][$j][$z] == 1) {
                            $table[$i][$j][$z] = 0;
                        } else {
                            $table[$i][$j][$z] = 1;
                        }
                    }
                }
            }
         
        return $table;
    }


    public function clonePattern($data, $size = 10, $change = 20, $nr = 10) {
  
        $all = [];   

        for ($i = 0; $i < $size; $i++) {
            $table = $data;
            for ($m = 0; $m < $change; $m++) {
                $x = rand(0, $nr - 1);
                $y = rand(0, $nr - 1);
                $z = rand(0, $nr - 1);
                if ($table[$x][$y][$z] == 1) {
                $table[$x][$y][$z] = 0;
                } else {
                $table[$x][$y][$z] = 1;
                }
            }
            $all[] = $table;
        }            
      
        return $all;
    }

    public function getStiilPatern($size, $numbers) {

        $table = [];
        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size; $j++) {
                for ($z = 0; $z < $size; $z++) { 
                    $table[$i][$j][$z] = 1;
                }
            }
        }

        $n = 0;
        while ($n <= 100) {
            $x = rand(0, $size - 1);
            $y = rand(0, $size - 1);
            $z = rand(0, $size - 1);
            if ($table[$x][$y][$z] == 1) {
                $table[$x][$y][$z] = 0;
                $n++;
            }            
        }
        return $table;
    }

    public function getPopulationFromStillTemplate($size, $numbers,  $template, $calc, $change) {
        $data = json_decode($calc->data);
        $res = [];
        for ($i = 0; $i < $numbers; $i++) {
            $table = $data;
            $to = 0;
            $many = rand(1, $change);
            while ($to < $many) {
                $x = rand(0, $size - 1);
                $y = rand(0, $size - 1);
                $z = rand(0, $size - 1);
                if ($template[$x][$y][$z] == 0) {
                    $table[$x][$y][$z] = rand(0, 1);
                    $to++;
                }
            }
            $res[] = $table;
        }
        return $res;
    }

    public function getStiilPaternXYZ($size) {

        $table = [];
        $changeOs = rand(0, 2);
        $defochange = rand(round($size/2), $size - 1);

        $headval = 0;
        $headval1 = 1;
        $head = rand(0, 1);
        if ($head == 1) {
           $headval = 1;
           $headval1 = 0;            
        }

        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size; $j++) {
                for ($z = 0; $z < $size; $z++) { 
                    switch ($changeOs) {
                        case 0:
                            if ($i >= $defochange) {
                               $table[$i][$j][$z] = $headval;
                            } else {
                               $table[$i][$j][$z] = $headval1;
                            }
                            break;
                        case 1:
                           if ($j >= $defochange) {
                              $table[$i][$j][$z] = $headval;
                            } else {
                              $table[$i][$j][$z] = $headval1;
                            }                            
                            break;
                        case 2:
                           if ($z >= $defochange) {
                               $table[$i][$j][$z] = $headval;
                            } else {
                               $table[$i][$j][$z] = $headval1;
                            }                              
                            break;                                                        
                    }
                     
                }
            }
        }
 
        return $table;
 
    }


}