<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Calculation;
use App\Models\CompareCalc;

use App\Services\MatrixHelper;
use App\Services\GenetixDataGenerator;
use App\Services\Generation0Helper;

class SameCalcController extends Controller
{
    public function show($id, GenetixDataGenerator $gtx, Generation0Helper $gen0)
    {
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $calcs = CompareCalc::join('calculation', 'comparecalc.calc_id', '=', 'calculation.id')->where("calculation.area_id", $id)->whereNotNull("head")->orderBy("head", "ASC")->get()->toArray();
        foreach ($calcs as $key => $c) {
            $calcs[$key]['all'] = CompareCalc::join('calculation', 'comparecalc.calc_id', '=', 'calculation.id')->where("islike", $c['head'])->get()->toArray();

            $stiffPattern = $gtx->getStiffPattern([$c], 10, 10, 1);
            $pattern = $gen0->calcPattern($stiffPattern[1]);
            $calcs[$key]['board'] = json_encode($pattern);
        }
        return view("compareCalc", ["area" => $area, "calcs" => $calcs]);
    }

    public function compare($id, MatrixHelper $mh)
    {
        set_time_limit(7200);
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        Calculation::where("area_id", $id)->update(["pomcalc" => 0]);
        $patterns = [];
        $best = Calculation::where("area_id", $id)->orderBy('obtainedresult', 'DESC')->first();
        $best->pomcalc = 1;
        $best->save();
        $patterns[] = json_decode($best->data);
        $result = [];
        $head = 0;
        $result[] = [
            "calc_id" => $best->id,
            "head" => $head,
            "islike" => null,
            "change" => null
        ];
        $calculations = Calculation::where("area_id", $id)->where("pomcalc", 0)->orderBy('obtainedresult', 'DESC')->take(50)->get();
        while ($calculations->count() > 0) {
            $ids = [];
            foreach ($calculations as $calc) {
                $ids[] = $calc->id;
                $data = json_decode($calc->data);
                $same = 0;
                foreach ($patterns as $key => $patt) {
                    $change = 1000 - $mh->calcpointer($patt, $data);

                    if ($change <= 100) {
                        $same = 1;
                        $result[] = [
                            "calc_id" => $calc->id,
                            "head" => null,
                            "islike" => $key,
                            "change" => $change
                        ];
                        break;
                    }
                }
                if ($same == 0) {
                    $patterns[] = $data;
                    $head++;
                    $result[] = [
                        "calc_id" => $calc->id,
                        "head" => $head,
                        "islike" => null,
                        "change" => null
                    ];
                }
            }

            Calculation::whereIn("id", $ids)->update(["pomcalc" => 1]);
            $calculations = Calculation::where("area_id", $id)->where("pomcalc", 0)->orderBy('obtainedresult', 'DESC')->take(50)->get();
        }

        foreach ($result as $record) {
            CompareCalc::updateOrCreate(
                ['calc_id' => $record['calc_id']],
                $record
            );
        }
        return redirect("/showCalcSame/" . $id)->with('success', 'Obliczono  porównianie obliczeń ');
    }

    public function checkBlob($id, $tryb, GenetixDataGenerator $gtx)
    {
        set_time_limit(3600);
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $population0 = [];
        $table = json_decode($area->data);
        $headPoints = $gtx->calcPoints(120, $table);
        $gtx->setPowerMatrixSize(10);
        $maxPoints = $gtx->getmaxPoints(120);
        $blobType = 105;
        $setLevel = 1;
        $calculations = Calculation::where("area_id", $id)->orderBy("obtainedresult", "DESC")->take(20)->get();
        foreach ($calculations as $c) {
            $population0[] = json_decode($c->data);
        }

        $power = $gtx->getPower($population0);

        if ($tryb == 0) {
            $calculations = Calculation::where("area_id", $id)->where("level", 1)->inRandomOrder()->take(100)->get();
            $blobType = 105;
        } elseif ($tryb == 1) {
            $calculations = Calculation::where("area_id", $id)->where("level", 2)->inRandomOrder()->take(100)->get();
            $setLevel = 2;
            $blobType = 105;
        } else {
            $calculations = Calculation::select('calculation.*')->join("comparecalc", "comparecalc.calc_id", "=", "calculation.id")->where("area_id", $id)->whereNotNull("head")->orderBy("obtainedresult", "DESC")->take(20)->get()->random(10);
            $blobType = 106;
        }
        $population0 = [];
        foreach ($calculations as $c) {
            $population0[] = json_decode($c->data);
        }

        $stiffPattern = $gtx->getStiffPattern($calculations, 95, 10);
        $population0 = $gtx->getStableGeneration(10, 800, $stiffPattern[0], $stiffPattern[1]);
        $population0[] = $stiffPattern[1];
        $population0 = $gtx->usepower($population0, $power);

        $res = $gtx->calcPopulation($population0, $headPoints);

        Calculation::create([
            "result" => "Liczenie Bloba",
            "data" => json_encode($res[0]['area']),
            "area_id" => $id,
            "level" => $setLevel,
            "obtainedresult" => $res[0]['sum'] / $maxPoints,
            "typecalc" => $blobType
        ]);

        return redirect("/showCalcSame/" . $id)->with('success', 'Obliczono Blob');
    }
}
