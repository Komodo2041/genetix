<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Gen0;
use App\Models\Area;
use App\Services\GenetixDataGenerator;

use App\Models\Calculation;

use App\Services\CrossingData;
use App\Services\MutationData;

use App\Services\Generation0Helper;

class Gen0Controller extends Controller
{

    // php artisan app:calc-gen0 16 6 
    // php artisan app:calc-gen0 16 5
    // php artisan app:calc-gen0 16 9

    // app:calc-gen0_ciag 17 0

    // app:calc-gen0-x-y-z 17 20

    // php artisan app:up-down-gen-z 17 0
    // php artisan app:calc-adv-gen0 24 {nr=10}

    public $nrMaxPopulation = 120;

    public $manyrepeat = 1;
    public $manyAltrepeat = 10;

    public $maxPopulation = 10;
    public $startPopulation = 800;


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
        } elseif ($onshow == 3) {
            $pgen = $pgen->whereIn("tryb", [21, 22]);
        } elseif ($onshow == 4) {
            $pgen = $pgen->whereIn("tryb", [23, 24]);
        } elseif ($onshow == 5) {
            $pgen = $pgen->whereIn("tryb", [25, 26, 27, 28, 29, 30, 31, 32, 33]);
        } elseif ($onshow == 6) {
            $pgen = $pgen->whereIn("tryb", [34, 35]);
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
            $res = $this->loopCalculating($nrPop, $gtx, $cross, $mutation, $individual, $res,  $maxPoints,  $headPoints);

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
            $this->saveGen0InCalculation($area, $dimension, $res, $nrPop, $result);
            unset($res);
        }

        return redirect("/showgeneration0/" . $id . "/" . $dimension)->with('success', 'Obliczono pierwsze pokolenie dla ' . json_encode($pattern));
    }

    private function saveGen0InCalculation($area, $dimension, $res, $nrPop, $result)
    {
        if ($dimension != 0) {
            return;
        }
        $headarea = $area;

        if ($area->river) {
            $headarea = Area::find($area->river);
        }
        $settBox = 0;
        $settGen0 = Area::where("river", $headarea->id)->where("gen0set", 1)->first();
        if ($settGen0) {
            $settBox = $settGen0->id;
        }

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
        } else {
            $basket = Area::where("river", $area->id)->where("basket", 1)->first();
            if (!$basket) {
                $basket = Area::create(["name" => $area->name . " - Kosz", "data" => $area->data, "river" => $area->id, "basket" => 1]);
            }
            $max = Calculation::where("area_id", $area->id)->max("obtainedresult");
            $max = (1 - $max) / 2 + $max;
            if ($result > $max) {
                Calculation::create([
                    "result" => "Obliczenia Gen0 - kosz",
                    "data" => json_encode($res[0]['area']),
                    "area_id" => $basket->id,
                    "level" => 1,
                    "obtainedresult" => $result,
                    "typecalc" => 109,
                    "population" => $nrPop,
                ]);
            }
        }
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
            $res = $this->loopCalculating($nrPop, $gtx, $cross, $mutation, $individual, $res,  $maxPoints,  $headPoints);
            $last = $res[0]['sum'];
            $result = $last / $maxPoints;
            $reson = 0;
            if ($result >  $bestR) {
                $reson = 1;
            }
            $bestR = $result;

            $stiffPattern = $gtx->getStiffPattern([$res[0]['area']], 10, 10, 2);
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
            $this->saveGen0InCalculation($area, $dimension, $res, $nrPop, $result);
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

    public function calc3DimGen0($id, Generation0Helper $gen0, CrossingData $cross, MutationData $mutation, GenetixDataGenerator $gtx)
    {

        set_time_limit(40000);
        ini_set('memory_limit', '300M');

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
        $best = Gen0::where("area_id", $id)->where("dim", 0)->orderBy("result", "DESC")->take(50)->get()->shuffle()->first();
        $patternZ = json_decode($best->data);
        $bestX = Gen0::where("area_id", $id)->where("dim", 1)->orderBy("result", "DESC")->take(50)->get()->shuffle()->take(10)->toArray();
        $countX = count($bestX);
        $bestY = Gen0::where("area_id", $id)->where("dim", 2)->orderBy("result", "DESC")->take(50)->get()->shuffle()->take(10)->toArray();
        $countY = count($bestY);

        $all = 0;
        for ($i = 0; $i < 10; $i++) {
            $all += $patternZ[$i];
        }
        $patternX = null;
        $patternY = null;

        for ($i = 0; $i < $this->manyrepeat; $i++) {

            $population0 = [];
            for ($n = 0; $n < $this->startPopulation; $n++) {
                $patternX = json_decode($bestX[rand(0, $countX - 1)]['data']);
                $patternY = json_decode($bestY[rand(0, $countY - 1)]['data']);
                $$population0[] = $gen0->createBoard3Dim($patternZ, $patternX, $patternY, $all, 10);
            }

            $res = $gtx->calcPopulation($population0, $headPoints);
            unset($population0);

            $nrPop = 0;
            $res = $this->loopCalculating($nrPop, $gtx, $cross, $mutation, $individual, $res,  $maxPoints,  $headPoints);

            $last = $res[0]['sum'];
            $result = $last / $maxPoints;


            $create = [
                "area_id" => $id,
                "result" => $result,
                "population" => $nrPop,
                "data" => json_encode($patternZ),
                "tryb" => 22,
                "dim" => 0,
                "data2" => json_encode(["Z" => $patternZ, "X" => $patternX, "Y" => $patternY])
            ];

            Gen0::create($create);
            $this->saveGen0InCalculation($area, 0, $res, $nrPop, $result);
            unset($res);
        }

        return redirect("/showgeneration0/" . $id . "/0")->with('success', 'Obliczono gen0 na podstawie X, Y, Z ');
    }

    public function calcUp50OneGen0($id, $upDown, Generation0Helper $gen0, CrossingData $cross, MutationData $mutation, GenetixDataGenerator $gtx, $gen0Id = null)
    {

        set_time_limit(40000);
        ini_set('memory_limit', '300M');

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

        $change = 50;
        $tryb = 23;
        if ($upDown == 1) {
            $tryb = 24;
        } elseif ($upDown == 2) {
            $change = 20;
            $tryb = 34;
        } elseif ($upDown == 3) {
            $change = 20;
            $tryb = 35;
        }

        $pattern = [];
        if ($gen0Id) {
            $best = Gen0::where("area_id", $id)->where("dim", 0)->where("id", $gen0Id)->first();
        } else {
            $best = Gen0::where("area_id", $id)->where("dim", 0)->orderBy("result", "DESC")->take(50)->get()->shuffle()->first();
        }

        $pattern = json_decode($best->data);
        $changes = [];

        for ($i = 0; $i < 10; $i++) {
            $changes = array_fill(0, 10, 0);
            $pattern0 = $pattern;
            if ($upDown == 0 || $upDown == 2) {
                $pattern0[$i] = $gen0->cleanValue($pattern0[$i] + $change);
                $changes[$i] = $change;
            } elseif ($upDown == 1  || $upDown == 3) {
                $pattern0[$i] = $gen0->cleanValue($pattern0[$i] - $change);
                $changes[$i] = -1 * $change;
            }

            $population0 = [];
            for ($n = 0; $n < $this->startPopulation; $n++) {
                $population0[] = $gen0->createBoard($pattern0, 10);
            }

            $res = $gtx->calcPopulation($population0, $headPoints);
            unset($population0);

            $nrPop = 0;

            $res = $this->loopCalculating($nrPop, $gtx, $cross, $mutation, $individual, $res,  $maxPoints,  $headPoints);

            $last = $res[0]['sum'];
            $result = $last / $maxPoints;

            $create = [
                "area_id" => $id,
                "result" => $result,
                "population" => $nrPop,
                "data" => json_encode($pattern0),
                "tryb" => $tryb,
                "dim" => 0,
                "data2" => json_encode($pattern),
                "prev" => $best->id,
                "changes" => json_encode($changes),
                "nrpom" => $i,
            ];

            Gen0::create($create);
            $this->saveGen0InCalculation($area, 0, $res, $nrPop, $result);
            unset($res);
        }

        return redirect("/showgeneration0/" . $id . "/0")->with('success', 'Obliczono Zmianę o ' . $change . "  " . json_encode($pattern));
    }

    public function advancedGen0($id, $tryb = 1)
    {

        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }

        $all = [23, 24];
        $stere = [0, 1];
        $change = 50;
        if ($tryb == 2) {
            $all = [34, 35];
            $change = 20;
            $stere = [2, 3];
        }

        $results = Gen0::selectRaw("  count(id) AS count, prev AS id, tryb, MAX(result) AS max ")->where("area_id", $id)->whereIn("tryb", $all)->groupBy("prev", "tryb")->get()->toArray();

        $res = [];
        foreach ($results as $record) {
            $res[$record['id']][$record['tryb']] = $record;
            $res[$record['id']]['c0'] = 0;
            $res[$record['id']]['c1'] = 0;
            $res[$record['id']]['max'] = [];
            $res[$record['id']]['data'] = Gen0::find($record['id'])->data;
        }
        foreach ($res as $key => $record) {
            if (isset($record[$all[0]])) {
                $res[$key]['c0'] = $record[$all[0]]['count'];
                $res[$key]['max'][] = $record[$all[0]]['max'];
            }
            if (isset($record[$all[1]])) {
                $res[$key]['c1'] = $record[$all[1]]['count'];
                $res[$key]['max'][] = $record[$all[1]]['max'];
            }
        }

        return view("advgen0", ['res' => $res, "area" => $area, "change" => $change, "stere" => $stere, "tryb" => $tryb]);
    }

    public function calcAdvGen0($gid, $tryb, Generation0Helper $gen0, CrossingData $cross, MutationData $mutation, GenetixDataGenerator $gtx, $who = 1)
    {

        set_time_limit(40000);
        ini_set('memory_limit', '300M');

        $gen = Gen0::find($gid);
        if (!$gen) {
            return redirect("/")->with('error', 'Nie znaleziono podanego gen 0');
        }

        $area = Area::find($gen->area_id);
        if ($who == 1) {
            $up = Gen0::selectRaw("nrpom, AVG(result)  AS avg  ")->where("prev", $gid)->where("tryb", 23)->groupBy("nrpom")->orderBy("avg", "DESC")->get()->toArray();
            $down = Gen0::selectRaw("nrpom, AVG(result)  AS avg  ")->where("prev", $gid)->where("tryb", 24)->groupBy("nrpom")->orderBy("avg", "DESC")->get()->toArray();
        } elseif ($who == 2) {
            $up = Gen0::selectRaw("nrpom, AVG(result)  AS avg  ")->where("prev", $gid)->where("tryb", 34)->groupBy("nrpom")->orderBy("avg", "DESC")->get()->toArray();
            $down = Gen0::selectRaw("nrpom, AVG(result)  AS avg  ")->where("prev", $gid)->where("tryb", 35)->groupBy("nrpom")->orderBy("avg", "DESC")->get()->toArray();
        }

        if (count($up) != 10 && count($down) != 10) {
            return redirect("/")->with('error', 'Błedny data dla Gen0: ' . $gid);
        }

        $board = json_decode($gen->data);
        if ($tryb == 0) {
            $tryb = rand(25, 33);
        }

        $newchanges = array_fill(0, 10, 0);
        switch ($tryb) {
            case 25:
                for ($i = 0; $i < 10; $i++) {
                    $newchanges[$up[$i]['nrpom']] += 100 - $i * 10;
                    $newchanges[$down[$i]['nrpom']] -= 100 - $i * 10;
                }
                break;
            case 26:
                for ($i = 0; $i < 5; $i++) {
                    $newchanges[$up[$i]['nrpom']] += 100 - $i * 10;
                    $newchanges[$down[$i]['nrpom']] -= 100 - $i * 10;
                }
                break;
            case 27:
                for ($i = 0; $i < 2; $i++) {
                    $newchanges[$up[$i]['nrpom']] += 50;
                    $newchanges[$down[$i]['nrpom']] -= 50;
                }
                break;
            case 28:
                for ($i = 0; $i < 3; $i++) {
                    $newchanges[$up[$i]['nrpom']] += 50;
                    $newchanges[$down[$i]['nrpom']] -= 50;
                }
                break;
            case 29:
                for ($i = 0; $i < 4; $i++) {
                    $newchanges[$up[$i]['nrpom']] += 50;
                    $newchanges[$down[$i]['nrpom']] -= 50;
                }
                break;
            case 29:
                for ($i = 0; $i < 10; $i++) {
                    if ($up[$i]['avg'] > $gen->result) {
                        $newchanges[$up[$i]['nrpom']] += 50;
                    } else {
                        $newchanges[$up[$i]['nrpom']] -= 50;
                    }
                }
                break;
            case 30:
                for ($i = 0; $i < 10; $i++) {
                    if ($down[$i]['avg'] > $gen->result) {
                        $newchanges[$down[$i]['nrpom']] -= 50;
                    } else {
                        $newchanges[$down[$i]['nrpom']] += 50;
                    }
                }
                break;
            case 31:
                for ($i = 0; $i < 1; $i++) {
                    $newchanges[$up[$i]['nrpom']] += 50;
                    $newchanges[$down[$i]['nrpom']] -= 50;
                }
                break;
            case 32:
                for ($i = 0; $i < 10; $i++) {
                    if ($down[$i]['avg'] > $gen->result) {
                        $newchanges[$down[$i]['nrpom']] -= 50;
                    }
                }
                break;
            case 33:
                for ($i = 0; $i < 10; $i++) {
                    if ($up[$i]['avg'] > $gen->result) {
                        $newchanges[$up[$i]['nrpom']] += 50;
                    }
                }
                break;
        }
        for ($i = 0; $i < 10; $i++) {
            $board[$i] += $newchanges[$i];
            $board[$i] = $gen0->cleanValue($board[$i]);
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
                $population0[] = $gen0->createBoard($board, 10);
            }

            $res = $gtx->calcPopulation($population0, $headPoints);
            unset($population0);

            $nrPop = 0;
            $res = $this->loopCalculating($nrPop, $gtx, $cross, $mutation, $individual, $res,  $maxPoints,  $headPoints);

            $last = $res[0]['sum'];
            $result = $last / $maxPoints;

            $create = [
                "area_id" => $area->id,
                "result" => $result,
                "population" => $nrPop,
                "data" => json_encode($board),
                "tryb" => $tryb,
                "changes" => json_encode($newchanges),
                "prev" => $gid
            ];

            Gen0::create($create);
            $this->saveGen0InCalculation($area, 0, $res, $nrPop, $result);
            unset($res);
        }

        return redirect("/showgeneration0/" . $area->id . "/0")->with('success', 'Obliczono 25-33 dla gen0 ');
    }

    private function loopCalculating(&$nrPop, $gtx, $cross, $mutation, $individual, $res, $maxPoints,  $headPoints)
    {
        $maxQ = $res[0]['sum'];
        while ($nrPop < $this->maxPopulation && $maxQ < $maxPoints) {

            $selectedIndividuals = $gtx->getindyvidual($res, $individual);
            $pop_result = $cross->createNewPopulation($selectedIndividuals);
            $pop_result = $mutation->addmutation($pop_result[0], $pop_result[1]);
            $res = $gtx->calcPopulation($pop_result[0], $headPoints, $pop_result[1]);
            $maxQ = $res[0]['sum'];
            $nrPop++;
        }

        return $res;
    }

    public function showUpDownGen0Calc($gid, $tryb = 1)
    {

        $gen = Gen0::find($gid);
        if (!$gen) {
            return redirect("/")->with('error', 'Nie znaleziono podanego gen 0');
        }

        $area = Area::find($gen->area_id);
        if ($tryb == 1) {
            $up = Gen0::selectRaw("nrpom, AVG(result)  AS result, changes  ")->where("prev", $gid)->where("tryb", 23)->groupBy("nrpom", "changes")->orderBy("nrpom", "ASC")->get()->toArray();
            $down = Gen0::selectRaw("nrpom, AVG(result)  AS result, changes  ")->where("prev", $gid)->where("tryb", 24)->groupBy("nrpom", "changes")->orderBy("nrpom", "ASC")->get()->toArray();
        } elseif ($tryb == 2) {
            $up = Gen0::selectRaw("nrpom, AVG(result)  AS result, changes  ")->where("prev", $gid)->where("tryb", 34)->groupBy("nrpom", "changes")->orderBy("nrpom", "ASC")->get()->toArray();
            $down = Gen0::selectRaw("nrpom, AVG(result)  AS result, changes  ")->where("prev", $gid)->where("tryb", 35)->groupBy("nrpom", "changes")->orderBy("nrpom", "ASC")->get()->toArray();
        }

        if (count($up) != 10 && count($down) != 10) {
            return redirect("/")->with('error', 'Błedny data dla Gen0: ' . $gid);
        }

        return view("showUpDown", ['up' => $up, "down" => $down, "area" => $area, "gen0" => $gen]);
    }
}
