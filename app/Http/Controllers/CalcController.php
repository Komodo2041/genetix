<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Calculation;
use App\Models\Area;

class CalcController extends Controller
{
    public function list($id, Request $request ) {

        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }

        $calculations = Calculation::wherenotnull("info" )->where("info", "!=", "")->orderBy("id", "desc")->get();

        return view("calcres", ['area' => $area, 'calco' => $calculations]);
    }

    public function showprocess($id) {

        $calc = Calculation::find($id);
        if (!$calc) {
            return redirect("/")->with('error', 'Nie znaleziono podanego obliczenia');
        }
        $area = Area::find($calc->area_id);
        $res = json_decode($calc['info'], true);
 
        return view("progresscalc", ['area' => $area, 'res' => $res ]);
    }


}
