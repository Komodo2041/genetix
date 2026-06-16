<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\GenetixDataGenerator;

use App\Models\Calculation;
use App\Models\Area;
use App\Models\Gen0;
use App\Services\LevelStering;
use App\Http\Controllers\MainController;

use App\Services\CrossingData;
use App\Services\MutationData;

use App\Services\Generation0Helper;

class CalcController2 extends Controller
{

    // php artisan app:calc-gen0 16 6 
    // php artisan app:calc-gen0 16 5

    // php artisan app:calc-gen0 16 9

    public $nrMaxPopulation = 120;

    public $manyrepeat = 1;
    public $manyAltrepeat = 10;

    public $maxPopulation = 10;
    public $startPopulation = 800;

    public $main = null;
    public $ls = null;

    public function __construct()
    {
        $this->main = new MainController();
        $this->ls = new LevelStering();
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

    public function showgeneration0($id, $dimension, Request $req)
    {
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $onshow = $req->input("onshow", 0);

        $pgen = Gen0::where("area_id", $id)->orderBy("result", "desc")->where("dim", $dimension);
        if ($onshow == 1) {
            $pgen = $pgen->whereIn("tryb", [1, 2, 3]);
        } elseif ($onshow == 2) {
            $pgen = $pgen->whereIn("tryb", [12, 13, 14]);
        }
        $gen = $pgen->take(200)->get();
        $workedcount = Gen0::where("area_id", $id)->where("worked", 1)->where("dim", $dimension)->count();

        return view("showgeneration0", ['area' => $area, 'gen' => $gen, "workedcount" => $workedcount, "dimension" => $dimension, "onshow" => $onshow]);
    }

    public function calcGeneration0($id, $tryb, $dimension, Generation0Helper $gen0, CrossingData $cross, MutationData $mutation, GenetixDataGenerator $gtx)
    {

        set_time_limit(40000);
        ini_set('memory_limit', '300M');

        $gen0->setDimension($dimension);
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }

        $headarea = $area;

        if ($area->river) {
            $headarea = Area::find($area->river);
        }
        $settBox = 0;
        $settGen0 = Area::where("river", $headarea->id)->where("gen0set", 1)->first();
        if ($settGen0 && $dimension == 0) {
            $settBox = $settGen0->id;
        }

        $changes = array_fill(0, 10, 0);
        $pattern = [];
        $bestR = 0;
        if (in_array($tryb, [1, 2, 3])) {
            $pattern = $gen0->getPattern($tryb, 10);
        } elseif ($tryb == 4) {
            $calculations = Calculation::where("area_id", $id)->orderBy('obtainedresult', 'DESC')->take(25)->get();
            $stiffPattern = $gtx->getStiffPattern($calculations, 10, 10);
            $pattern = $gen0->calcPattern($stiffPattern[1]);
        } elseif ($tryb == 5) {
            $best = Gen0::where("area_id", $id)->where("dim", $dimension)->orderBy("result", "DESC")->first();
            $bestR = $best->result;
            $pattern = json_decode($best->data);
            foreach ($pattern as $key => $res) {
                $v = rand(-5, 5);
                $pattern[$key] = $gen0->cleanValue($v + $res);
                $changes[$key] = $v;
            }
        } elseif ($tryb == 6) {
            $best = Gen0::where("area_id", $id)->where("dim", $dimension)->orderBy("result", "DESC")->take(10)->get()->shuffle()->first();
            $pattern = json_decode($best->data);
            $bestR = $best->result;
            $key = rand(0, count($pattern) - 1);
            $v = rand(-10, 10);
            $changes[$key] = $v;
            $pattern[$key] =  $gen0->cleanValue($v + $pattern[$key]);
        } elseif ($tryb == 7) {
            $best = Gen0::where("area_id", $id)->where("dim", $dimension)->orderBy("result", "DESC")->take(10)->get()->shuffle()->first();
            $pattern = json_decode($best->data);
            $bestR = $best->result;
            $val = rand(1, 10);
            $keys = $gen0->getTwoKeysFromPattern($pattern, $val);
            $pattern[$keys[0]] = $gen0->cleanValue($pattern[$keys[0]] - $val);
            $pattern[$keys[1]] = $gen0->cleanValue($pattern[$keys[1]] + $val);
            $changes[$keys[0]] = -1 * $val;
            $changes[$keys[1]] = $val;
        } elseif ($tryb == 8) {
            $best = Gen0::where("area_id", $id)->where("dim", $dimension)->orderBy("result", "DESC")->take(10)->get()->shuffle()->first();
            $pattern = json_decode($best->data);
            $bestR = $best->result;
            $val = rand(1, 10);
            $keys = $gen0->getTwoKeysFromPatternNeibours($pattern, $val);
            $pattern[$keys[0]] = $gen0->cleanValue($pattern[$keys[0]] - $val);
            $pattern[$keys[1]] = $gen0->cleanValue($pattern[$keys[1]] + $val);
            $changes[$keys[0]] = -1 * $val;
            $changes[$keys[1]] = $val;
        } elseif ($tryb == 9) {
            $best = Gen0::where("area_id", $id)->where("dim", $dimension)->orderBy("result", "DESC")->take(10)->get()->shuffle()->first();
            $pattern = json_decode($best->data);
            $bestR = $best->result;
            $val = rand(-10, 10);
            $key = $key = rand(1, count($pattern) - 2);
            $pattern[$key] = $gen0->cleanValue($pattern[$key] - 2 * $val);
            $pattern[$key - 1] = $gen0->cleanValue($pattern[$key - 1] + $val);
            $pattern[$key + 1] = $gen0->cleanValue($pattern[$key + 1] + $val);
            $changes[$key] = -1 * 2 * $val;
            $changes[$key - 1] = $val;
            $changes[$key + 1] = $val;
        } elseif ($tryb == 10) {
            $best = Gen0::where("area_id", $id)->where("dim", $dimension)->orderBy("result", "DESC")->take(10)->get()->shuffle()->first();
            $pattern = json_decode($best->data);
            $bestR = $best->result;

            $worked = Gen0::where("area_id", $id)->where("dim", $dimension)->where("worked", 1)->inRandomOrder()->first();
            if (!$worked) {
                return redirect("/showgeneration0/" . $id . "/" . $dimension)->with('error', 'Brak dobrych obliczeń');
            }
            $changes = json_decode($worked->changes);
            for ($i = 0; $i < 10; $i++) {
                $pattern[$i] += $changes[$i];
                $pattern[$i] = $gen0->cleanValue($pattern[$i]);
            }
        } elseif ($tryb == 11) {
            $bests = Gen0::where("area_id", $id)->where("dim", $dimension)->whereIn("tryb", [5, 15])->orderBy("result", "DESC")->take(10)->get();
            $best = Gen0::where("area_id", $id)->where("dim", $dimension)->orderBy("result", "DESC")->take(10)->get()->shuffle()->first();
            $bestR = $best->result;
            $pattern2 = json_decode($best->data);
            $pattern = array_fill(0, 10, 0);
            $all = 0;
            foreach ($bests as $best) {
                $go = json_decode($best->changes);
                for ($i = 0; $i < 10; $i++) {
                    $pattern[$i] += $go[$i];
                }
                $all++;
            }
            for ($i = 0; $i < 10; $i++) {
                $changes[$i] = round($pattern[$i] / $all);
                $pattern[$i] = $gen0->cleanValue($changes[$i] + $pattern2[$i]);
            }
        } elseif ($tryb == 12) {
            $best = Gen0::where("area_id", $id)->where("dim", $dimension)->orderBy("result", "DESC")->take(10)->get()->shuffle()->first();
            $data = json_decode($best->data);
            $sum = $gen0->calcAllData($data);
            $half = floor($sum / 2);
            $newData = $gen0->minusData($data, $half);
            $pattern = $gen0->addData($newData, $half);
        } elseif ($tryb == 13) {
            $best = Gen0::where("area_id", $id)->where("dim", $dimension)->whereIn("tryb", [12, 13, 14])->orderBy("result", "DESC")->take(10)->get()->random(1);
            $bestR = $best[0]->result;
            $pattern = json_decode($best[0]->data);
            foreach ($pattern as $key => $res) {
                $v = rand(-5, 5);
                $pattern[$key] = $gen0->cleanValue($v + $res);
                $changes[$key] = $v;
            }
        } elseif ($tryb == 14) {
            $nr = rand(2, 15);
            $bests = Gen0::where("area_id", $id)->where("dim", $dimension)->whereIn("tryb", [12, 13])->orderBy("result", "DESC")->take($nr)->get();
            $pattern = array_fill(0, 10, 0);
            $all = 0;
            foreach ($bests as $best) {
                $go = json_decode($best->data);
                for ($i = 0; $i < 10; $i++) {
                    $pattern[$i] += $go[$i];
                }
                $all++;
            }
            for ($i = 0; $i < 10; $i++) {
                $changes[$i] = round($pattern[$i] / $all);
                $pattern[$i] = $gen0->cleanValue($changes[$i]);
            }
        } elseif ($tryb == 15) {
            $best = Gen0::where("area_id", $id)->where("dim", $dimension)->where("tryb", 4)->orderBy("result", "DESC")->first();
            $bestR = $best->result;
            $pattern = json_decode($best->data);
            foreach ($pattern as $key => $res) {
                $v = rand(-2, 2);
                $pattern[$key] = $gen0->cleanValue($v + $res);
                $changes[$key] = $v;
            }
        } elseif ($tryb == 16) {
            $best = Gen0::where("area_id", $id)->where("dim", $dimension)->where("tryb", 4)->orderBy("result", "DESC")->first();
            $bestR = $best->result;
            $pattern = json_decode($best->data);
            foreach ($pattern as $key => $res) {
                $v = rand(-1, 1);
                $pattern[$key] = $gen0->cleanValue($v + $res);
                $changes[$key] = $v;
            }
        } elseif ($tryb == 17) {
            $best = Gen0::where("area_id", $id)->where("dim", $dimension)->orderBy("result", "DESC")->take(15)->get()->shuffle()->first();
            $pattern = json_decode($best->data);
            $bestR = $best->result;
            $val = rand(1, 2);
            $keys = $gen0->getTwoKeysFromPattern($pattern, $val);
            $pattern[$keys[0]] = $gen0->cleanValue($pattern[$keys[0]] - $val);
            $pattern[$keys[1]] = $gen0->cleanValue($pattern[$keys[1]] + $val);
            $changes[$keys[0]] = -1 * $val;
            $changes[$keys[1]] = $val;
        } elseif ($tryb == 18) {
            $best = Gen0::where("area_id", $id)->where("dim", $dimension)->orderBy("result", "DESC")->take(10)->get()->shuffle()->first();
            $pattern = json_decode($best->data);
            $bestR = $best->result;
            $key = rand(0, count($pattern) - 1);
            $v = rand(-2, 2);
            $changes[$key] = $v;
            $pattern[$key] =  $gen0->cleanValue($v + $pattern[$key]);
        } elseif ($tryb == 19) { // AVG
            $best = Gen0::where("area_id", $id)->where("dim", $dimension)->orderBy("result", "DESC")->take(20)->get();
            $newpattern = array_fill(0, 10, 0);
            $all = 0;
            foreach ($best as $b) {
                $pattern = json_decode($b->data);
                foreach ($pattern as $key => $val) {
                    $newpattern[$key] += $val;
                }
                $all++;
            }
            foreach ($newpattern as $key => $val) {
                $newpattern[$key] = round($val / $all);
            }
        } elseif ($tryb == 20) { // ONLY FOR TEST
            $pattern = array_fill(0, 10, 30);
        }


        $halfPopulation = floor($this->startPopulation / 2);
        $cross->setNr($halfPopulation);
        $mutation->setNumerMutation($halfPopulation);
        $maxPoints = $gtx->getmaxPoints($this->nrMaxPopulation);
        $table = json_decode($area->data);
        $headPoints = $gtx->calcPoints($this->nrMaxPopulation, $table);
        $individual = 10;

        for ($i = 0; $i < $this->manyrepeat; $i++) {

            $population0 = [];
            for ($n = 0; $n < $this->startPopulation; $n++) {
                $population0[] = $gen0->createBoard($pattern, 10);
            }

            $res = $gtx->calcPopulation($population0, $headPoints);
            unset($population0);

            $nrPop = 0;
            $maxQ = $res[0]['sum'];

            while ($nrPop < $this->maxPopulation && $maxQ < $maxPoints) {

                $selectedIndividuals = $gtx->getindyvidual($res, $individual);
                $pop_result = $cross->createNewPopulation($selectedIndividuals);
                $pop_result = $mutation->addmutation($pop_result[0], $pop_result[1]);
                $res = $gtx->calcPopulation($pop_result[0], $headPoints, $pop_result[1]);

                $maxQ = $res[0]['sum'];
                $nrPop++;
            }
            $last = $res[0]['sum'];
            $result = $last / $maxPoints;
            $create = ["area_id" => $id, "result" => $result, "population" => $nrPop, "data" => json_encode($pattern), "tryb" => $tryb, "dim" => $dimension];
            if ($tryb == 5  || $tryb == 6 || $tryb == 7  || $tryb == 8 || $tryb == 9 || $tryb == 10 || $tryb == 11 || $tryb == 15 || $tryb == 16 || $tryb == 17  || $tryb == 18) {
                $create['changes'] = json_encode($changes);
                if ($result > $bestR) {
                    $create['worked'] = 1;
                }
            }
            if ($tryb == 13) {
                $create['changes'] = json_encode($changes);
            }
            Gen0::create($create);
            if ($settBox) {
                Calculation::create([
                    "result" => "Obliczenia Gen0",
                    "data" => json_encode($res[0]['area']),
                    "area_id" => $settBox,
                    "level" => 1,
                    "obtainedresult" => $result,
                    "typecalc" => 102,
                    "population" => $nrPop,
                ]);
            }
            unset($res);
        }

        return redirect("/showgeneration0/" . $id . "/" . $dimension)->with('success', 'Obliczono pierwsze pokolenie dla ' . json_encode($pattern));
    }

