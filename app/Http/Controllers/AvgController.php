<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Area;
use App\Models\Calculation;
use App\Models\Accuratecalc;
 
use App\Services\GenetixDataGenerator;

class AvgController extends Controller
{

    private $calcpointnumbers = 50;
    public $nrMaxPopulation = 120;

    public function showavgcalculations($id, Request $request) {
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $order = $request->input('order');
        $desc = $request->input('desc');
        if (!$order) {
            $order = "avg";
        }
        if (!$desc) {
            $desc = "DESC";
        }

        $calco = Accuratecalc::where("area_id", $id)->orderBy($order, $desc)->get();
        return view("avgcalc", ['area' => $area, 'calco' => $calco, "order" => $order, "desc" => $desc ]);
    }

    public function calcAvgforArea($id, GenetixDataGenerator $gtx) {
        set_time_limit(3600);
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        
        $table = json_decode($area->data);
        $gtx->setPowerMatrixSize(10);
        $calculations = Calculation::where("area_id", $id)->orderBy("obtainedresult", "DESC")->take(500)->get();
        $reso = [];
        $maxPoints = $gtx->getmaxPoints($this->nrMaxPopulation);

        $calchepers = [];

        foreach ($calculations AS $calco) {
            $reso[$calco->id] = [
                "calc_id" => $calco->id,
                "area_id" => $calco->area_id,
                "min" => 1,
                "max" => 0,
                "actres" => $calco->obtainedresult,
                "avgdiff" => 0,
                "avg" => 0
            ];
            $calchepers[$calco->id]['data'] = json_decode($calco->data);
            $calchepers[$calco->id]['saveres'] = [];
        }
 
        for ($i = 0; $i < $this->calcpointnumbers; $i++) {
            $headPoints = $gtx->calcPoints($this->nrMaxPopulation, $table);
  
            foreach ($calculations AS $calco) {
                $record = $gtx->calcPopulation([$calchepers[$calco->id]['data']], $headPoints);
                $sum = $record[0]['sum'] / $maxPoints;
                if ($sum < $reso[$calco->id]['min']) {
                    $reso[$calco->id]['min'] = $sum;
                }
                if ($sum > $reso[$calco->id]['max']) {
                    $reso[$calco->id]['max'] = $sum;
                } 
                $reso[$calco->id]['avg'] += $sum;              
            }  
        }

        foreach ($reso AS $cid => $record) {
            $reso[$cid]['avg'] = $reso[$cid]['avg'] / $this->calcpointnumbers;
            $reso[$cid]['avgdiff'] = $reso[$cid]['max'] - $reso[$cid]['min'];

            Accuratecalc::updateOrCreate(
                ['area_id' => $record['area_id'], 'calc_id' => $record['calc_id']], 
                $reso[$cid]
            );            

        }
                  
        return redirect("/showavgcalculations/".$id)->with('success', 'Dokonano Obliczeń średnich');

    }
}
