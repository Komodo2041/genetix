<?php

namespace App\Services;

class PopulationName
{

    private $stillPatternOrClone = [4, 5, 6, 7, 8, 9];

    public $randomDoingTrybe = 0;

    public function  __construct($r)
    {
        $this->randomDoingTrybe = $r;
    }

    public $populationName = [
        0 => "Generation 0",
        -1 => "10 from level down",
        1 => "5 down, 5 more down",
        2 => "2 differene",
        3 => "2 more different",
        4 => "Stable Pattern",
        5 => "Stable Pattern bext results",
        6 => "Change Still Template",
        7 => "Clone",
        8 => "Multiple Clone",
        9 => "Pattern XYZ",
        10 => "3 mutation First",
        11 => "2 * bigLayerMutation",
        12 => "useBigMutator - 1",
        13 => "useBigMutator - 2",
        14 => "bigLayerMutationCircle - 3",
        15 => "Join River",
        16 => "Join more River",
        17 => "Use Waga Small",
        18 => "Use Waga Big",
        19 => "Use Waga Mini",
        20 => "Use Waga Very Mini",
        21 => "Calculating mutation matrix", // X
        22 => "Paratrooper", // X
        23 => "Use Only Mutations",
        24 => "Use non used calculations",
        25 => "Calculating crossing matrix", // X
        26 => "Use blob 6 Random to first generation",
        27 => "Use blob 3 Random to first generation",
        28 => "Elevent Different",
        29 => "Use Random50 to first generation",
        30 => "Half Results", // X
        31 => "Set one Layer X (1) 100%",
        32 => "Set one Layer Y (1) 100%",
        33 => "Set one Layer Z (1) 100%",
        34 => "Create population - use power empty",
        35 => "Generate population From 50% power ",
        36 => "Generate population From 75% power ",
        37 => "Generate population From 90% power ",
        38 => "Power Up Some Poitns ",
        39 => "Power Down Some Points ",
        40 => "Create population - use power Full",
        41 => "Generate population From 95% power ",
        42 => "Set one Layer X (0) 100%",
        43 => "Set one Layer Y (0) 100%",
        44 => "Set one Layer Z (0) 100%",
        45 => "Set one Layer X (1) 50%",
        46 => "Set one Layer Y (1) 50%",
        47 => "Set one Layer Z (1) 50%",
        48 => "Set one Layer X (0) 50%",
        49 => "Set one Layer Y (0) 50%",
        50 => "Set one Layer Z (0) 50%",
        51 => "Zero the lower 3 layers",
        52 => "Zero the lower layers",
        53 => "Zero the big lower layers",
        54 => "Zero the lower 3 layers (50%)",
        55 => "Zero the lower layers (50%)",
        56 => "Zero the big lower layers (50%) ",
        57 => "Up 3 layers",
        58 => "Small up layers",
        59 => "Big Up layers",
        60 => "Zero 4x4x4",
        61 => "Zero 5x5x5",
        62 => "Zero 6x6x6",
        63 => "Calculating powerMatrix", // X
        64 => "Use 10 Calculating powerMatrix Together",
        65 => "useBigMutator - 1 - Part Layer Z - (70%)",
        66 => "useBigMutator - 2 - Part Layer Z - (70%)",
        67 => "useBigMutator - 1 - Part Layer Z - (40%)",
        68 => "useBigMutator - 2 - Part Layer Z - (40%)",
        69 => "useBigMutator - 1 - Part Layer Z - (20%)",
        70 => "useBigMutator - 2 - Part Layer Z - (20%)",
        71 => "useBigMutator - 1 - Part Layer Z - (10%)",
        72 => "useBigMutator - 2 - Part Layer Z - (10%)",
        73 => "Blob3 From the level",
        74 => "Blob6 From the level",
        75 => "Use result2 ",
        76 => "Calculating accuratecalc - use AVG ",
        77 => "Calculating accuratecalc - use MIN",
        78 => "Calculating accuratecalc - use MAX",
        79 => "Calculating accuratecalc - use (MAX - MIN)",
        80 => "Calculating accuratecalc - use VARIATION",
        81 => "Inversion",
        82 => "Get Only Inversions",
        83 => "Use PowerBigMutator - 1",
        84 => "Use PowerBigMutator - 1 - (100%) ",
        85 => "Use PowerBigMutator - 1 - (70%)",
        86 => "Use PowerBigMutator - 1 - (40%)",
        87 => "Use PowerBigMutator - 1 - (20%)",
        88 => "Use PowerBigMutator - 1 - (10%)",
        89 => "Use PowerBigMutator - 2 - (100%)",
        90 => "Use PowerBigMutator - 2 - (70%)",
        91 => "Use PowerBigMutator - 2 - (40%)",
        92 => "Use PowerBigMutator - 2 - (20%)",
        93 => "Use PowerBigMutator - 2 - (10%)",
        94 => "Use PowerBigMutator - 1 - (5%)",
        95 => "Use PowerBigMutator - 2 - (5%)",
        96 => "Calculating PowerBigMutation", // X
        97 => "Calculating Big Mutation Layer (Z)", // X 
        98 => "Calculating Big Mutation Layer (X)", // X 
        99 => "Calculating Big Mutation Layer (Y)", // X 
        100 => "Using Pattern From Gen0 Pattern ",
        101 => "Usign the best patern from gen 0",
        101 => "Usign the best patern from gen 0 (one from 10 result)",
        102 => "Calculating Gen0", // X
        103 => "Use Not The Same Calculations",
        104 => "Use Not The Same Calculations (start - 50 random)",
        105 => "Blob 1 lvl", // X
        106 => "Blob Head", // X
        107 => "Create Pattern River", // X
        108 => "Tama calc", // X
        109 => "Kosz Gen0 Calc", // X
        110 => "Use Best Pattern Gen0 - 3D",
        111 => "Waga - change Only Top"
    ];

