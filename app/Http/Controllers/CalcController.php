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

        $calculations = Calculation::wherenull("info" )->orderBy("id", "desc")->get();

        return view("calcres", ['area' => $area, 'calco' => $calculations]);
    }
}
