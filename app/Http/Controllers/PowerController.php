<?php

namespace App\Http\Controllers;

use App\Services\GenetixDataGenerator;

use Illuminate\Http\Request;

use App\Models\PowerMatrix; 

class PowerController extends Controller
{
    public function showmatrix($size) {

        return view("powermatrix", ['size' => $size ]);

    }

    public function calcpowermatrix($size, GenetixDataGenerator $gtx) {

       $table = [];
       for ($i = 0; $i < $size; $i++) {
           for ($j = 0; $j < $size; $j++) {
                for ($z = 0; $z < $size; $z++) {
                     $table[$i][$j][$z] = 1;
                }
           }
       }
       $allpower = $gtx->calcPowerPoints($table, $size);
 
        PowerMatrix::updateOrCreate(
            ['size' => $size], // Warunek wyszukiwania
            ['data' => json_encode($allpower)] // Dane do aktualizacji lub utworzenia
        );
 
       return redirect("/")->with('success', 'Obliczone Matrycę siły dla size '.$size);  
    }
}
