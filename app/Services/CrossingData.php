<?php

namespace App\Services;

use App\Models\PowerMatrix;

class CrossingData
{

    public $nrcrossing = 490;
    private $matrixpowerorder = [];


    public $multipleCrossings = [
        "blob6random",
        "blob3random",
        "blob3",
        "blob6",
        "layersinx4",
        "layersinj4",
        "layersinz4",
        "useavgojoindiffe",
        "blob6_fromthelevel",
        "blob6_wfiverandom",
        "blob6_wonerandom",
        "blob3_fromthelevel",
        "blob3_wfiverandom",
        "blob3_wonerandom",
        "random50multiple"
    ];
    public $bestCrossing = ["updown",  "tassingz", "joinwith0", "joinwith0", "tassingy",  "squerInSquere7AxX"];

    public $methods = [
        "updown",
        "tassingz",
        "squerInSquere6AxX",
        "squerInSquere5AxZ",
        "squerInSquere6AxY",
        "squerInSquere7AxY",
        "squerInSquere7AxX",
        "blob6random",
        "blob3random",
        "blob3",
        "blob6",
        "squerInSquere5AxX",
        "squerInSquere5AxY",
        "layersinx4",
        "layersinj4",
        "layersinz4",
        "layersinj2",
        "layersinz2",
        "layersinx2",
        "layersin2xyz",
        "chessboardrandom_xz",
        "squerInSquere6AxZ",
        "squerInSquere7AxZ",
        "chessboard_xy",
        "chessboard_xz",
        "chessboard_yz",
        "usedblockhalfhalfrandom",
        "tassingx",
        "chessboardradom_xy",
        "leftright",
        "leftright2",
        "random50",
        "usedblockhalfhalf",
        "chessboardrandom_yz",
        "joinwith0",
        "joinwith1",
        "cutting_xy",
        "cutting_xz",
        "cutting_yz",
        "chessboardrandom_xyz",
        "tassingy",
        "joinwith_0or1_random",
        "joinwith_0or1_random2",
        "useavgojoindiffe",
        "useavgojoindiffeRandom",
        "rand6x6x6",
        "rand5x5x5",
        "rand7x7x7",
        "random90",
        "random75",
        "rand4x4x4",
        "rand8x8x8",
        "rand9x9x9",
        "rand6x6x6Multiple",
        "rand5x5x5Multiple",
        "rand4x4x4Multiple",
        "rand7x7x7Multiple",
        "rand8x8x8Multiple",
        "blockRandomXY",
        "blockRandomYZ",
        "blockRandomXZ",
        "updwownup_Z",
        "updwownup_Y",
        "updwownup_X",
        "sandwich_Y",
        "sandwich_X",
        "sandwich_Z",
        "joinwith_one_join1",
        "joinwith_one_join0",
        "get5x5x1Multiple",
        "get4x4x1Multiple",
        "get3x3x1Multiple40",
        "get3x3x1Multiple",
        "blob6_fromthelevel",
        "blob6_wfiverandom",
        "blob6_wonerandom",
        "blob3_fromthelevel",
        "blob3_wfiverandom",
        "blob3_wonerandom",
        "upDownLayerPowerMatrix100",
        "upDownLayerPowerMatrix125",
        "upDownLayerPowerMatrix50",
        "upDownLayerPowerMatrix25",
        "tassingLayerPowerMatrix25",
        "tassingLayerPowerMatrix50",
        "tassingLayerPowerMatrix125",
        "tassingLayerPowerMatrix100",
        "crystalsize5",
        "crystalsize4",
        "crystalsize3",
        "mozaics",
        "rombsquere1_inZ",
        "crystalsize6",
        "rombsquere2_inZ",
        "rombsquere3_inZ",
        "rombsquere4_inZ",
        "rombsquere5_inZ",
        "rombsquere7_inZ",
        "rombsquere6_inZ",
        "rombsquere3_inY",
        "rombsquere3_inX",
        "random50multiple"
    ];

    public function createNewPopulation($population, $cr = null)
    {
        if ($cr) {
            $this->methods = [$cr];
        }
        $max = count($population);
        $res = [];
        $crossing = [];
        $nrmethod = count($this->methods);

        for ($i = 0; $i < $this->nrcrossing; $i++) {
            $m = $this->methods[rand(0, $nrmethod - 1)];

            if (count($population) < 6) {
                if (in_array($m, $this->multipleCrossings)) {
                    $m = $this->bestCrossing[rand(0, count($this->bestCrossing) - 1)];
                }
            }
            $area = $this->$m($population, $max);
            $res[] = $area;
            $crossing[] = $m;
        }
        return [$res, $crossing];
    }

