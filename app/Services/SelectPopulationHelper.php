<?php

namespace App\Services;

use App\Services\MatrixHelper;

class SelectPopulationHelper
{

    public $helperMatrix = null;

    public function __construct()
    {
        $this->helperMatrix = new MatrixHelper();
    }

    public function getPatternFromPowerUsed($randomDoing, $dataBest, $power, $gtx)
    {

        if ($randomDoing == 31) {
            $pattern = $this->helperMatrix->SetLayer($dataBest, 1, 10);
        } elseif ($randomDoing == 32) {
            $pattern = $this->helperMatrix->SetLayer($dataBest, 2, 10);
        } elseif ($randomDoing == 33) {
            $pattern = $this->helperMatrix->SetLayer($dataBest, 3, 10);
        } elseif ($randomDoing == 34) {
            $pattern = $this->helperMatrix->getZeroTable(10);
        } elseif ($randomDoing == 35) {
            $newpower = $power * 0.5;
            $pattern = $gtx->usepower([$dataBest], $newpower, 2);
            $pattern = $pattern[0];
        } elseif ($randomDoing == 36) {
            $newpower = $power * 0.75;
            $pattern = $gtx->usepower([$dataBest], $newpower, 2);
            $pattern = $pattern[0];
        } elseif ($randomDoing == 37) {
            $newpower = $power * 0.9;
            $pattern = $gtx->usepower([$dataBest], $newpower, 2);
            $pattern = $pattern[0];
        } elseif ($randomDoing == 38) {
            $pattern = $this->helperMatrix->upSomePoint($dataBest);
        } elseif ($randomDoing == 39) {
            $pattern = $this->helperMatrix->downSomePoint($dataBest);
        } elseif ($randomDoing == 40) {
            $pattern = $this->helperMatrix->getZeroTable(10, 1);
        } elseif ($randomDoing == 41) {
            $newpower = $power * 0.95;
            $pattern = $gtx->usepower([$dataBest], $newpower, 2);
            $pattern = $pattern[0];
        } elseif ($randomDoing == 42) {
            $pattern = $this->helperMatrix->SetLayer($dataBest, 1, 10, 0);
        } elseif ($randomDoing == 43) {
            $pattern = $this->helperMatrix->SetLayer($dataBest, 1, 10, 0);
        } elseif ($randomDoing == 44) {
            $pattern = $this->helperMatrix->SetLayer($dataBest, 1, 10, 0);
        } elseif ($randomDoing == 45) {
            $pattern = $this->helperMatrix->SetLayer($dataBest, 1, 10, 1, 50);
        } elseif ($randomDoing == 46) {
            $pattern = $this->helperMatrix->SetLayer($dataBest, 1, 10, 1, 50);
        } elseif ($randomDoing == 47) {
            $pattern = $this->helperMatrix->SetLayer($dataBest, 1, 10, 1, 50);
        } elseif ($randomDoing == 48) {
            $pattern = $this->helperMatrix->SetLayer($dataBest, 1, 10, 0, 50);
        } elseif ($randomDoing == 49) {
            $pattern = $this->helperMatrix->SetLayer($dataBest, 1, 10, 0, 50);
        } elseif ($randomDoing == 50) {
            $pattern = $this->helperMatrix->SetLayer($dataBest, 1, 10, 0, 50);
        } elseif ($randomDoing == 51) {
            $pattern = $this->helperMatrix->ZeroLayer($dataBest, 1, 10);
        } elseif ($randomDoing == 52) {
            $pattern = $this->helperMatrix->ZeroLayer($dataBest, 2, 10);
        } elseif ($randomDoing == 53) {
            $pattern = $this->helperMatrix->ZeroLayer($dataBest, 3, 10);
        } elseif ($randomDoing == 54) {
            $pattern = $this->helperMatrix->ZeroLayer($dataBest, 1, 10, 50);
        } elseif ($randomDoing == 55) {
            $pattern = $this->helperMatrix->ZeroLayer($dataBest, 2, 10, 50);
        } elseif ($randomDoing == 56) {
            $pattern = $this->helperMatrix->ZeroLayer($dataBest, 3, 10, 50);
        } elseif ($randomDoing == 57) {
            $pattern = $this->helperMatrix->UpLayers($dataBest, 1, 10);
        } elseif ($randomDoing == 58) {
            $pattern = $this->helperMatrix->UpLayers($dataBest, 2, 10);
        } elseif ($randomDoing == 59) {
            $pattern = $this->helperMatrix->UpLayers($dataBest, 3, 10);
        } elseif ($randomDoing == 60) {
            $pattern = $this->helperMatrix->zeroBlock($dataBest, 10, 4);
        } elseif ($randomDoing == 61) {
            $pattern = $this->helperMatrix->zeroBlock($dataBest, 10, 5);
        } elseif ($randomDoing == 62) {
            $pattern = $this->helperMatrix->zeroBlock($dataBest, 10, 6);
        }

        return $pattern;
    }

    public function getOrderForAvgData($randomDoing)
    {

        $order = "avg";
        $desc = "DESC";
        switch ($randomDoing) {
            case 76:
                $order = "avg";
                break;
            case 77:
                $order = "min";
                break;
            case 78:
                $order = "max";
                break;
            case 79:
                $order = "avgdiff";
                $desc = "ASC";
                break;
            case 80:
                $order = "variation";
                $desc = "ASC";
                break;
        }
        return [$order, $desc];
    }

    public function setPowerMutation($randomDoing, &$powermutation, &$usePowerMutator)
    {
        if ($randomDoing == 84 || $randomDoing == 85 || $randomDoing == 86 || $randomDoing == 87 || $randomDoing == 88) {
            $usePowerMutator = 1;
        } elseif ($randomDoing == 89 || $randomDoing == 90 || $randomDoing == 91 || $randomDoing == 92 || $randomDoing == 93) {
            $usePowerMutator = 2;
        }

        if ($randomDoing == 85 || $randomDoing == 90) {
            $powermutation->setPercent(70);
        } elseif ($randomDoing == 86 || $randomDoing == 91) {
            $powermutation->setPercent(40);
        } elseif ($randomDoing == 87 || $randomDoing == 92) {
            $powermutation->setPercent(20);
        } elseif ($randomDoing == 88 || $randomDoing == 93) {
            $powermutation->setPercent(10);
        } elseif ($randomDoing == 94 || $randomDoing == 95) {
            $powermutation->setPercent(5);
        }
    }
}
