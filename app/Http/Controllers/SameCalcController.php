<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Calculation;
use App\Models\CompareCalc;

use App\Services\MatrixHelper;

class SameCalcController extends Controller
{
    public function show($id)
    {
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $calcs = CompareCalc::join('calculation', 'comparecalc.calc_id', '=', 'calculation.id')->where("calculation.area_id", $id)->whereNotNull("head")->orderBy("head", "ASC")->get()->toArray();
        foreach ($calcs as $key => $c) {
            $calcs[$key]['all'] = CompareCalc::join('calculation', 'comparecalc.calc_id', '=', 'calculation.id')->where("islike", $c['head'])->get()->toArray();
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
}
