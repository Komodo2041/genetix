<?php

namespace App\Services;

use App\Models\PowerMatrix;

class GenetixDataGenerator
{

    public float $G = 6.67430e-11; // 
    public $probe = 10000;
    public $block = 1e6;

    private $preciso = 100000000000;
    private $pm = [];

    public function getFirstGeneration($size, $max, $numbers)
    {

        $allGeneration = [];
        $table = [];
        for ($dist = 0; $dist < $numbers; $dist++) {
            for ($i = 0; $i < $size; $i++) {
                for ($j = 0; $j < $size; $j++) {
                    for ($z = 0; $z < $size; $z++) {
                        $table[$i][$j][$z] = rand(0, $max);
                    }
                }
            }
            $allGeneration[] =  $table;
        }
        return $allGeneration;
    }

    public function calcPopulation($population0, $headPoints, $usedcrossing = [], $possible = null)
    {
        $res = [];
        $i = 0;
        $half = floor(count($headPoints) * 0.75);
        foreach ($population0 as $area) {
            $record = [];
            $pointsIndividual = $this->calcIndividualPoints($area, $headPoints, $possible);
            $record['points'] = $pointsIndividual;
            $record['area'] = $area;
            $record['stoped'] = count($pointsIndividual);
            if ($half < $record['stoped']) {
                $record['sum'] = $this->calcAreaPoints($pointsIndividual);
            } else {
                $record['sum'] = 1;
            }
            $record['id'] = $i;

            if (isset($usedcrossing[$i])) {
                $record['howitwascreated'] = $usedcrossing[$i];
            }
            $i++;
            $res[] = $record;
        }

        usort($res, function ($a, $b) {
            return $a['sum'] < $b['sum'];
        });

        return $res;
    }

    private function calcAreaPoints($pointsIndividual)
    {
        $res = 0;
        foreach ($pointsIndividual as $p) {
            $res += $p['fit'];
        }
        return $res;
    }

    public function calcPoints($nrPoints, $area)
    {

        $nr = 10;
        // Better Results
        $zOs = rand(0, 100);
        $allPoints = [];
        for ($pon = 0; $pon < $nrPoints; $pon++) {
            if ($pon % 3 == 0) {
                $zOs = rand(0, 100);
            }
            $point = ['x' => rand(0, 1000), 'y' => rand(0, 1000), 'z' => $zOs, 'v' => 0];

            $allForce = 0;
            $probeforce = $this->block * $this->probe * $this->G;
            for ($i = 0; $i < $nr; $i++) {
                for ($j = 0; $j < $nr; $j++) {
                    for ($z = 0; $z < $nr; $z++) {
                        $dist = $this->calcDist($point, $i, $j, $z);
                        $force = $probeforce * $area[$i][$j][$z];
                        $force = $force / ($dist * $dist);

                        $allForce += $force;
                    }
                }
            }
            $point['v'] = $allForce;
            $allPoints[] = $point;
        }

        return $allPoints;
    }

    private function calcIndividualPoints($area, $headPoints, $possible = null)
    {

        $nr = 10;
        $allPoints = [];
        $diffChange = 0;
        $possible = floor($possible * 1.2);

        foreach ($headPoints as $key => $point) {

            $allForce = 0;
            $probeforce = $this->block * $this->probe * $this->G;
            for ($i = 0; $i < $nr; $i++) {
                for ($j = 0; $j < $nr; $j++) {
                    for ($z = 0; $z < $nr; $z++) {
                        $dist = $this->calcDist($point, $i, $j, $z);
                        $force = $probeforce * $area[$i][$j][$z];
                        $force = $force / ($dist * $dist);

                        $allForce += $force;
                    }
                }
            }
            $point['v2'] = $allForce;
            $point['fit'] = $this->calcFit($point['v'], $point['v2']);
            $allPoints[] = $point;

            if ($possible) {
                $diffChange += $this->preciso - $point['fit'];
                if ($diffChange > $possible) {
                    break;
                }
            }
        }

        return $allPoints;
    }