    public $noSelectingPopulation = [-1, 21, 22, 25, 30, 63, 96, 97, 98, 99, 102, 105, 106, 107, 108, 109];

    public $selectUsingPower = [31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62];
    public $selectUsingPowerBottomLayerZero = [51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62];

    public $normalSelecting = [0, 1, 2, 3, 10, 23, 24, 28];

    public $wagaSelecting = [17, 18, 19, 20, 111];

    public $biglayerSelecting = [11, 12, 13, 14, 65, 66, 67, 68, 69, 70, 71, 72]; // Z
    public $biglayerSelectingShort = [12, 13, 14, 65, 66, 67, 68, 69, 70, 71, 72]; // Z

    public $avgdetailcalcSelecting = [76, 77, 78, 79, 80];

    public $powerSelectingShort = [83, 84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 94, 95];

    public $diamondCrossing = [130, 131, 132, 133, 134, 135, 136];

    public function getRandomDoing()
    {
        $randomDoing = -1;

        $randomDoingTrybe = $this->randomDoingTrybe;
        // 50 % chance to normal
        if ($randomDoingTrybe == 0) {
            $r = rand(0, 1);
            if ($r == 1) {
                $randomDoingTrybe = 2;
            }
        }

        while (in_array($randomDoing, $this->noSelectingPopulation)) {
            $randomDoing = rand(0, max(array_keys($this->populationName)));
            if ($randomDoingTrybe  == 1) {
                $randomDoing = rand(min($this->selectUsingPower), max($this->selectUsingPower));
            } elseif ($randomDoingTrybe  == 2) { // NORMAL
                if (!in_array($randomDoing, $this->normalSelecting)) {
                    $randomDoing = -1;
                }
            } elseif ($randomDoingTrybe  == 3) {
                $randomDoing = rand(min($this->selectUsingPowerBottomLayerZero), max($this->selectUsingPowerBottomLayerZero));
            } elseif ($randomDoingTrybe == 4) { // NO WAGA
                if (in_array($randomDoing, $this->wagaSelecting)) {
                    $randomDoing = -1;
                }
            } elseif ($randomDoingTrybe == 5) {
                if (!in_array($randomDoing, $this->biglayerSelecting)) {
                    $randomDoing = -1;
                }
            } elseif ($randomDoingTrybe == 6) { // AVG
                $randomDoing = rand(min($this->avgdetailcalcSelecting), max($this->avgdetailcalcSelecting));
            } elseif ($randomDoingTrybe == 7) { // POWER SELECT
                $randomDoing = rand(min($this->powerSelectingShort), max($this->powerSelectingShort));
            }
        }
        return $randomDoing;
    }

    public function checkRandomDoing($x)
    {
        if ($x >= 0 && $x <= max(array_keys($this->populationName)) && !in_array($x, $this->noSelectingPopulation)) {
            return true;
        } else {
            return false;
        }
    }
}
