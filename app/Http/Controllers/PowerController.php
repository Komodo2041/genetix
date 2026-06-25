<?php

namespace App\Http\Controllers;

use App\Services\GenetixDataGenerator;

use Illuminate\Http\Request;

use App\Models\PowerMatrix;
use App\Models\Area;
use App\Models\Calculation;

use App\Services\CrossingData;
use App\Services\MatrixHelper;



class PowerController extends Controller
{
    public function showmatrix($size)
    {

        $power = null;
        $data = PowerMatrix::where("size", $size)->first();
        if ($data) {
            $power = json_decode($data->data);
        }
        $res = array_fill(0, 10, 0);
        for ($i = 0; $i < 10; $i++) {
            for ($j = 0; $j < 10; $j++) {
                for ($z = 0; $z < 10; $z++) {
                    $res[$z] += $power[$i][$j][$z];
                }
            }
        }
        return view("powermatrix", ['size' => $size, "power" => $power, "calc" => $res]);
    }

    public function calcpowermatrix($size, GenetixDataGenerator $gtx)
    {

        $table = [];
        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size; $j++) {
                for ($z = 0; $z < $size; $z++) {
                    $table[$i][$j][$z] = 1;
                }
            }
        }
        $allpower = $gtx->calcPowerPoints($table, $size);

        $orders = [];
        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size; $j++) {
                for ($z = 0; $z < $size; $z++) {
                    $orders[$i . "-" . $j . "-" . $z] = $allpower[$i][$j][$z];
                }
            }
        }

        PowerMatrix::updateOrCreate(
            ['size' => $size],
            ['data' => json_encode($allpower), "orderdata" => json_encode($orders)]
        );

        return redirect("/")->with('success', 'Obliczone Matrycę siły dla size ' . $size);
    }

    public function showpower($id, GenetixDataGenerator $gtx)
    {

        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $gtx->setPowerMatrixSize(10);

        $lvlmax = Calculation::where("area_id", $id)->max("level");
        $res = [];

        $pattern = json_decode($area->data);
        $power = $gtx->calcpowerone($pattern);
        $lvlinfo = [];

        for ($i = 1; $i <= $lvlmax; $i++) {
            $calc = Calculation::where("area_id", $id)->where("level", $i)->inRandomOrder()->take(20)->get();
            $sum = 0;
            $nr = 0;
            $all = 0;
            foreach ($calc as $c) {
                $data = json_decode($c->data);
                $p = $gtx->calcpowerone($data);
                $abs = abs($p - $power);
                $sum += $abs;
                $all += $p;

                $nr++;
                $avg = $all / $nr;
                $res[$i][] = [
                    "power" => $p,
                    "result" => $c->obtainedresult,
                    "diff" => $abs,
                    "avg" => $avg
                ];
            }
            $lvlinfo[$i]['diff'] = $sum / $nr;
            $lvlinfo[$i]['avg'] = $all / $nr;
            $lvlinfo[$i]['diffavg'] = abs($lvlinfo[$i]['avg'] - $power);
        }


        return view("showpower", ['res' => $res, "power" => $power, "area" => $area, "lvlinfo" => $lvlinfo]);
    }

    public function show5Result($id)
    {

        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $lvlmax = Calculation::where("area_id", $id)->max("level");
        $calculations = Calculation::where("area_id", $id)->where("level", $lvlmax)->inRandomOrder()->take(5)->get();

        $reso = [];
        foreach ($calculations as $c) {
            $reso[] = json_decode($c->data);
        }
        return view("show5results", ['reso' => $reso,   "area" => $area, "lvlmax" => $lvlmax, "good" => json_decode($area->data)]);
    }

    public function show50Result($id, $nr = 0)
    {

        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $lvlmax = Calculation::where("area_id", $id)->max("level");
        $max = $calculations = Calculation::where("area_id", $id)->orderBy("obtainedresult", "DESC")->count();
        $total = ceil($max / 64);
        $calculations = Calculation::where("area_id", $id)->orderBy("obtainedresult", "DESC")->offset($nr * 64)->take(64)->get();

        $reso = [];
        foreach ($calculations as $c) {
            $reso[] = [
                "data" => json_decode($c->data),
                "lvl" => $c->level,
            ];
        }
        return view("show50results", ['reso' => $reso,   "area" => $area, "lvlmax" => $lvlmax, "good" => json_decode($area->data), "nr" => $nr, "total" => $total]);
    }


    public function see10Layerpower($size, CrossingData $cross)
    {

        $data = PowerMatrix::where("size", $size)->first();
        if (!$data) {
            return redirect("/")->with('error', 'Brak obliczeń');
        }
        $orders = $cross->getOrders(10);
        $parts = $cross->getPartsOrders($orders, 100);

        $helperMatrix = new MatrixHelper();
        $zero = $helperMatrix->getZeroTable($size);
        $res = [];
        for ($n = 0; $n < $size; $n++) {
            $table = $zero;
            for ($i = 0; $i < $size; $i++) {
                for ($j = 0; $j < $size; $j++) {
                    for ($z = 0; $z < $size; $z++) {
                        $key = $parts[$i . "-" . $j . "-" . $z];

                        if ($key == $n) {
                            $table[$i][$j][$z] = 1;
                        }
                    }
                }
            }
            $res[] = $table;
        }

        return view("showPowerLayers", ['reso' => $res, "size" => $size]);
    }
}
