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
        $res2 = [];
        $data = CronSett::all();
        $areas = Area::where("hide", 0)->get();
        foreach ($data AS $c) {
            $res[$c->area_id][$c->tryb] = 1;
        }

        foreach ($areas AS $a) {
            $res2[$a->id] = $a->cronmatrix;
        }
 
        return view("cronsett", ['sett' => $res, "areas" => $areas, 'sett2' => $res2]);

    }

    public function setOneCalc(Request $request) {

        $sett2 = $request->input('sett2');
        Area::where("hide", "0")->update(["cronmatrix" => 0]);
        foreach ($sett2 AS $key => $val) {
            Area::where("id", $key)->update(["cronmatrix" => 1]);
        }
        return redirect("/showCron")->with('success', "Ustawiono Cron "); 
    }
}
