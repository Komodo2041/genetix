<?php

namespace App\Http\Controllers;

use App\Services\GenetixDataGenerator;

use Illuminate\Http\Request;

use App\Models\PowerMatrix;
use App\Models\Area;
use App\Models\Calculation;  

class PowerController extends Controller
{
    public function showmatrix($size) {

        $power = null;
        $data = PowerMatrix::where("size", $size)->first();
        if ($data) {
           $power = json_decode($data->data);
        }

        return view("powermatrix", ['size' => $size, "power" => $power ]);

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
 
       $orders = [];
       for ($i = 0; $i < $size; $i++) {
           for ($j = 0; $j < $size; $j++) {
                for ($z = 0; $z < $size; $z++) {
                    $orders[$i."-".$j."-".$z] = $allpower[$i][$j][$z];
                }
           }
       }
 
        PowerMatrix::updateOrCreate(
            ['size' => $size], 
            ['data' => json_encode($allpower), "orderdata" => json_encode($orders) ]
        );
 
       return redirect("/")->with('success', 'Obliczone Matrycę siły dla size '.$size);  
    }

    public function showpower($id, GenetixDataGenerator $gtx) {

        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $gtx->setPowerMatrixSize(10);

        $lvlmax = Calculation::where("area_id", $id)->max("level");
        $res = [];

        $pattern = json_decode($area->data);
        $power = $gtx->calcpowerone($pattern);
        $lvlinfo = []; 

        for ($i = 1; $i <= $lvlmax; $i++) {
            $calc = Calculation::where("area_id", $id)->where("level", $i)->inRandomOrder()->take(20)->get();
            $sum = 0;
            $nr = 0;
            $all = 0;
            foreach ($calc AS $c) {
                $data = json_decode($c->data);
                $p = $gtx->calcpowerone($data);
                $abs = abs($p - $power);
                $sum += $abs;
                $all += $p;
                 
                $nr++;
                $avg = $all / $nr;
                $res[$i][] = [
                   "power" => $p,
                   "result" => $c->obtainedresult,
                   "diff" => $abs,
                   "avg" => $avg
                ];
            }
            $lvlinfo[$i]['diff'] = $sum / $nr;
            $lvlinfo[$i]['avg'] = $all / $nr;
            $lvlinfo[$i]['diffavg'] = abs($lvlinfo[$i]['avg'] - $power);
        }
 

        return view("showpower", ['res' => $res, "power" => $power, "area" => $area, "lvlinfo" => $lvlinfo]);

    }

    public function show5Result($id) {

        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $lvlmax = Calculation::where("area_id", $id)->max("level");
        $calculations = Calculation::where("area_id", $id)->where("level", $lvlmax)->inRandomOrder()->take(5)->get();

        $reso = [];
        foreach ($calculations AS $c) {
            $reso[] = json_decode($c->data); 
        }        
        return view("show5results", ['reso' => $reso,   "area" => $area, "lvlmax" => $lvlmax, "good" => json_decode($area->data)]);
    }

}
