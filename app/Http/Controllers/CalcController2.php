<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\GenetixDataGenerator;

use App\Models\Calculation;
use App\Models\Area;
use App\Models\Pomcalcarea;

use App\Services\LevelStering;
use App\Http\Controllers\MainController;
use App\Services\MatrixHelper;


class CalcController2 extends Controller
{

    public $nrMaxPopulation = 120;
    public $startPop = 1000;

    public $main = null;
    public $ls = null;
    public $helperMatrix = null;
    // php artisan app:big-crossing 34 0 10
    // php artisan app:big-crossing 34 1 10

    public function __construct()
    {
        $this->main = new MainController();
        $this->ls = new LevelStering();
        $this->helperMatrix = new MatrixHelper();
    }

    public function list($id, Request $request)
    {

        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }

        $calculations = Calculation::wherenotnull("info")->where("info", "!=", "")->where("area_id", $id)->orderBy("id", "desc")->get();

        return view("calcres", ['area' => $area, 'calco' => $calculations]);
    }

    public function showprocess($id)
    {

        $calc = Calculation::find($id);
        if (!$calc) {
            return redirect("/")->with('error', 'Nie znaleziono podanego obliczenia');
        }
        $area = Area::find($calc->area_id);
        $res = json_decode($calc['info'], true);

        return view("progresscalc", ['area' => $area, 'res' => $res, 'calc' => $calc]);
    }

    public function samecalculations($id)
    {

        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }

        set_time_limit(3600);

        $calculations = Calculation::where("area_id", $id)->where("same", null)->orderBy("id", "asc")->get();
        $used = [];

        foreach ($calculations as $c) {
            if (in_array($c->id, $used)) {
                continue;
            }
            $samecalculations = Calculation::where("area_id", $id)->where("data", $c->data)->where("id", "!=", $c->id)->get();

            if ($samecalculations->count() > 0) {
                foreach ($samecalculations as $same) {
                    $used[] = $same->id;
                }
                Calculation::where("area_id", $id)->where("data", $c->data)->update(["same" => $c->id]);
            }
        }
        return redirect("/calculations/" . $area->id)->with('success', 'Szukano takich samych obliczeń. Znaleziono ' . count($used) . " takich samych obliczeń ");
    }

    public function showselectigcalculations($id)
    {
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }

        $calco = Calculation::selectRaw('calculation, level, count(*) AS count ')->where("area_id", $id)->groupBy('calculation', 'level')->orderBy("level", "ASC")->orderBy("calculation", "DESC")->get()->toArray();
        $res = [];
        $levl = [];
        foreach ($calco as $c) {
            $res[$c['level']][] = $c;
            if (isset($levl[$c['level']])) {
                $levl[$c['level']] += $c['count'];
            } else {
                $levl[$c['level']] = $c['count'];
            }
        }

        return view("showselectigcalculations", ['calco' => $res, "area" => $area, "levl" => $levl]);
    }

    public function onecalculation($id, GenetixDataGenerator $gtx)
    {
        set_time_limit(3600);
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        Calculation::where("area_id", $id)->update(["result2" => NULL]);
        $table = json_decode($area->data);
        $headPoints = $gtx->calcPoints($this->nrMaxPopulation, $table);
        $gtx->setPowerMatrixSize(10);

        $maxPoints = $gtx->getmaxPoints($this->nrMaxPopulation);
        $calculations = Calculation::where("area_id", $id)->whereNull("result2")->take(200)->get();

        while ($calculations->count() > 0) {
            $population0 = [];
            $ids = [];
            foreach ($calculations as $c) {
                $population0[] = json_decode($c->data);
                $ids[] = $c->id;
            }
            $res = $gtx->calcPopulation($population0, $headPoints);
            unset($population0);
            foreach ($res as $r) {
                Calculation::where("id", $ids[$r['id']])->update(["result2" => $r['sum'] / $maxPoints]);
            }
            $calculations = Calculation::where("area_id", $id)->whereNull("result2")->take(200)->get();
        }

        return redirect("/calculations/" . $area->id)->with('success', 'Przeliczono punkty na result2');
    }

    public function bottomLastLayer($id)
    {
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $lvlmax = Calculation::where("area_id", $id)->max("level");
        $avg =  $this->main->ls->getAvg($id, $lvlmax);
        if (!$avg) {
            return redirect("/")->with('error', 'Nie znaleziono średniej ');
        }

        $calculations = Calculation::where("area_id", $id)->where("level", $lvlmax)->where("obtainedresult", "<", $avg)->get();
        foreach ($calculations as $c) {
            $lvl = $this->main->ls->getLvlinAvg($id, $c->obtainedresult);
            if ($lvl) {
                Calculation::where("id", $c->id)->update(["level" => $lvl]);
            }
        }
        $this->main->ls->calcarea($id);
        return redirect("/calculations/" . $area->id)->with('success', 'Zmieniono ostatni level');
    }

    public function usedmethods($id)
    {
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $calco = Calculation::selectRaw('COUNT(id) AS count,  level, MAX(obtainedresult) as max, AVG(obtainedresult) as avg, typecalc')->where("area_id", $id)
            ->groupBy('level', 'typecalc')->orderBy("level", "asc")->orderBy("avg", "desc")->get()->toArray();

        return view("showselectedpopulation", ['calco' => $calco, "names" => $this->main->populationName, "area" => $area]);
    }

    public function deleteSameCalc($id)
    {
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $same = Calculation::select('same')->where("area_id", $id)->whereNotNull('same')->distinct()->get();
        foreach ($same as $s) {
            $first = Calculation::where("area_id", $id)->where("same", $s->same)->first();
            Calculation::where("area_id", $id)->where("same", $s->same)->where("id", "!=", $first->id)->delete();
        }
        Calculation::where("area_id", $id)->update(["same" => NULL]);
        return redirect("/calculations/" . $area->id)->with('success', 'Usunięto takie same wyniki');
    }


    public function showerros($id)
    {
        $calc = Calculation::find($id);
        if (!$calc) {
            return redirect("/")->with('error',  "Nie znaleziono obliczenia");
        }
        $area = Area::find($calc->area_id);
        $aid = $area->id;
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }

        $res = [];
        $nr = 10;
        for ($i = 0; $i < $nr; $i++) {
            $res[0][$i] = 0;
            $res[1][$i] = 0;
            $res[2][$i] = 0;
        }
        $res2 = $res;
        $data = json_decode($calc->data);
        $area = json_decode($area->data);


        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if ($data[$i][$j][$z]) {
                        $res[0][$i]++;
                        $res[1][$j]++;
                        $res[2][$z]++;
                    }
                    if ($area[$i][$j][$z]) {
                        $res2[0][$i]++;
                        $res2[1][$j]++;
                        $res2[2][$z]++;
                    }
                }
            }
        }

        return view("showdiff", ['calc' => $data, 'area' => $area, 'res' => $res, 'res2' => $res2, "aid" => $aid]);
    }

    public function showring($id)
    {
        $calc = Calculation::find($id);
        if (!$calc) {
            return redirect("/")->with('error',  "Nie znaleziono obliczenia");
        }
        $area = Area::find($calc->area_id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $nr = 10;
        $aid = $area->id;
        $res = array_fill(0, $nr, array_fill(0, floor($nr / 2), 0));
        $res2 =  array_fill(0, $nr, array_fill(0, floor($nr / 2), 0));
        $data = json_decode($calc->data);
        $area = json_decode($area->data);


        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    for ($k = 0, $l = $nr - 1; $k < $l; $k++, $l--) {
                        if (($i == $k || $i == $l || $j == $k || $j == $l) && ($i >= $k && $i <= $l) && ($j >= $k && $j <= $l)) {
                            if ($data[$i][$j][$z]) {
                                $res[$z][$k]++;
                            }
                            if ($area[$i][$j][$z]) {
                                $res2[$z][$k]++;
                            }
                        }
                    }
                }
            }
        }

        return view("showring", ['calc' => $data, 'area' => $area, 'res' => $res, 'res2' => $res2, "aid" => $aid]);
    }

    public function histogram($id)
    {
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $calc = [];
        $table = json_decode($area->data);

        $levels = [[
            'sum' => 0,
            'all' => 0,
            'avg' => 0
        ]];
        $maxlevel = 1;
        foreach ($area->calculations as $c) {
            $pc = json_decode($c->data);
            if (!isset($levels[$c->level])) {
                $levels[$c->level] = [
                    'sum' => 0,
                    'all' => 0,
                    'avg' => 0,
                    'areabulb' => $table,
                    'histogram' => [],
                    'tohistogram' => $table,
                    'sameinlevel' => 0
                ];
            }
            $levels[$c->level]['sum'] += $c->obtainedresult;
            $levels[$c->level]['all'] += 1;
            $calc[] = [
                'level' => $c->level,
                'sum' => $c->obtainedresult,
                'points' => $this->calcpointer($table, $pc)
            ];
            if ($c->level > $maxlevel) {
                $maxlevel = $c->level;
            }
            $levels[$c->level]['areabulb'] = $this->calcallinLevel($levels[$c->level]['areabulb'], $pc);
            $levels[$c->level]['histogram'] = $this->calcallinHistogramLevel($levels[$c->level]['tohistogram'], $pc, $levels[$c->level]['histogram']);
        }

        foreach ($levels as $key => $value) {
            if ($levels[$key]["all"] > 0) {
                $levels[$key]["avg"] = $levels[$key]["sum"] /  $levels[$key]["all"];
            } else {
                $levels[$key]["avg"] = 0;
            }
            $levels[$key]["divlvl"] = 1;
        }
        for ($i = 1; $i <= $maxlevel; $i++) {
            if (!isset($levels[$i]) || !isset($levels[$i - 1])) {
                continue;
            }
            $levels[$i]["divlvl"] = $levels[$i]["avg"] - $levels[$i - 1]["avg"];
            $levels[$i]["toone"] = $levels[$i]["divlvl"] / (1 - $levels[$i - 1]["avg"]);
            $levels[$i]["sameinlevel"] = $this->getnumber2inarea($levels[$i]['areabulb']);
            $levels[$i]["show_histogram"] = $this->gethistogram($levels[$i]['histogram'], $levels[$i]['all']);
            ksort($levels[$i]["show_histogram"]);
        }

        $samecalculations = Calculation::selectRaw(' count(id) AS count, level')->where("area_id", $id)->whereNotNull("same")->groupBy('level')->orderBy("level")->get();
        $samecalculations = $samecalculations->pluck("count", "level")->toArray();


        return view("histogram", ['calco' => $calc, 'levels' => $levels, 'samecalc' => $samecalculations]);
    }

    private function calcpointer($one, $two)
    {
        $sum = 0;
        $nr = 10;
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($one[$i][$j][$z] == $two[$i][$j][$z]) {
                        $sum++;
                    }
                }
            }
        }
        return $sum;
    }

    private function calcallinLevel($one, $two)
    {
        $nr = 10;
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($one[$i][$j][$z] == $two[$i][$j][$z]) {
                        $one[$i][$j][$z] = 2;
                    }
                }
            }
        }
        return $one;
    }

    private function calcallinHistogramLevel($one, $two, $res)
    {
        $nr = 10;
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($one[$i][$j][$z] == $two[$i][$j][$z]) {
                        if (!isset($res[$i][$j][$z])) {
                            $res[$i][$j][$z] = 1;
                        } else {
                            $res[$i][$j][$z]++;
                        }
                    } else {
                        if (!isset($res[$i][$j][$z])) {
                            $res[$i][$j][$z] = 0;
                        }
                    }
                }
            }
        }
        return $res;
    }

    private function getnumber2inarea($one)
    {
        $sum = 0;
        $nr = 10;
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($one[$i][$j][$z] == 2) {
                        $sum++;
                    }
                }
            }
        }
        return $sum;
    }

    private function gethistogram($hist, $maxo = 30)
    {
        $nr = 10;
        for ($i = 0; $i < $maxo; $i++) {
            $res[$i] = 0;
        }
        $res = [];
        $maxLevel = 0;
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $h = $hist[$i][$j][$z];
                    if (!isset($res[$h])) {
                        $res[$h] = 1;
                    } else {
                        $res[$h]++;
                    }
                    if ($h > $maxLevel) {
                        $maxLevel = $h;
                    }
                }
            }
        }
        for ($i = $maxLevel + 1; $i < $maxo; $i++) {
            unset($res[$i]);
        }

        return $res;
    }


    public function calcallavg($id)
    {
        $this->ls->calcarea($id);
        return redirect("/")->with('success',  "Przeliczono średnią dla area ID:" . $id);
    }

    public function percentshow($id)
    {
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $calc = [];
        $table = json_decode($area->data);


        $maxlevel = 1;
        $caclcount = count($area->calculations);
        $i = 0;
        foreach ($area->calculations as $c) {
            $i++;
            if ($i + 1000 < $caclcount) {
                continue;
            }
            $pc = json_decode($c->data);

            $calc[] = [
                'id' => $c->id,
                'level' => $c->level,
                'sum' => $c->obtainedresult,
                'points' => $this->calcpointer($table, $pc)
            ];
            if ($c->level > $maxlevel) {
                $maxlevel = $c->level;
            }
        }

        return view("percent", ['calco' => $calc]);
    }

    public function goPomCalculating($id, GenetixDataGenerator $gtx, $cid = null, $t = 112)
    {
        $calc = Calculation::find($id);
        if (!$calc) {
            return redirect("/")->with('error', 'Nie znaleziono podanego obliczenia');
        }
        $area = Area::find($calc->area_id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego obszaru Area');
        }

        set_time_limit(14400);
        ini_set('memory_limit', '350M');
        $gtx->setPowerMatrixSize(10);

        $data = json_decode($calc->data);
        $pattern = json_decode($area->data);
        $pattern2 = json_decode($area->data);
        $population0 = [$data];
        if ($cid) {
            $calc2 = Calculation::find($cid);
            $pattern2 = json_decode($calc2->data);
            $population0 = [$data, $pattern2];
        }

        $changes = $gtx->getDiffPattern($data, $pattern2);
        $max = $gtx->getmaxdiff($changes);
        $maxPoints = $gtx->getmaxPoints($this->nrMaxPopulation);

        $headPoints = $gtx->calcPoints($this->nrMaxPopulation, $pattern);

        $res = $gtx->calcPopulation($population0, $headPoints);
        $result0 = $res[0]['sum'];

        $better = 0;
        $power = $gtx->getPower($population0);
        $lvlmax = Calculation::where("area_id", $area->id)->max("level");

        for ($i = 1; $i < $max; $i++) {
            $better = 0;
            $population0 =  $gtx->createPopulationFromAreaPattern($data, $i, $changes, $pattern2, $this->startPop);
            $population0 = $gtx->usepower($population0, $power);
            $res = $gtx->calcPopulation($population0, $headPoints);
            foreach ($res as $record) {
                if ($record['sum'] > $result0) {
                    $better++;
                    if ($cid > 0) {
                        $je = json_encode($record['area']);
                        if (Calculation::where("area_id", $area->id)->where("data", $je)->count() == 0) {
                            Calculation::create([
                                "result" => "Wynik dzięki Cross muttation",
                                "data" => $je,
                                "area_id" => $area->id,
                                "level" => $lvlmax,
                                "obtainedresult" => $record['sum'] / $maxPoints,
                                "typecalc" => $t
                            ]);
                        }
                    }
                }
            }
            Pomcalcarea::create([
                "calc_id" => $id,
                "area_id" => $area->id,
                "change" => $i,
                "max" => $res[0]['sum'] / $maxPoints,
                "result" => $better / $this->startPop,
                "calc2_id" => $cid,
                "r2" =>  $res[0]['sum'] / $result0
            ]);
        }
        return redirect("/area/showpercent/" . $area->id)->with('success', 'Dokonano pomocnych obliczeń dla obliczenia ' . $id);
    }

    public function bigcrossingtwocalc($aid, GenetixDataGenerator $gtx)
    {
        $area = Area::find($aid);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego obszaru Area');
        }
        $calculations = Calculation::select('calculation.*')->join("comparecalc", "comparecalc.calc_id", "=", "calculation.id")->where("area_id", $aid)
            ->whereNotNull("head")->orderBy("obtainedresult", "DESC")->take(30)->get()->random(2)->pluck("id")->toArray();
        $this->goPomCalculating($calculations[0], $gtx, $calculations[1]);
        return redirect("/showCalcSame/" . $aid)->with('success', 'Dokonano pomocnych obliczeń dla obliczenia ' . $calculations[0] . " i " . $calculations[1]);
    }

    public function crossingOneLevel($aid, GenetixDataGenerator $gtx)
    {
        $area = Area::find($aid);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego obszaru Area');
        }
        $calculations = Calculation::where("area_id", $aid)->whereNotNull("start")->orderBy("obtainedresult", "DESC")->take(30)->get()->random(2)->pluck("id")->toArray();
        $this->goPomCalculating($calculations[0], $gtx, $calculations[1], 113);
        return redirect("/showCalcSame/" . $aid)->with('success', 'Dokonano pomocnych obliczeń dla obliczenia ' . $calculations[0] . " i " . $calculations[1]);
    }

    public function spirallMutation($aid, GenetixDataGenerator $gtx)
    {
        $area = Area::find($aid);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego obszaru Area');
        }
        $calc = Calculation::where("area_id", $aid)->orderBy("obtainedresult", "DESC")->take(30)->get()->random(1)->first();
        set_time_limit(14400);
        ini_set('memory_limit', '350M');
        $gtx->setPowerMatrixSize(10);

        $data = json_decode($calc->data);

        $maxPoints = $gtx->getmaxPoints($this->nrMaxPopulation);

        $headPoints = $gtx->calcPoints($this->nrMaxPopulation, json_decode($area->data));
        $population0 = [$data];
        $res = $gtx->calcPopulation($population0, $headPoints);
        $result0 = $res[0]['sum'];

        $better = 0;
        $power = $gtx->getPower($population0);
        $lvlmax = Calculation::where("area_id", $area->id)->max("level");

        for ($i = 1; $i < 50; $i++) {
            $better = 0;
            $population0 =  $gtx->createPopulationSpirallMutation($data, $i, $this->startPop);
            $population0 = $gtx->usepower($population0, $power);
            $res = $gtx->calcPopulation($population0, $headPoints);
            foreach ($res as $record) {
                if ($record['sum'] > $result0) {
                    $better++;

                    $je = json_encode($record['area']);
                    if (Calculation::where("area_id", $aid)->where("data", $je)->count() == 0) {
                        Calculation::create([
                            "result" => "Wynik dzięki Spirall muttation",
                            "data" => $je,
                            "area_id" => $area->id,
                            "level" => $lvlmax,
                            "obtainedresult" => $record['sum'] / $maxPoints,
                            "typecalc" => 114
                        ]);
                    }
                }
            }
            Pomcalcarea::create([
                "calc_id" => $calc->id,
                "area_id" => $aid,
                "change" => $i,
                "max" => $res[0]['sum'] / $maxPoints,
                "result" => $better / $this->startPop,
                "m" => 1,
                "r2" =>  $res[0]['sum'] / $result0
            ]);
        }
        return redirect("/calculations/" . $area->id)->with('success', 'Dokonano pomocnych obliczeń dla obliczenia ' . $aid);
    }

    public function calcRabbit($id, GenetixDataGenerator $gtx)
    {
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego obszaru Area');
        }
        $jump = Area::where("rabbitjump", $id)->first();
        if (!$jump) {
            return redirect("/")->with('error', 'Nie znaleziono podanego obszaru skoku Królika');
        }
        set_time_limit(14400);
        ini_set('memory_limit', '350M');

        $maxPoints = $gtx->getmaxPoints($this->nrMaxPopulation);
        $headPoints = $gtx->calcPoints($this->nrMaxPopulation, json_decode($jump->data));

        Calculation::where("area_id", $id)->update(["pomcalc" => 0]);
        $calculations = Calculation::where("area_id", $id)->where("pomcalc", 0)->take(50)->get();
        while ($calculations->count() > 0) {
            $population0 = [];
            $ids = [];
            foreach ($calculations as $c) {
                $population0[] = json_decode($c->data);
                $ids[] = $c->id;
            }
            $res = $gtx->calcPopulation($population0, $headPoints);
            foreach ($res as $rekord) {
                $je = json_encode($rekord['area']);
                if (Calculation::where("area_id", $jump->id)->where("data", $je)->count() == 0) {
                    Calculation::create([
                        "result" => "Skok Królika ",
                        "data" => $je,
                        "area_id" => $jump->id,
                        "level" => 1,
                        "obtainedresult" => $rekord['sum'] / $maxPoints,
                        "typecalc" => 115
                    ]);
                }
            }

            Calculation::whereIn("id", $ids)->update(["pomcalc" => 1]);
            $calculations = Calculation::where("area_id", $id)->where("pomcalc", 0)->take(50)->get();
        }
        $this->ls->calcarea($jump->id);
        return redirect("/calculations/" . $area->id)->with('success', 'Obliczono skok królika ' . $id);
    }

    public function diffbestCalculation($id)
    {
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego obszaru Area');
        }
        $calc = [];
        $res = [];
        $res2 = [];
        $table = json_decode($area->data);
        $calculations = Calculation::where("area_id", $id)->orderBy("obtainedresult", "DESC")->take(30)->get();
        foreach ($calculations as $c) {
            $data = json_decode($c->data);
            $calc[$c->id]['diff'] = $this->helperMatrix->calcpointer($data, $table);
            $calc[$c->id]['res'] = $c->obtainedresult;
        }

        foreach ($calculations as $c) {
            foreach ($calculations as $c2) {
                if ($c->id == $c2->id) {
                    $res[$c->id][$c2->id] = 'X';
                    $res2[$c->id][$c2->id] = 'X';
                } else {
                    $res[$c->id][$c2->id] =  $this->helperMatrix->calcpointer(json_decode($c->data), json_decode($c2->data), 1);
                    $res2[$c->id][$c2->id] = $this->helperMatrix->comparediff(json_decode($c->data), json_decode($c2->data), $table);
                }
            }
        }

        return view("diffbeztcalc", ['area' => $area, 'calco' => $calc, 'res' => $res, 'cdiff' => $res2]);
    }
}
