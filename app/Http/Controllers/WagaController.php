<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\GenetixDataGenerator;
use App\Models\Area;
use App\Models\Waga;
use App\Models\Calculation;
use App\Services\WagaService;

class WagaController extends Controller
{

    public $nrMaxPopulation = 120;

    public function createweighingscale($id, GenetixDataGenerator $gtx)
    {
        set_time_limit(7200);
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $bestResult = Calculation::where("area_id", $id)->orderBy("obtainedresult", "DESC")->first();
        if (!$bestResult) {
            return redirect("/")->with('error', 'Brak obliczeń dla podanego area');
        }
        $data = json_decode($bestResult->data);

        $table = json_decode($area->data);
        $headPoints = $gtx->calcPoints($this->nrMaxPopulation, $table);

        WagaService::getdiffwaga($data, $headPoints, $id, $bestResult->id, $gtx);
        return redirect("/")->with('success', 'Obliczono wagę dla area: ' . $id);
    }

    public function shoWagainArea($id)
    {
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $calculations = Waga::select('calculation.*')->join("calculation", "calculation.id", "=", "waga.calculation_id")->where("waga.area_id", $id)->orderBy("waga.id", "DESC")->get()->toArray();

        return view("waga", ['area' => $area, "calco" => $calculations]);
    }

    public function showCalcWaga($id)
    {
        $calc = Calculation::find($id);
        if (!$calc) {
            return redirect("/")->with('error', 'Nie znaleziono podanego obliczenia');
        }
        $waga = Waga::where("calculation_id", $id)->first();
        if (!$waga) {
            return redirect("/")->with('error', 'Nie znaleziono wagi dla podanego obliczenia');
        }
        $area = Area::find($calc->area_id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area dla obliczenia');
        }
        $data = json_decode($calc->data);
        $area = json_decode($area->data);
        $waga = json_decode($waga->data);
        return view("wagashow", ['calc' => $data, 'area' => $area, "waga" => $waga, 'aid' => $calc->area_id, 'cid' => $id]);
    }
}
