<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Area;
use App\Models\Calculation;
use App\Models\Accuratecalc;
 
use App\Models\LevelAvg;

use App\Services\GenetixDataGenerator;
use App\Services\LevelStering;

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

        $calco = Accuratecalc::with("calculation")->where("area_id", $id)->orderBy($order, $desc)->get();
        return view("avgcalc", ['area' => $area, 'calco' => $calco, "order" => $order, "desc" => $desc ]);
    }

    public function calcAvgforArea($id, $part, GenetixDataGenerator $gtx) {
        set_time_limit(7200);
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        
        $table = json_decode($area->data);
        $gtx->setPowerMatrixSize(10);
      
        if ($part == 0) {
            Calculation::where("area_id", $id)->update(["mule" => 0]);
        }

        $reso = [];
        $maxPoints = $gtx->getmaxPoints($this->nrMaxPopulation);
        $calchepers = [];

        $levelAvg = Levelavg::where("area_id", $id)->orderBy("level", "DESC")->get()->pluck("avg", "level")->toArray();
 
       $calculations = Calculation::where("area_id", $id)->where("mule", 0)->orderBy("obtainedresult", "DESC")->take(50)->get();
        while ($calculations->count() > 0) {
            $cids = [];
            $reso = [];
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
                $cids[] = $calco->id;
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
                    $calchepers[$calco->id]['saveres'][] = $sum;           
                }  
            }
 
            foreach ($reso AS $cid => $record) {
                 
                $reso[$cid]['avg'] = $reso[$cid]['avg'] / $this->calcpointnumbers;
                $reso[$cid]['avgdiff'] = $reso[$cid]['max'] - $reso[$cid]['min'];
 
                $variation = 0;
                foreach ($calchepers[$cid]['saveres'] AS $s2) {
                    $abs = abs( $s2 - $reso[$cid]['avg']);
                    $variation += $abs;
                }  
                $reso[$cid]['variation'] = $variation / $this->calcpointnumbers;
                $reso[$cid]['calclevel'] = $this->calcLevel($reso[$cid]['avg'], $levelAvg);
  
                Accuratecalc::updateOrCreate(
                    ['calc_id' => $cid], 
                    $reso[$cid]
                );            
    
            }   
            Calculation::whereIn("id", $cids)->update(["mule" => 1]);
            $calculations = Calculation::where("area_id", $id)->where("mule", 0)->orderBy("obtainedresult", "DESC")->take(50)->get();
        }    
                 
        return redirect("/showavgcalculations/".$id)->with('success', 'Dokonano Obliczeń średnich');

    }

    private function calcLevel($avg, $levelAvg) {
        $res = 1;
        foreach ($levelAvg AS $lvl => $c) {
            if ($c < $avg) {
               $res = $lvl;
               break;
            }
        }
        return $res;
    }

    public function desilting($id, LevelStering $ls) {
        set_time_limit(3600);
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $calco = Accuratecalc::with("calculation")->where("area_id", $id)->get();
        $nr = 0;
        foreach ($calco AS $c) {
            if ($c->calclevel != $c->calculation->level) {
               $change = "\n Odmulanie z ".$c->calculation->level. " na ".$c->calclevel."\n";
               Calculation::where("id", $c->calc_id)->update(["level" => $c->calclevel, "result" => $c->calculation->result." ".$change, "obtainedresult" => $c->avg]); 
               $nr++;
            }
            
        }
        $ls->delarea($id);
        $ls->calcarea($id);
        return redirect("/showavgcalculations/".$id)->with('success', 'Odmulono obszar - Zmiany: '.$nr);
    }

}
