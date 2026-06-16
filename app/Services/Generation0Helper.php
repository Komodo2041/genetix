<?php

namespace App\Services;


class Generation0Helper
{

    private $dim = 0;

    public function getPattern($trybe, $size)
    {

        $res = [];
        for ($i = 0; $i < $size; $i++) {
            switch ($trybe) {
                case 1:
                    $res[$i] = rand(0, 1) * 50;
                    break;
                case 2:
                    $res[$i] = rand(0, 10) * 10;
                    break;
                case 3:
                    $res[$i] = rand(0, 100);
                    break;
            }
        }
        return $res;
    }

    public function createBoard($pattern, $size)
    {
        $res = [];
        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size; $j++) {
                for ($z = 0; $z < $size; $z++) {
                    $res[$i][$j][$z] = $this->fill($pattern[$this->getDim($i, $j, $z)]);
                }
            }
        }
        return $res;
    }

    private function fill($percent)
    {
        $rand = rand(0, 100);
        if ($rand <= $percent) {
            return 1;
        } else {
            return 0;
        }
    }

    public function calcPattern($data, $size = 10)
    {
        $res = [];
        for ($i = 0; $i < 10; $i++) {
            $res[$i] = 0;
        }
        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size; $j++) {
                for ($z = 0; $z < $size; $z++) {
                    $res[$this->getDim($i, $j, $z)] += $data[$i][$j][$z];
                }
            }
        }
        return $res;
    }

    public function setDimension($tryb)
    {
        $this->dim = $tryb;
    }

    private function getDim($i, $j, $z)
    {
        switch ($this->dim) {
            case 0:
                return $z;
                break;
            case 1:
                return $i;
                break;
            case 2:
                return $j;
                break;
        }
    }

    public function cleanValue($val)
    {
        if ($val > 100) {
            $val = 100;
        }
        if ($val < 0) {
            $val = 0;
        }
        return $val;
    }

    public function getTwoKeysFromPattern($pattern, $val)
    {
        $key = rand(0, count($pattern) - 1);
        while ($pattern[$key] < $val) {
            $key = rand(0, count($pattern) - 1);
        }
        $key2 = rand(0, count($pattern) - 1);
        while ($pattern[$key2] + $val > 100 && $key2 != $key) {
            $key2 = rand(0, count($pattern) - 1);
        }
        return [$key, $key2];
    }

    public function getTwoKeysFromPatternNeibours($pattern, $val)
    {
        $key = rand(0, count($pattern) - 1);
        while ($pattern[$key] < $val) {
            $key = rand(0, count($pattern) - 1);
        }
        $key2 = $this->getNeibours($key, 10);

        return [$key, $key2];
    }

    private function getNeibours($key, $size)
    {
        $key2 = $key;
        if ($key == 0) {
            return 1;
        }
        if ($key == $size - 1) {
            return $size - 2;
        }
        $rand = rand(0, 1);
        if ($rand == 0) {
            $key2--;
        } else {
            $key2++;
        }
        return $key2;
    }

    public function calcAllData($data)
    {
        $sum = 0;
        for ($i = 0; $i < 10; $i++) {
            $sum += $data[$i];
        }
        return $sum;
    }

    public function minusData($data, $half, $size = 10)
    {
        while ($half > 0) {
            $r = rand(0, $size - 1);
            if ($data[$r] > 0) {
                $data[$r]--;
                $half--;
            }
        }
        return $data;
    }

    public function addData($data, $half, $size = 10)
    {
        while ($half > 0) {
            $r = rand(0, $size - 1);
            if ($data[$r] < 100) {
                $data[$r]++;
                $half--;
            }
        }
        return $data;
    }

    public function createBoard3Dim($patternZ, $patternX, $patternY, $all, $size)
    {
        $res = [];
        $max = $size * $size * $size;
        $max2 = $size * $size;
        $dol = pow($all / $max, 2);

        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size; $j++) {
                for ($z = 0; $z < $size; $z++) {
                    $procent = ($patternZ[$z] / $max2) * ($patternX[$i] / $max2) * ($patternY[$j] / $max2);
                    $procent = abs($procent / $dol);
                    $procent *= 100;

                    $res[$i][$j][$z] = $this->fill($procent);
                }
            }
        }
        return $res;
    }
}