    private function calcDist($point, $i, $j, $k)
    {

        $downx = 50 + $i * 100;
        $downy = 50 + $j * 100;
        $downz = 50 + $k * 100;

        $diffx = abs($point['x'] - $downx);
        $diffy = abs($point['y'] - $downy);
        $diffz = abs($point['z'] + $downz);
        $downDagonal = sqrt($diffx * $diffx + $diffy * $diffy);
        $dist = sqrt($diffz * $diffz + $downDagonal * $downDagonal);

        return $dist;
    }

    private function calcFit($v1, $v2)
    {
        $diff = abs($v1 - $v2);
        $change = $diff / $v1;
        $result = 0;
        if ($change <= 1) {
            $result = $this->preciso - $change * $this->preciso;
        }
        return $result;
    }

    public function getmaxPoints($nrpoints)
    {
        return $this->preciso * $nrpoints;
    }

    public function getindyvidual($res, $nr = 10)
    {

        $table = [];
        $usedres = [];
        $i = 0;
        while (count($table) <= $nr && isset($res[$i])) {

            if (!in_array($res[$i]['sum'], $usedres)) {
                $table[] = $res[$i]['area'];
                $usedres[] = $res[$i]['sum'];
            }
            $i++;
        }

        return $table;
    }


    public function getPower($population0)
    {

        $sum = 0;
        $nr = count($population0);
        for ($n = 0; $n < $nr; $n++) {
            $sum += $this->calcpowerone($population0[$n]);
        }
        return  $sum / $nr;
    }

    public function getPowerfromarea($population0, $nr = 10)
    {

        $sum = 0;
        for ($n = 0; $n < $nr; $n++) {
            $sum += $this->calcpowerone($population0[$n]['area']);
        }
        return $sum / $nr;
    }


