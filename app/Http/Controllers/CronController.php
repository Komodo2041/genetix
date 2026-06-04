<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CronSett;
use App\Models\Area;

class CronController extends Controller
{
    public function show(Request $request) {


       if ($request->isMethod('post')) {
           $sett = $request->input('sett');
           CronSett::truncate();
           foreach ($sett AS $aid => $record) {
               foreach ($record AS $k => $t) {
                    CronSett::create(["area_id" => $aid, "tryb" => $k]);
               }
           }
       }


        $res = [];
        $data = CronSett::all();
        $areas = Area::where("hide", 0)->get();
        foreach ($data AS $c) {
            $res[$c->area_id][$c->tryb] = 1;
        }
 
        return view("cronsett", ['sett' => $res, "areas" => $areas]);

    }
}
