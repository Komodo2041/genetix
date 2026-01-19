<?php

namespace App\Services;

class GenetixDataGenerator
{
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
}