    private function random50($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if (rand(0, 1) == 0) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function tassingz($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($z % 2 == 0) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function tassingx($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i % 2 == 0) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function tassingy($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($j % 2 == 0) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function updown($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $zlevel = rand(1, $nr - 1);
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($z <= $zlevel) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function leftright($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $xlevel = rand(1, $nr - 1);
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i <= $xlevel) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function leftright2($population, $max, $nr = 10)
    {

        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $ylevel = rand(1, $nr - 1);
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($j <= $ylevel) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function cutting_xy($population, $max, $nr = 10)
    {

        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $level = rand(3, $nr * 2 - 3);
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i + $j <= $level) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function cutting_xz($population, $max, $nr = 10)
    {

        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $level = rand(3, $nr * 2 - 3);
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i + $z <= $level) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function cutting_yz($population, $max, $nr = 10)
    {

        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $level = rand(3, $nr * 2 - 3);
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($j + $z <= $level) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function cutting_xyz($population, $max, $nr = 10)
    {

        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $level = rand(5, $nr * 3 - 5);
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($j + $z + $i <= $level) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function joinwith0($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($one[$i][$j][$z] == 1 && $two[$i][$j][$z] == 1) {
                        $table[$i][$j][$z] = 1;
                    } else {
                        $table[$i][$j][$z] = 0;
                    }
                }
            }
        }
        return $table;
    }

    private function joinwith1($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($one[$i][$j][$z] == 0 && $two[$i][$j][$z] == 0) {
                        $table[$i][$j][$z] = 0;
                    } else {
                        $table[$i][$j][$z] = 1;
                    }
                }
            }
        }
        return $table;
    }



    private function chessboard_xy($population, $max, $nr = 10)
    {

        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if (($i + $j) % 2 == 1) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function chessboard_xz($population, $max, $nr = 10)
    {

        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if (($i + $z) % 2 == 1) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function chessboard_yz($population, $max, $nr = 10)
    {

        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if (($z + $j) % 2 == 1) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function chessboardradom_xy($population, $max, $nr = 10)
    {

        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $usedtwenty = $this->get20rand();


        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($usedtwenty[$i + $j]) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function chessboardrandom_xz($population, $max, $nr = 10)
    {

        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $usedtwenty = $this->get20rand();

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($usedtwenty[$i + $z]) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function chessboardrandom_yz($population, $max, $nr = 10)
    {

        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $usedtwenty = $this->get20rand();

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($usedtwenty[$j + $z]) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function usedblockhalfhalf($population, $max, $nr = 10)
    {

        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = floor($i / 5) + floor($j / 5) + floor($z / 5);
                    if ($sum % 2 == 1) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function usedblockhalfhalfrandom($population, $max, $nr = 10)
    {

        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $usedtwenty = $this->get20rand();

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = floor($i / 5) * 4 + floor($j / 5) * 2 + floor($z / 5) * 1;
                    if ($usedtwenty[(int)$sum]) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function chessboardrandom_xyz($population, $max, $nr = 10)
    {

        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $usedtwenty = $this->get20rand();

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($usedtwenty[$i + $j + $z]) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }


    private function get20rand()
    {
        $table = [];
        for ($i = 0; $i < 30; $i++) {
            $table[] = rand(0, 1);
        }
        return $table;
    }

    private function getRand($max)
    {
        $res = [];
        for ($i = 0; $i < $max; $i++) {
            $res[] = $i;
        }
        shuffle($res);
        return $res;
    }

    private function squerInSquere7AxZ($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $pom1 = rand(0, 2);
        $pom2 = rand(0, 2);

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if ($i > $pom1 && $i <= $pom1 + 7 && $j > $pom2 && $j <= $pom2 + 7) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function squerInSquere7AxY($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $pom1 = rand(0, 2);
        $pom2 = rand(0, 2);

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if ($i > $pom1 && $i <= $pom1 + 7 && $z > $pom2 && $z <= $pom2 + 7) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function squerInSquere7AxX($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $pom1 = rand(0, 2);
        $pom2 = rand(0, 2);

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if ($j > $pom1 && $j <= $pom1 + 7 && $z > $pom2 && $z <= $pom2 + 7) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function squerInSquere6AxZ($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $pom1 = rand(0, 3);
        $pom2 = rand(0, 3);

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if ($i > $pom1 && $i <= $pom1 + 6 && $j > $pom2 && $j <= $pom2 + 6) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function squerInSquere6AxY($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $pom1 = rand(0, 3);
        $pom2 = rand(0, 3);

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if ($i > $pom1 && $i <= $pom1 + 6 && $z > $pom2 && $z <= $pom2 + 6) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function squerInSquere6AxX($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $pom1 = rand(0, 3);
        $pom2 = rand(0, 3);

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if ($j > $pom1 && $j <= $pom1 + 6 && $z > $pom2 && $z <= $pom2 + 6) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function squerInSquere5AxZ($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $pom1 = rand(0, 4);
        $pom2 = rand(0, 4);

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if ($i > $pom1 && $i <= $pom1 + 5 && $j > $pom2 && $j <= $pom2 + 5) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function squerInSquere5AxY($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $pom1 = rand(0, 4);
        $pom2 = rand(0, 4);

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if ($i > $pom1 && $i <= $pom1 + 5 && $z > $pom2 && $z <= $pom2 + 5) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function squerInSquere5AxX($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $pom1 = rand(0, 4);
        $pom2 = rand(0, 4);

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if ($j > $pom1 && $j <= $pom1 + 5 && $z > $pom2 && $z <= $pom2 + 5) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }


    private function blob3($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $three = $population[$randNumbers[2]];
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = $one[$i][$j][$z] + $two[$i][$j][$z] + $three[$i][$j][$z];
                    if ($sum <= 1) {
                        $table[$i][$j][$z] = 0;
                    } else {
                        $table[$i][$j][$z] = 1;
                    }
                }
            }
        }
        return $table;
    }


    private function blob3random($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $three = $population[$randNumbers[2]];
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = $one[$i][$j][$z] + $two[$i][$j][$z] + $three[$i][$j][$z];
                    if ($sum < 1) {
                        $table[$i][$j][$z] = 0;
                    } elseif ($sum > 2) {
                        $table[$i][$j][$z] = 1;
                    } else {
                        $table[$i][$j][$z] = rand(0, 1);
                    }
                }
            }
        }
        return $table;
    }

    private function blob6($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $blob = [];
        for ($k = 0; $k < 6; $k++) {
            $blob[] = $population[$k];
        }

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = 0;
                    for ($k = 0; $k < 6; $k++) {
                        $sum += $blob[$k][$i][$j][$z];
                    }
                    if ($sum <= 3) {
                        $table[$i][$j][$z] = 0;
                    } else {
                        $table[$i][$j][$z] = 1;
                    }
                }
            }
        }
        return $table;
    }

    private function blob6random($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $blob = [];
        for ($k = 0; $k < 6; $k++) {
            $blob[] = $population[$k];
        }

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = 0;
                    for ($k = 0; $k < 6; $k++) {
                        $sum += $blob[$k][$i][$j][$z];
                    }
                    if ($sum <= 1) {
                        $table[$i][$j][$z] = 0;
                    } elseif ($sum >= 5) {
                        $table[$i][$j][$z] = 1;
                    } else {
                        $table[$i][$j][$z] = rand(0, 1);
                    }
                }
            }
        }
        return $table;
    }


    private function layersinz2($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($nr);
        $pom = [];
        for ($k = 0; $k < 2; $k++) {
            $pom[] = $randNumbers[$k];
        }
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];


        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if (in_array($z, $pom)) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function layersinx2($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($nr);
        $pom = [];
        for ($k = 0; $k < 2; $k++) {
            $pom[] = $randNumbers[$k];
        }
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if (in_array($i, $pom)) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function layersinj2($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($nr);
        $pom = [];
        for ($k = 0; $k < 2; $k++) {
            $pom[] = $randNumbers[$k];
        }
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if (in_array($j, $pom)) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function layersinz4($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($nr);
        $pom = [];
        for ($k = 0; $k < 4; $k++) {
            $pom[] = $randNumbers[$k];
        }
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if (in_array($z, $pom)) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function layersinx4($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($nr);
        $pom = [];
        for ($k = 0; $k < 4; $k++) {
            $pom[] = $randNumbers[$k];
        }
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if (in_array($i, $pom)) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function layersinj4($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($nr);
        $pom = [];
        for ($k = 0; $k < 4; $k++) {
            $pom[] = $randNumbers[$k];
        }
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if (in_array($j, $pom)) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }


    private function layersin2xyz($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($nr);
        $pom = [];
        $pom1 = [];
        $pom2 = [];
        for ($k = 0; $k < 2; $k++) {
            $pom[] = $randNumbers[$k];
        }
        $randNumbers = $this->getRand($nr);
        for ($k = 0; $k < 2; $k++) {
            $pom1[] = $randNumbers[$k];
        }
        $randNumbers = $this->getRand($nr);
        for ($k = 0; $k < 2; $k++) {
            $pom2[] = $randNumbers[$k];
        }
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if (in_array($i, $pom) || in_array($j, $pom1) || in_array($z, $pom2)) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function joinwith_0or1_random($population, $max, $nr = 10, $maxstere = 1)
    {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $table = [];

        $stere = [];
        for ($i = 0; $i < $nr; $i++) {
            if ($maxstere == 4 || $maxstere == 5) {
                $stere[] = 2;
            } else {
                $stere[] = rand(0, $maxstere);
            }
        }

        if ($maxstere == 4) {
            $stere[rand(0, count($stere) - 1)] = 0;
        } elseif ($maxstere == 5) {
            $stere[rand(0, count($stere) - 1)] = 1;
        }

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($stere[$z] == 0) {
                        if ($one[$i][$j][$z] == 1 && $two[$i][$j][$z] == 1) {
                            $table[$i][$j][$z] = 1;
                        } else {
                            $table[$i][$j][$z] = 0;
                        }
                    } elseif ($stere[$z] == 1) {
                        if ($one[$i][$j][$z] == 1 || $two[$i][$j][$z] == 1) {
                            $table[$i][$j][$z] = 1;
                        } else {
                            $table[$i][$j][$z] = 0;
                        }
                    } elseif ($stere[$z] == 2) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } elseif ($stere[$z] == 3) {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function joinwith_0or1_random2($population, $max, $nr = 10)
    {
        return $this->joinwith_0or1_random($population, $max, $nr, 3);
    }

    private function joinwith_one_join1($population, $max, $nr = 10)
    {
        return $this->joinwith_0or1_random($population, $max, $nr, 4);
    }

    private function joinwith_one_join0($population, $max, $nr = 10)
    {
        return $this->joinwith_0or1_random($population, $max, $nr, 5);
    }


    public function getAllMethod()
    {
        return $this->methods;
    }

    public function setNr($nr)
    {
        $this->nrcrossing = $nr;
    }

    public function goThrough($populations, $method)
    {
        $size = 7;
        if ($method == "blob3random") {
            $size = 4;
        } elseif ($method == "random50") {
            $size = 2;
        }
        $chunks = array_chunk($populations, $size);
        $all = count($chunks);
        $res = [];
        for ($i = 0; $i < $all; $i++) {
            if (count($chunks[$i]) < $size) {
                continue;
            }
            $res[] = $this->$method($chunks[$i], $size);
        }
        return $res;
    }

    public function useavgojoindiffe($population, $max, $nr = 10)
    {
        $avgArea = $this->getAvgArea($population, $max, $nr);
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $res = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($one[$i][$j][$z] != $avgArea[$i][$j][$z]) {
                        $res[$i][$j][$z] = $one[$i][$j][$z];
                    } elseif ($two[$i][$j][$z] != $avgArea[$i][$j][$z]) {
                        $res[$i][$j][$z] = $two[$i][$j][$z];
                    } else {
                        $res[$i][$j][$z] = $avgArea[$i][$j][$z];
                    }
                }
            }
        }
        return $res;
    }

    public function useavgojoindiffeRandom($population, $max, $nr = 10)
    {
        $avgArea = $this->getAvgArea($population, $max, $nr);
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $res = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    $rand = rand(0, 100);

                    if ($one[$i][$j][$z] != $avgArea[$i][$j][$z] && $rand > 50) {
                        $res[$i][$j][$z] = $one[$i][$j][$z];
                    } elseif ($two[$i][$j][$z] != $avgArea[$i][$j][$z] && $rand > 50) {
                        $res[$i][$j][$z] = $two[$i][$j][$z];
                    } else {
                        $res[$i][$j][$z] = $avgArea[$i][$j][$z];
                    }
                }
            }
        }
        return $res;
    }


    private function getAvgArea($population, $max, $nr)
    {
        $res = [];
        $table = [];

        for ($m = 0; $m < $max; $m++) {
            for ($i = 0; $i < $nr; $i++) {
                for ($j = 0; $j < $nr; $j++) {
                    for ($z = 0; $z < $nr; $z++) {
                        if ($population[$m][$i][$j][$z] == 1) {
                            if (isset($res[$i][$j][$z])) {
                                $res[$i][$j][$z]++;
                            } else {
                                $res[$i][$j][$z] = 1;
                            }
                        } else {
                            if (!isset($res[$i][$j][$z])) {
                                $res[$i][$j][$z] = 0;
                            }
                        }
                    }
                }
            }
        }

        $half = floor($max / 2);

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($res[$i][$j][$z] >= $half) {
                        $table[$i][$j][$z] = 1;
                    } else {
                        $table[$i][$j][$z] = 0;
                    }
                }
            }
        }
        return $table;
    }

    private function rand4x4x4($population, $max, $nr = 10)
    {

        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $pom1 = rand(0, $nr - 4);
        $pom2 = rand(0, $nr - 4);
        $pom3 = rand(0, $nr - 4);
        $res = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if (($i >= $pom1 && $i <= $pom1 + 3)
                        && ($j >= $pom2 && $j <= $pom2 + 3)
                        && ($z >= $pom3 && $z <= $pom3 + 3)
                    ) {
                        $res[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $res[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }

        return $res;
    }

    private function rand5x5x5($population, $max, $nr = 10)
    {

        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $pom1 = rand(0, $nr - 5);
        $pom2 = rand(0, $nr - 5);
        $pom3 = rand(0, $nr - 5);
        $res = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if (($i >= $pom1 && $i <= $pom1 + 4)
                        && ($j >= $pom2 && $j <= $pom2 + 4)
                        && ($z >= $pom3 && $z <= $pom3 + 4)
                    ) {
                        $res[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $res[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }

        return $res;
    }

    private function rand6x6x6($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $pom1 = rand(0, $nr - 6);
        $pom2 = rand(0, $nr - 6);
        $pom3 = rand(0, $nr - 6);
        $res = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if (($i >= $pom1 && $i <= $pom1 + 5)
                        && ($j >= $pom2 && $j <= $pom2 + 5)
                        && ($z >= $pom3 && $z <= $pom3 + 5)
                    ) {
                        $res[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $res[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }

        return $res;
    }

    private function rand7x7x7($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $pom1 = rand(0, $nr - 7);
        $pom2 = rand(0, $nr - 7);
        $pom3 = rand(0, $nr - 7);
        $res = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if (($i >= $pom1 && $i <= $pom1 + 6)
                        && ($j >= $pom2 && $j <= $pom2 + 6)
                        && ($z >= $pom3 && $z <= $pom3 + 6)
                    ) {
                        $res[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $res[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }

        return $res;
    }

    private function rand8x8x8($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $pom1 = rand(0, $nr - 8);
        $pom2 = rand(0, $nr - 8);
        $pom3 = rand(0, $nr - 8);
        $res = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if (($i >= $pom1 && $i <= $pom1 + 7)
                        && ($j >= $pom2 && $j <= $pom2 + 7)
                        && ($z >= $pom3 && $z <= $pom3 + 7)
                    ) {
                        $res[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $res[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }

        return $res;
    }

    private function rand9x9x9($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $pom1 = rand(0, $nr - 9);
        $pom2 = rand(0, $nr - 9);
        $pom3 = rand(0, $nr - 9);
        $res = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if (($i >= $pom1 && $i <= $pom1 + 8)
                        && ($j >= $pom2 && $j <= $pom2 + 8)
                        && ($z >= $pom3 && $z <= $pom3 + 8)
                    ) {
                        $res[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $res[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }

        return $res;
    }


    private function random75($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if (rand(0, 100) <=  75) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function random90($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if (rand(0, 100) <=  90) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function rand4x4x4Multiple($population, $max, $nr = 10)
    {

        $randNumbers = $this->getRand($max);
        $m = rand(2, 7);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $res = $one;

        for ($x = 0; $x < $m; $x++) {

            $pom1 = rand(0, $nr - 4);
            $pom2 = rand(0, $nr - 4);
            $pom3 = rand(0, $nr - 4);

            for ($i = 0; $i < $nr; $i++) {
                for ($j = 0; $j < $nr; $j++) {
                    for ($z = 0; $z < $nr; $z++) {

                        if (($i >= $pom1 && $i <= $pom1 + 3)
                            && ($j >= $pom2 && $j <= $pom2 + 3)
                            && ($z >= $pom3 && $z <= $pom3 + 3)
                        ) {
                            $res[$i][$j][$z] = $two[$i][$j][$z];
                        }
                    }
                }
            }
        }

        return $res;
    }

    private function rand5x5x5Multiple($population, $max, $nr = 10)
    {

        $randNumbers = $this->getRand($max);
        $m = rand(2, 5);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $res = $one;

        for ($x = 0; $x < $m; $x++) {

            $pom1 = rand(0, $nr - 5);
            $pom2 = rand(0, $nr - 5);
            $pom3 = rand(0, $nr - 5);

            for ($i = 0; $i < $nr; $i++) {
                for ($j = 0; $j < $nr; $j++) {
                    for ($z = 0; $z < $nr; $z++) {

                        if (($i >= $pom1 && $i <= $pom1 + 4)
                            && ($j >= $pom2 && $j <= $pom2 + 4)
                            && ($z >= $pom3 && $z <= $pom3 + 4)
                        ) {
                            $res[$i][$j][$z] = $two[$i][$j][$z];
                        }
                    }
                }
            }
        }

        return $res;
    }

    private function rand6x6x6Multiple($population, $max, $nr = 10)
    {

        $randNumbers = $this->getRand($max);
        $m = rand(2, 3);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $res = $one;

        for ($x = 0; $x < $m; $x++) {

            $pom1 = rand(0, $nr - 6);
            $pom2 = rand(0, $nr - 6);
            $pom3 = rand(0, $nr - 6);

            for ($i = 0; $i < $nr; $i++) {
                for ($j = 0; $j < $nr; $j++) {
                    for ($z = 0; $z < $nr; $z++) {

                        if (($i >= $pom1 && $i <= $pom1 + 5)
                            && ($j >= $pom2 && $j <= $pom2 + 5)
                            && ($z >= $pom3 && $z <= $pom3 + 5)
                        ) {
                            $res[$i][$j][$z] = $two[$i][$j][$z];
                        }
                    }
                }
            }
        }

        return $res;
    }

    private function rand7x7x7Multiple($population, $max, $nr = 10)
    {

        $randNumbers = $this->getRand($max);
        $m = 2;
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $res = $one;

        for ($x = 0; $x < $m; $x++) {

            $pom1 = rand(0, $nr - 7);
            $pom2 = rand(0, $nr - 7);
            $pom3 = rand(0, $nr - 7);

            for ($i = 0; $i < $nr; $i++) {
                for ($j = 0; $j < $nr; $j++) {
                    for ($z = 0; $z < $nr; $z++) {

                        if (($i >= $pom1 && $i <= $pom1 + 6)
                            && ($j >= $pom2 && $j <= $pom2 + 6)
                            && ($z >= $pom3 && $z <= $pom3 + 6)
                        ) {
                            $res[$i][$j][$z] = $two[$i][$j][$z];
                        }
                    }
                }
            }
        }

        return $res;
    }

    private function rand8x8x8Multiple($population, $max, $nr = 10)
    {

        $randNumbers = $this->getRand($max);
        $m = 2;
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $res = $one;

        for ($x = 0; $x < $m; $x++) {

            $pom1 = rand(0, $nr - 8);
            $pom2 = rand(0, $nr - 8);
            $pom3 = rand(0, $nr - 8);

            for ($i = 0; $i < $nr; $i++) {
                for ($j = 0; $j < $nr; $j++) {
                    for ($z = 0; $z < $nr; $z++) {

                        if (($i >= $pom1 && $i <= $pom1 + 7)
                            && ($j >= $pom2 && $j <= $pom2 + 7)
                            && ($z >= $pom3 && $z <= $pom3 + 7)
                        ) {
                            $res[$i][$j][$z] = $two[$i][$j][$z];
                        }
                    }
                }
            }
        }

        return $res;
    }

    private function blockRandomXY($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $pom = [];
        $pom2 = [];
        for ($i = 0; $i < $nr; $i++) {
            $pom[] = rand(0, 3);
            $pom2[] = rand(0, $nr - 1);
        }
        $res = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    switch ($pom[$z]) {
                        case 0:
                            if ($i < $pom2[$z]) {
                                $res[$i][$j][$z] = $one[$i][$j][$z];
                            } else {
                                $res[$i][$j][$z] = $two[$i][$j][$z];
                            }
                            break;
                        case 1:
                            if ($i < $pom2[$z]) {
                                $res[$i][$j][$z] = $two[$i][$j][$z];
                            } else {
                                $res[$i][$j][$z] = $one[$i][$j][$z];
                            }
                            break;
                        case 2:
                            if ($j < $pom2[$z]) {
                                $res[$i][$j][$z] = $one[$i][$j][$z];
                            } else {
                                $res[$i][$j][$z] = $two[$i][$j][$z];
                            }
                            break;
                        case 3:
                            if ($j < $pom2[$z]) {
                                $res[$i][$j][$z] = $two[$i][$j][$z];
                            } else {
                                $res[$i][$j][$z] = $one[$i][$j][$z];
                            }
                            break;
                    }
                }
            }
        }

        return $res;
    }


    private function blockRandomXZ($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $pom = [];
        $pom2 = [];
        for ($i = 0; $i < $nr; $i++) {
            $pom[] = rand(0, 3);
            $pom2[] = rand(0, $nr - 1);
        }
        $res = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    switch ($pom[$j]) {
                        case 0:
                            if ($i < $pom2[$j]) {
                                $res[$i][$j][$z] = $one[$i][$j][$z];
                            } else {
                                $res[$i][$j][$z] = $two[$i][$j][$z];
                            }
                            break;
                        case 1:
                            if ($i < $pom2[$j]) {
                                $res[$i][$j][$z] = $two[$i][$j][$z];
                            } else {
                                $res[$i][$j][$z] = $one[$i][$j][$z];
                            }
                            break;
                        case 2:
                            if ($z < $pom2[$j]) {
                                $res[$i][$j][$z] = $one[$i][$j][$z];
                            } else {
                                $res[$i][$j][$z] = $two[$i][$j][$z];
                            }
                            break;
                        case 3:
                            if ($z < $pom2[$j]) {
                                $res[$i][$j][$z] = $two[$i][$j][$z];
                            } else {
                                $res[$i][$j][$z] = $one[$i][$j][$z];
                            }
                            break;
                    }
                }
            }
        }

        return $res;
    }

    private function blockRandomYZ($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];
        $pom = [];
        $pom2 = [];
        for ($i = 0; $i < $nr; $i++) {
            $pom[] = rand(0, 3);
            $pom2[] = rand(0, $nr - 1);
        }
        $res = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    switch ($pom[$i]) {
                        case 0:
                            if ($j < $pom2[$i]) {
                                $res[$i][$j][$z] = $one[$i][$j][$z];
                            } else {
                                $res[$i][$j][$z] = $two[$i][$j][$z];
                            }
                            break;
                        case 1:
                            if ($j < $pom2[$i]) {
                                $res[$i][$j][$z] = $two[$i][$j][$z];
                            } else {
                                $res[$i][$j][$z] = $one[$i][$j][$z];
                            }
                            break;
                        case 2:
                            if ($z < $pom2[$i]) {
                                $res[$i][$j][$z] = $one[$i][$j][$z];
                            } else {
                                $res[$i][$j][$z] = $two[$i][$j][$z];
                            }
                            break;
                        case 3:
                            if ($z < $pom2[$i]) {
                                $res[$i][$j][$z] = $two[$i][$j][$z];
                            } else {
                                $res[$i][$j][$z] = $one[$i][$j][$z];
                            }
                            break;
                    }
                }
            }
        }

        return $res;
    }

    private function updwownup_Z($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $zlevel = rand(1, $nr - 2);
        $zlevel2 = rand($zlevel, $nr - 2);

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($z >= $zlevel && $z <= $zlevel2) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function updwownup_Y($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $zlevel = rand(1, $nr - 2);
        $zlevel2 = rand($zlevel, $nr - 2);

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($j >= $zlevel && $j <= $zlevel2) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function updwownup_X($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $zlevel = rand(1, $nr - 2);
        $zlevel2 = rand($zlevel, $nr - 2);

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i >= $zlevel && $i <= $zlevel2) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function sandwich_Z($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $pom = [];
        for ($k = 0; $k < $nr; $k++) {
            $pom[] = rand(0, 1);
        }
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($pom[$z] == 1) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function sandwich_X($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $pom = [];
        for ($k = 0; $k < $nr; $k++) {
            $pom[] = rand(0, 1);
        }
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($pom[$i] == 1) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function sandwich_Y($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $pom = [];

        for ($k = 0; $k < $nr; $k++) {
            $pom[] = rand(0, 1);
        }
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($pom[$j] == 1) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function get5x5x1Multiple($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $multiple = rand(2, 20);

        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $table = $one;

        for ($m = 0; $m < $multiple; $m++) {
            $z = rand(0, $nr - 1);
            $x = rand(0, $nr - 5);
            $y = rand(0, $nr - 5);
            for ($i = 0; $i < 5; $i++) {
                for ($j = 0; $j < 5; $j++) {
                    $table[$x + $i][$y + $j][$z] = $two[$x + $i][$y + $j][$z];
                }
            }
        }

        return $table;
    }

    private function get4x4x1Multiple($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $multiple = rand(2, 20);

        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $table = $one;

        for ($m = 0; $m < $multiple; $m++) {
            $z = rand(0, $nr - 1);
            $x = rand(0, $nr - 4);
            $y = rand(0, $nr - 4);
            for ($i = 0; $i < 4; $i++) {
                for ($j = 0; $j < 4; $j++) {
                    $table[$x + $i][$y + $j][$z] = $two[$x + $i][$y + $j][$z];
                }
            }
        }

        return $table;
    }

    private function get3x3x1Multiple($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $multiple = rand(2, 20);

        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $table = $one;

        for ($m = 0; $m < $multiple; $m++) {
            $z = rand(0, $nr - 1);
            $x = rand(0, $nr - 3);
            $y = rand(0, $nr - 3);
            for ($i = 0; $i < 3; $i++) {
                for ($j = 0; $j < 3; $j++) {
                    $table[$x + $i][$y + $j][$z] = $two[$x + $i][$y + $j][$z];
                }
            }
        }

        return $table;
    }

    private function get3x3x1Multiple40($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $multiple = rand(2, 40);

        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $table = $one;

        for ($m = 0; $m < $multiple; $m++) {
            $z = rand(0, $nr - 1);
            $x = rand(0, $nr - 3);
            $y = rand(0, $nr - 3);
            for ($i = 0; $i < 3; $i++) {
                for ($j = 0; $j < 3; $j++) {
                    $table[$x + $i][$y + $j][$z] = $two[$x + $i][$y + $j][$z];
                }
            }
        }

        return $table;
    }


    private function blob3_wonerandom($population, $max, $nr = 10)
    {
        $blob = $this->blob3random($population, $max, $nr = 10);
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $pom = [];
        for ($i = 0; $i < $nr; $i++) {
            $pom2 = rand(0, 100);
            if ($pom2 < 20) {
                $pom[] = 1;
            } else {
                $pom[] = 0;
            }
        }

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($pom[$z] == 0) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $blob[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function blob3_wfiverandom($population, $max, $nr = 10)
    {
        $blob = $this->blob3random($population, $max, $nr = 10);
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $pom = [];
        for ($i = 0; $i < $nr; $i++) {
            $pom2 = rand(0, 100);
            if ($pom2 < 50) {
                $pom[] = 1;
            } else {
                $pom[] = 0;
            }
        }

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($pom[$z] == 0) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $blob[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function blob3_fromthelevel($population, $max, $nr = 10)
    {
        $blob = $this->blob3random($population, $max, $nr = 10);
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $pom = $this->gopom2table($nr);
        $pom2 = rand(1, $nr);

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($pom[$z] == 0) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $blob[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }


    private function blob6_wonerandom($population, $max, $nr = 10)
    {
        $blob = $this->blob6($population, $max, $nr = 10);
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $pom = [];
        for ($i = 0; $i < $nr; $i++) {
            $pom2 = rand(0, 100);
            if ($pom2 < 20) {
                $pom[] = 1;
            } else {
                $pom[] = 0;
            }
        }

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($pom[$z] == 0) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $blob[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function blob6_wfiverandom($population, $max, $nr = 10)
    {
        $blob = $this->blob6($population, $max, $nr = 10);
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $pom = [];
        for ($i = 0; $i < $nr; $i++) {
            $pom2 = rand(0, 100);
            if ($pom2 < 50) {
                $pom[] = 1;
            } else {
                $pom[] = 0;
            }
        }

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($pom[$z] == 0) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $blob[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function blob6_fromthelevel($population, $max, $nr = 10)
    {
        $blob = $this->blob6($population, $max, $nr = 10);
        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $pom = $this->gopom2table($nr);
        $pom2 = rand(1, $nr);


        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($pom[$z] == 0) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $blob[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function gopom2table($nr)
    {
        $res = [];
        $pom2 = rand(1, $nr);
        for ($i = 0; $i < $nr; $i++) {
            if ($i < $pom2) {
                $res[] = 1;
            } else {
                $res[] = 0;
            }
        }
        return $res;
    }

    public function createPopulationFromBloBFromLevel($population, $all, $nr = 10, $type = 1)
    {
        $max = count($population);
        $blob = [];
        if ($type == 1) {
            $blob = $this->blob3random($population, $max, $nr = 10);
        } elseif ($type == 2) {
            $blob = $this->blob6($population, $max, $nr = 10);
        }
        $table = [];
        $res = [];
        $used = [];
        $possible = 10 * $all;
        for ($n = 0; $n < $all; $n++) {
            $one = $population[rand(0, $max - 1)];
            $pom = $this->gopom2table($nr);
            $table = [];
            for ($i = 0; $i < $nr; $i++) {
                for ($j = 0; $j < $nr; $j++) {
                    for ($z = 0; $z < $nr; $z++) {
                        if ($pom[$z] == 0) {
                            $table[$i][$j][$z] = $one[$i][$j][$z];
                        } else {
                            $table[$i][$j][$z] = $blob[$i][$j][$z];
                        }
                    }
                }
            }
            $shortTable = sha1(json_encode($table));
            if (in_array($shortTable, $used)) {
                if ($possible > 0) {
                    $possible--;
                    $n--;
                }
            } else {
                $res[] = $table;
                $used[] = $shortTable;
            }
        }
        return $res;
    }


    public function upDownLayerPowerMatrix100($population, $max, $nr = 10)
    {

        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $size = 100;

        $orders = $this->getOrders($nr);
        $parts = $this->getPartsOrders($orders, $size);

        $lvl = [];
        $lvlmax = 1000 / $size;
        $pom = rand(0, $lvlmax - 2);
        for ($i = 0; $i < $lvlmax; $i++) {
            if ($pom < $i) {
                $lvl[] = 0;
            } else {
                $lvl[] = 1;
            }
        }

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    $layer = $parts[$i . "-" . $j . "-" . $z];

                    if ($lvl[$layer] == 0) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    public function upDownLayerPowerMatrix125($population, $max, $nr = 10)
    {

        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $size = 125;

        $orders = $this->getOrders($nr);
        $parts = $this->getPartsOrders($orders, $size);

        $lvl = [];
        $lvlmax = 1000 / $size;
        $pom = rand(0, $lvlmax - 2);
        for ($i = 0; $i < $lvlmax; $i++) {
            if ($pom < $i) {
                $lvl[] = 0;
            } else {
                $lvl[] = 1;
            }
        }

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    $layer = $parts[$i . "-" . $j . "-" . $z];

                    if ($lvl[$layer] == 0) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    public function upDownLayerPowerMatrix50($population, $max, $nr = 10)
    {

        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $size = 50;

        $orders = $this->getOrders($nr);
        $parts = $this->getPartsOrders($orders, $size);

        $lvl = [];
        $lvlmax = 1000 / $size;
        $pom = rand(0, $lvlmax - 2);
        for ($i = 0; $i < $lvlmax; $i++) {
            if ($pom < $i) {
                $lvl[] = 0;
            } else {
                $lvl[] = 1;
            }
        }

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    $layer = $parts[$i . "-" . $j . "-" . $z];

                    if ($lvl[$layer] == 0) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    public function upDownLayerPowerMatrix25($population, $max, $nr = 10)
    {

        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $size = 25;

        $orders = $this->getOrders($nr);
        $parts = $this->getPartsOrders($orders, $size);

        $lvl = [];
        $lvlmax = 1000 / $size;
        $pom = rand(0, $lvlmax - 2);
        for ($i = 0; $i < $lvlmax; $i++) {
            if ($pom < $i) {
                $lvl[] = 0;
            } else {
                $lvl[] = 1;
            }
        }

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    $layer = $parts[$i . "-" . $j . "-" . $z];

                    if ($lvl[$layer] == 0) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }


    public function tassingLayerPowerMatrix100($population, $max, $nr = 10)
    {

        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $size = 100;

        $orders = $this->getOrders($nr);
        $parts = $this->getPartsOrders($orders, $size);

        $lvl = [];
        $lvlmax = 1000 / $size;
        for ($i = 0; $i < $lvlmax; $i++) {
            $lvl[] = rand(0, 1);
        }

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    $layer = $parts[$i . "-" . $j . "-" . $z];

                    if ($lvl[$layer] == 0) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    public function tassingLayerPowerMatrix125($population, $max, $nr = 10)
    {

        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $size = 125;

        $orders = $this->getOrders($nr);
        $parts = $this->getPartsOrders($orders, $size);

        $lvl = [];
        $lvlmax = 1000 / $size;
        for ($i = 0; $i < $lvlmax; $i++) {
            $lvl[] = rand(0, 1);
        }

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    $layer = $parts[$i . "-" . $j . "-" . $z];

                    if ($lvl[$layer] == 0) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    public function tassingLayerPowerMatrix50($population, $max, $nr = 10)
    {

        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $size = 50;

        $orders = $this->getOrders($nr);
        $parts = $this->getPartsOrders($orders, $size);

        $lvl = [];
        $lvlmax = 1000 / $size;

        for ($i = 0; $i < $lvlmax; $i++) {
            $lvl[] = rand(0, 1);
        }

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    $layer = $parts[$i . "-" . $j . "-" . $z];

                    if ($lvl[$layer] == 0) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    public function tassingLayerPowerMatrix25($population, $max, $nr = 10)
    {

        $randNumbers = $this->getRand($max);
        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $size = 25;

        $orders = $this->getOrders($nr);
        $parts = $this->getPartsOrders($orders, $size);

        $lvl = [];
        $lvlmax = 1000 / $size;

        for ($i = 0; $i < $lvlmax; $i++) {
            $lvl[] = rand(0, 1);
        }

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    $layer = $parts[$i . "-" . $j . "-" . $z];

                    if ($lvl[$layer] == 0) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }


    public function getPartsOrders($orders, $numero)
    {

        $slice = 0;
        $val = 0;
        $res = [];
        foreach ($orders as $key => $power) {
            $slice++;
            if ($slice > $numero) {
                $val++;
                $slice = 0;
            }
            $res[$key] = $val;
        }
        return $res;
    }

    public function getOrders($size = 10)
    {
        $orders = [];
        if ($this->matrixpowerorder) {
            $orders = $this->matrixpowerorder;
        } else {
            $data = PowerMatrix::where("size", $size)->first();
            $orders = json_decode($data->orderdata, 1);
            $this->matrixpowerorder = $orders;
        }

        $keys = array_keys($orders);
        shuffle($keys);

        $shuffled_orders = [];
        foreach ($keys as $key) {
            $shuffled_orders[$key] = $orders[$key];
        }
        $orders = $shuffled_orders;
        arsort($orders);
        return $orders;
    }


    private function mozaics($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);
        $multiple = rand(2, 20);

        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $table = $one;

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = $i + $j + $z;
                    if ($sum % 2 == 1) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function crystalsize3($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);

        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $table = $one;

        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $pom3 = rand(0, $nr - 1);

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = abs($i - $pom1) + abs($j - $pom2) + abs($z - $pom3);
                    if ($sum <= 3) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function crystalsize4($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);

        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $table = $one;

        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $pom3 = rand(0, $nr - 1);

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = abs($i - $pom1) + abs($j - $pom2) + abs($z - $pom3);
                    if ($sum <= 4) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function crystalsize5($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);

        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $table = $one;

        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $pom3 = rand(0, $nr - 1);

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = abs($i - $pom1) + abs($j - $pom2) + abs($z - $pom3);
                    if ($sum <= 5) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function crystalsize6($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);

        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $table = $one;

        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $pom3 = rand(0, $nr - 1);

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = abs($i - $pom1) + abs($j - $pom2) + abs($z - $pom3);
                    if ($sum <= 6) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function rombsquere5_inZ($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);

        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $table = $one;

        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = abs($i - $pom1) + abs($j - $pom2);
                    if ($sum <= 5) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function rombsquere4_inZ($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);

        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $table = $one;

        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = abs($i - $pom1) + abs($j - $pom2);
                    if ($sum <= 4) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function rombsquere3_inZ($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);

        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $table = $one;

        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = abs($i - $pom1) + abs($j - $pom2);
                    if ($sum <= 3) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function rombsquere2_inZ($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);

        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $table = $one;

        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = abs($i - $pom1) + abs($j - $pom2);
                    if ($sum <= 2) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function rombsquere1_inZ($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);

        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $table = $one;

        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = abs($i - $pom1) + abs($j - $pom2);
                    if ($sum <= 2) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function rombsquere6_inZ($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);

        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $table = $one;

        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = abs($i - $pom1) + abs($j - $pom2);
                    if ($sum <= 6) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function rombsquere7_inZ($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);

        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $table = $one;

        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = abs($i - $pom1) + abs($j - $pom2);
                    if ($sum <= 7) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function rombsquere3_inX($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);

        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $table = $one;

        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = abs($z - $pom1) + abs($j - $pom2);
                    if ($sum <= 3) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }

    private function rombsquere3_inY($population, $max, $nr = 10)
    {
        $randNumbers = $this->getRand($max);

        $one = $population[$randNumbers[0]];
        $two = $population[$randNumbers[1]];

        $table = $one;

        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);

        $table = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = abs($i - $pom1) + abs($z - $pom2);
                    if ($sum <= 3) {
                        $table[$i][$j][$z] = $one[$i][$j][$z];
                    } else {
                        $table[$i][$j][$z] = $two[$i][$j][$z];
                    }
                }
            }
        }
        return $table;
    }


    public function changeMethodList($methods)
    {
        $this->methods = $methods;
    }

    public function random50multiple($population, $max, $nr = 10, $loop = 6)
    {

        $nextpop  = [];
        $newpopulation = $population;
        for ($j = 0; $j < $loop; $j++) {
            $max = count($newpopulation);

            $nextpop  = [];
            for ($i = 0; $i < 40; $i++) {

                $nextpop[] = $this->random50($newpopulation, $max, $nr);
            }
            $newpopulation = $nextpop;
        }

        return $this->random50($newpopulation, $max, $nr);
    }
}