    public function calcpowerone($area)
    {
        $sum = 0;
        $nr = 10;

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($area[$i][$j][$z]) {
                        $sum += $this->pm[$i][$j][$z];
                    }
                }
            }
        }
        return $sum;
    }

    public function usepower($newpopulaton, $power, $ug = 1)
    {

        $size = 10;

        $res = [];
        $diffUg = $this->getUg($ug);
        $minus = ($diffUg * 1000) / 2;


        foreach ($newpopulaton as $area) {
            $p = $this->calcpowerone($area);

            $diff = $p - $power;
            $abs = abs($diff);

            if ($abs <= $diffUg) {
                $res[] = $area;
            } else {
                $change = $abs + rand(-1 * $minus, $minus) / 1000;

                if ($diff < 0) {
                    $area = $this->addpower($area, $change, $size, $ug);
                } else {
                    $area = $this->removepower($area, $change, $size, $ug);
                }
                $res[] = $area;
            }
        }

        return $res;
    }

    private function getUg($ug)
    {
        switch ($ug) {
            case 1:
                return 6;
                break;
            case 2:
                return 2;
                break;
            case 3:
                return 0.5;
                break;
            case 4:
                return 0.1;
                break;
            case 5:
                return 0.03;
                break;
        }
    }

    private function addpower($pop, $change, $nr = 10, $ug = 1)
    {

        $diffUg = $this->getUg($ug);
        $m = $diffUg / 10;
        $n = 0;

        while ($m < $change && $n < 1000) {

            $x = rand(0, $nr - 1);
            $y = rand(0, $nr - 1);
            $z = rand(0, $nr - 1);
            if ($pop[$x][$y][$z] > 0) {
                $n--;
            } else {
                $pm = $this->pm[$x][$y][$z];

                if ($change - $pm >= -1 * $m) {
                    $pop[$x][$y][$z] = 1;
                    $change -= $pm;
                }
            }
            $n++;
        }

        return $pop;
    }

    private function removepower($pop, $change, $nr = 10, $ug = 1)
    {

        $diffUg = $this->getUg($ug);
        $m = $diffUg / 10;

        $n = 0;
        while ($m < $change && $n < 1000) {

            $x = rand(0, $nr - 1);
            $y = rand(0, $nr - 1);
            $z = rand(0, $nr - 1);
            if ($pop[$x][$y][$z] > 0) {
                $pm = $this->pm[$x][$y][$z];
                if ($change - $pm > -1 * $m) {
                    $pop[$x][$y][$z] = 0;
                    $change -= $pm;
                }
            } else {
                $n--;
            }
            $n++;
        }

        return $pop;
    }

    public function choosemodify($res, $nr, &$usedmodify)
    {

        for ($i = 0; $i < $nr; $i++) {
            if (isset($res[$i]['howitwascreated'])) {
                $hd = $res[$i]['howitwascreated'];
                if (isset($usedmodify[$hd])) {
                    $usedmodify[$hd]++;
                } else {
                    $usedmodify[$hd] = 1;
                }
            }
        }
    }


    public function getStiffPattern($calculations, $usedpercent, $nr = 10, $tryb = 0)
    {
        $blobAll = [];
        $stablePoints = [];
        $all = [];
        $count = count($calculations);
        $diff = 1 - $usedpercent / 100;

        foreach ($calculations as $c) {
            if ($tryb == 0) {
                $data = json_decode($c->data);
            } elseif ($tryb == 1) {
                $data = json_decode($c['data']);
            } elseif ($tryb == 2) {
                $data = $c;
            }

            for ($i = 0; $i < $nr; $i++) {
                for ($j = 0; $j < $nr; $j++) {
                    for ($z = 0; $z < $nr; $z++) {
                        if (isset($all[$i][$j][$z])) {
                            $all[$i][$j][$z] += $data[$i][$j][$z];
                        } else {
                            $all[$i][$j][$z] = $data[$i][$j][$z];
                        }
                    }
                }
            }
        }

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $all[$i][$j][$z] = $all[$i][$j][$z] / $count;
                    $ch = $all[$i][$j][$z];
                    $blobAll[$i][$j][$z] = round($ch);
                    if ($ch - $diff < 0 || $ch + $diff > 1) {
                        $stablePoints[$i][$j][$z] = 1;
                    } else {
                        $stablePoints[$i][$j][$z] = 0;
                    }
                }
            }
        }

        return [$stablePoints, $blobAll];
    }



    public function getStableGeneration($size, $numbers, $stable, $blob)
    {

        $allGeneration = [];

        $max = 1;
        for ($dist = 0; $dist < $numbers; $dist++) {
            $table = [];
            for ($i = 0; $i < $size; $i++) {
                for ($j = 0; $j < $size; $j++) {
                    for ($z = 0; $z < $size; $z++) {
                        if ($stable[$i][$j][$z] == 1) {
                            $table[$i][$j][$z] = $blob[$i][$j][$z];
                        } else {
                            $table[$i][$j][$z] = rand(0, 1);
                        }
                    }
                }
            }
            $allGeneration[] =  $table;
        }
        return $allGeneration;
    }

    public function getInvertStill($stable, $blob)
    {
        $table = [];
        $size = 10;
        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size; $j++) {
                for ($z = 0; $z < $size; $z++) {
                    if ($stable[$i][$j][$z] == 1) {
                        $table[$i][$j][$z] = $blob[$i][$j][$z];
                    } elseif ($blob[$i][$j][$z] == 1) {
                        $table[$i][$j][$z] = 0;
                    } else {
                        $table[$i][$j][$z] = 1;
                    }
                }
            }
        }

        return $table;
    }


    public function clonePattern($data, $size = 10, $change = 20, $nr = 10)
    {

        $all = [];

        for ($i = 0; $i < $size; $i++) {
            $table = $data;
            for ($m = 0; $m < $change; $m++) {
                $x = rand(0, $nr - 1);
                $y = rand(0, $nr - 1);
                $z = rand(0, $nr - 1);
                if ($table[$x][$y][$z] == 1) {
                    $table[$x][$y][$z] = 0;
                } else {
                    $table[$x][$y][$z] = 1;
                }
            }
            $all[] = $table;
        }

        return $all;
    }

    public function getStiilPatern($size, $numbers)
    {

        $table = [];
        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size; $j++) {
                for ($z = 0; $z < $size; $z++) {
                    $table[$i][$j][$z] = 1;
                }
            }
        }

        $n = 0;
        while ($n <= 100) {
            $x = rand(0, $size - 1);
            $y = rand(0, $size - 1);
            $z = rand(0, $size - 1);
            if ($table[$x][$y][$z] == 1) {
                $table[$x][$y][$z] = 0;
                $n++;
            }
        }
        return $table;
    }

    public function getPopulationFromStillTemplate($size, $numbers,  $template, $calc, $change)
    {
        $data = json_decode($calc->data);
        $res = [];
        for ($i = 0; $i < $numbers; $i++) {
            $table = $data;
            $to = 0;
            $many = rand(1, $change);
            while ($to < $many) {
                $x = rand(0, $size - 1);
                $y = rand(0, $size - 1);
                $z = rand(0, $size - 1);
                if ($template[$x][$y][$z] == 0) {
                    $table[$x][$y][$z] = rand(0, 1);
                    $to++;
                }
            }
            $res[] = $table;
        }
        return $res;
    }

    public function getStiilPaternXYZ($size)
    {

        $table = [];
        $changeOs = rand(0, 2);
        $defochange = rand(round($size / 2), $size - 1);

        $headval = 0;
        $headval1 = 1;
        $head = rand(0, 1);
        if ($head == 1) {
            $headval = 1;
            $headval1 = 0;
        }

        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size; $j++) {
                for ($z = 0; $z < $size; $z++) {
                    switch ($changeOs) {
                        case 0:
                            if ($i >= $defochange) {
                                $table[$i][$j][$z] = $headval;
                            } else {
                                $table[$i][$j][$z] = $headval1;
                            }
                            break;
                        case 1:
                            if ($j >= $defochange) {
                                $table[$i][$j][$z] = $headval;
                            } else {
                                $table[$i][$j][$z] = $headval1;
                            }
                            break;
                        case 2:
                            if ($z >= $defochange) {
                                $table[$i][$j][$z] = $headval;
                            } else {
                                $table[$i][$j][$z] = $headval1;
                            }
                            break;
                    }
                }
            }
        }

        return $table;
    }

    public function getWeightScale($data, $headPoints, $size = 10, $diff = 0.01)
    {

        $res = [];
        $pointsIndividual = $this->calcIndividualPoints($data, $headPoints);
        $max = $this->calcAreaPoints($pointsIndividual);

        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size; $j++) {
                for ($z = 0; $z < $size; $z++) {

                    $checked = $data;
                    if ($data[$i][$j][$z] == 1) {
                        $checked[$i][$j][$z] = 1 - $diff;
                    } else {
                        $checked[$i][$j][$z] = 0 + $diff;
                    }

                    $pointsIndividual = $this->calcIndividualPoints($checked, $headPoints);
                    $result = $this->calcAreaPoints($pointsIndividual);
                    if ($result > $max) {
                        $res[$i][$j][$z] = 1;
                    } else {
                        $res[$i][$j][$z] = 0;
                    }
                }
            }
        }

        return $res;
    }

    public function calcpointinarea($data, $size = 10)
    {
        $sum = 0;
        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size; $j++) {
                for ($z = 0; $z < $size; $z++) {
                    if ($data[$i][$j][$z] == 1) {
                        $sum++;
                    }
                }
            }
        }
        return $sum;
    }


    public function createPopulation0FromWaga($nr, $data, $wg, $pr)
    {
        $points = $this->calcpointinarea($wg, 10);
        $changePoints = round($pr * $points);
        $res = [];
        $size = 10;

        $pom = [];
        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size; $j++) {
                for ($z = 0; $z < $size; $z++) {
                    if ($wg[$i][$j][$z] == 1) {
                        $pom[] = [
                            'i' => $i,
                            'j' => $j,
                            'z' => $z
                        ];
                    }
                }
            }
        }

        for ($i = 0; $i < $nr; $i++) {
            shuffle($pom);
            $new = $data;
            for ($j = 0; $j < $changePoints; $j++) {
                $x = $pom[$j]['i'];
                $y = $pom[$j]['j'];
                $z = $pom[$j]['z'];
                if ($new[$x][$y][$z] == 1) {
                    $new[$x][$y][$z] = 0;
                } else {
                    $new[$x][$y][$z] = 1;
                }
            }
            $res[] = $new;
        }


        return $res;
    }

    public function createPopulation0FromWagaOnlyTop($nr, $data, $wg)
    {
        $res = [];
        $topZ = -1;
        $size = 10;

        $pom = [];
        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size; $j++) {
                for ($z = 0; $z < $size; $z++) {
                    if ($wg[$i][$j][$z] == 1 && $topZ == -1) {
                        $topZ = $z;
                        break;
                    }
                }
            }
        }
        $new = $data;
        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size; $j++) {
                for ($z = 0; $z < $size; $z++) {
                    if ($wg[$i][$j][$z] == 1 && $topZ == $z) {
                        if ($new[$i][$j][$z] == 1) {
                            $new[$i][$j][$z] = 0;
                        } else {
                            $new[$i][$j][$z] = 1;
                        }
                    }
                }
            }
        }
        $res[] = $new;

        for ($x = 0; $x < $nr - 1; $x++) {
            $new = $data;
            for ($i = 0; $i < $size; $i++) {
                for ($j = 0; $j < $size; $j++) {
                    for ($z = 0; $z < $size; $z++) {

                        if ($wg[$i][$j][$z] == 1 && $topZ == $z) {
                            $r = rand(0, 1);
                            if ($r == 1) {
                                if ($new[$i][$j][$z] == 1) {
                                    $new[$i][$j][$z] = 0;
                                } else {
                                    $new[$i][$j][$z] = 1;
                                }
                            }
                        }
                    }
                }
            }
            $res[] = $new;
        }
        return $res;
    }


    public function calcPowerPoints($area, $nr)
    {

        $allPoints = [];

        $point = ['x' => floor($nr * 100 / 2), 'y' => floor($nr * 100 / 2), 'z' => 50];

        $probeforce = $this->block * $this->probe * $this->G;
        $allForce = [];
        $res = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    $dist = $this->calcDist($point, $i, $j, $z);
                    $force = $probeforce * $area[$i][$j][$z];
                    $force = $force / ($dist * $dist);

                    $allPoints[$i][$j][$z] = $force;

                    $allForce[] = $force;
                }
            }
        }

        sort($allForce);
        $middle = $allForce[(int) floor(count($allForce) / 2)];


        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $res[$i][$j][$z] = $allPoints[$i][$j][$z] / $middle;
                }
            }
        }

        return $res;
    }


    public function setPowerMatrixSize($size)
    {
        $nr = 10;
        $data = PowerMatrix::where("size", $size)->first();
        if ($data) {
            $table = json_decode($data->data);
        } else {
            for ($i = 0; $i < $nr; $i++) {
                for ($j = 0; $j < $nr; $j++) {
                    for ($z = 0; $z < $nr; $z++) {
                        $table[$i][$j][$z] = 1;
                    }
                }
            }
        }

        $this->pm = $table;
    }

    public function generatePopinPower($nr, $pattern, $power, $ug = 1)
    {

        $res = [];
        $pop = [];
        for ($i = 0; $i < $nr; $i++) {
            $pop[] = $pattern;
        }
        $res = $this->usepower($pop, $power, $ug);
        return $res;
    }

    public function getDiffPattern($data, $pattern, $size = 10)
    {
        $res = [];
        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size; $j++) {
                for ($z = 0; $z < $size; $z++) {
                    if ($data[$i][$j][$z] == $pattern[$i][$j][$z]) {
                        $res[$i][$j][$z] = 0;
                    } else {
                        $res[$i][$j][$z] = 1;
                    }
                }
            }
        }
        return $res;
    }

    public function getmaxdiff($data, $size = 10)
    {
        $sum = 0;
        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size; $j++) {
                for ($z = 0; $z < $size; $z++) {
                    if ($data[$i][$j][$z] == 1) {
                        $sum++;
                    }
                }
            }
        }
        return $sum;
    }

    public function createPopulationFromAreaPattern($data, $i, $changes, $pattern, $max)
    {

        $res = [];
        for ($h = 0; $h < $max; $h++) {
            $res[] = $this->changeDataUseAreaPattern($data, $i, $changes, $pattern);
        }
        return $res;
    }

    private function changeDataUseAreaPattern($data, $i, $changes, $pattern, $size = 10)
    {

        for ($j = 0; $j < $i; $j++) {
            $ch = 2000;
            $x = rand(0, $size - 1);
            $y = rand(0, $size - 1);
            $z = rand(0, $size - 1);
            while ($changes[$x][$y][$z] == 0 && $ch > 0) {
                $x = rand(0, $size - 1);
                $y = rand(0, $size - 1);
                $z = rand(0, $size - 1);

                $ch--;
            }
            $data[$x][$y][$z] = $pattern[$x][$y][$z];
            $changes[$x][$y][$z] = 0;
        }

        return $data;
    }
}
