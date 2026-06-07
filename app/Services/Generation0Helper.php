<?php

namespace App\Services;
 
 
class Generation0Helper {

    public function getPattern($trybe, $size) {
        
        $res = [];
        for ($i = 0; $i < $size; $i++) {
            switch ($trybe) {
               case 1:
                $res[$i] = rand(0, 1) * 50;
                break;
               case 2:
                $res[$i] = rand(0, 10) * 10;
                break;
               case 3:
                $res[$i] = rand(0, 100);
                 break;    

            }
        }
        return $res;
    }

    public function createBoard($pattern, $size) {
       $res = [];
       for ($i = 0; $i < $size; $i++) {
         for ($j = 0; $j < $size; $j++) {
            for ($z = 0; $z < $size; $z++) {
                $res[$i][$j][$z] = $this->fill($pattern[$z]);
            }             
         }        
       }
       return $res;
    }

    private function fill($percent) {
        $rand = rand(0, 100);
        if ($rand <= $percent) {
            return 1;
        } else {
            return 0;
        }
    }

    public function calcPattern($data, $size = 10) {

       for ($i = 0; $i < 10; $i++) {
            $res[$i] = 0;
       }
       for ($i = 0; $i < $size; $i++) {
           for ($j = 0; $j < $size; $j++) {
               for ($z = 0; $z < $size; $z++) {
                  $res[$z] += $data[$i][$j][$z];
               }
           }
       }
       return $res;

    }    

    public function cleanValue($val) {
         if ($val > 100) {
            $val = 100;
        }
        if ($val < 0) {
            $val = 0;
        }  
        return $val;
    }

   public function getTwoKeysFromPattern($pattern, $val) {
     $key = rand(0, count($pattern) - 1);
     while ($pattern[$key] < $val) {
        $key = rand(0, count($pattern) - 1);
     }
     $key2 = rand(0, count($pattern) - 1);
     while ($pattern[$key2] + $val > 100) {
        $key2 = rand(0, count($pattern) - 1);
     }    
     return [$key, $key2]; 
   }

}


