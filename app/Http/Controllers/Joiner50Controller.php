<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Area;
use App\Models\Joiner50;

class Joiner50Controller extends Controller
{
    public function list($id)
    {
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $joins = Joiner50::selectRaw("max, count(better) as count ")->where("area_id", $id)->where("better", "1")->where("tryb", 1)->groupBy("max")->orderBy("max", "DESC")->get()->toArray();
        return view("showjoins", ['area' => $area, "joins" => $joins]);
    }

    public function showjoin($id, $join, Request $request)
    {

        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }

        $order = $request->input('order');
        $desc = $request->input('desc');
        if (!$order) {
            $order = "samejoin";
        }
        if (!$desc) {
            $desc = "asc";
        }

        $result = Joiner50::where("area_id", $id)->where("max", $join)->where("tryb", 1)->orderBy($order, $desc)->get()->toArray();
        $result2 = Joiner50::where("area_id", $id)->where("max", $join)->where("tryb", 2)->orderBy($order, $desc)->get()->toArray();

        return view("showjoinresult", ['area' => $area, "calco" => $result, "calco2" => $result2, "join" => $join, "order" => $order, "desc" => $desc]);
    }
}