    public function calcAltGen0($id, $dimension, Generation0Helper $gen0, CrossingData $cross, MutationData $mutation, GenetixDataGenerator $gtx)
    {

        set_time_limit(40000);
        ini_set('memory_limit', '300M');

        $gen0->setDimension($dimension);
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }

        $halfPopulation = floor($this->startPopulation / 2);
        $cross->setNr($halfPopulation);
        $mutation->setNumerMutation($halfPopulation);
        $maxPoints = $gtx->getmaxPoints($this->nrMaxPopulation);
        $table = json_decode($area->data);
        $headPoints = $gtx->calcPoints($this->nrMaxPopulation, $table);
        $individual = 10;

        $pattern = [];
        $best = Gen0::where("area_id", $id)->where("dim", $dimension)->orderBy("result", "DESC")->take(50)->get()->shuffle()->first();
        $bestR = $best->result;
        $pattern = json_decode($best->data);
        $oldP = $pattern;

        for ($i = 0; $i < $this->manyAltrepeat; $i++) {

            $population0 = [];
            for ($n = 0; $n < $this->startPopulation; $n++) {
                $population0[] = $gen0->createBoard($pattern, 10);
            }

            $res = $gtx->calcPopulation($population0, $headPoints);
            unset($population0);

            $nrPop = 0;
            $maxQ = $res[0]['sum'];

            while ($nrPop < $this->maxPopulation && $maxQ < $maxPoints) {

                $selectedIndividuals = $gtx->getindyvidual($res, $individual);
                $pop_result = $cross->createNewPopulation($selectedIndividuals);
                $pop_result = $mutation->addmutation($pop_result[0], $pop_result[1]);
                $res = $gtx->calcPopulation($pop_result[0], $headPoints, $pop_result[1]);

                $maxQ = $res[0]['sum'];
                $nrPop++;
            }
            $last = $res[0]['sum'];
            $result = $last / $maxPoints;
            $reson = 0;
            if ($result >  $bestR) {
                $reson = 1;
            }
            $bestR = $result;

            $stiffPattern = $gtx->getStiffPattern([$res[0]['area']], 10, 10);
            $pattern0 = $gen0->calcPattern($stiffPattern[1]);

            $create = [
                "area_id" => $id,
                "result" => $result,
                "population" => $nrPop,
                "data" => json_encode($pattern),
                "tryb" => 21,
                "dim" => $dimension,
                "data2" => json_encode($pattern0),
                "reson" => $reson
            ];

            Gen0::create($create);
            $pattern = $pattern0;
            unset($res);
        }

        return redirect("/showgeneration0/" . $id . "/" . $dimension)->with('success', 'Obliczono ciąg obliczeń gen0 dla ' . json_encode($oldP));
    }

    /** METHOD TO TEST */
    public function helpshowgeneration0($id, $dimension, Generation0Helper $gen0,  GenetixDataGenerator $gtx)
    {
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }

        $pgen = Gen0::where("area_id", $id)->orderBy("result", "desc")->where("dim", $dimension);
        $gen = $pgen->take(500)->get()->toArray();
        $stiffPattern = $gtx->getStiffPattern([$area], 10, 10);
        $gen0->setDimension($dimension);
        $pattern0 = $gen0->calcPattern($stiffPattern[1]);


        foreach ($gen as $key => $g2) {
            $pattern = json_decode($g2['data']);
            $sum = 0;
            for ($i = 0; $i < 10; $i++) {
                $sum += abs($pattern[$i] - $pattern0[$i]);
            }
            $gen[$key]['diff'] = $sum;
        }
        return view("helpshowgeneration0", ['area' => $area, 'gen' => $gen,   "dimension" => $dimension]);
    }
}
