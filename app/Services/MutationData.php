<?php

namespace App\Services;

use App\Models\PowerMatrix;

class MutationData
{

    public $nrmutation = 270;
    private $matrixpowerorder = [];


    private $mutationList = [
        "shufflecolumnXZ",
        "shufflecolumnYZ",
        "exchangecolumnXY",
        "exchangecolumnXZ",
        "shufflecolumnYZgo6",
        "shufflecolumnXZgo6",
        "mirrorXY",
        "mirrorXZ",
        "mirrorYZ",
        "mirrorXY_d",
        "mirrorXZ_d",
        "mirrorYZ_d",
        "clockwiseXYleft",
        "clockwiseXZleft",
        "clockwiseYZleft",
        "clockwiseXYright",
        "clockwiseXZright",
        "clockwiseYZright",
        "shufflecolumnYZgo4",
        "shufflecolumnXYgo4",
        "shufflecolumnXZgo4",
        "changecolumnXYgo4",
        "changecolumnXZgo4",
        "changecolumnYZgo4",
        "shufflecolumnXYgo6",
        "changecolumnXYgo6",
        "changecolumnXZgo6",
        "changecolumnYZgo6",
        "changecolumnXZ",
        "changecolumnYZ",
        "goupanddown1x1",
        "goup1x1",
        "exchangefarcolumnXZ",
        "exchangecolumnYZ",
        "exchangefarcolumnXY",
        "neighbourchange",
        "shuffleRand4x4",
        "changeRand4x4",
        "shuffleRand16x16",
        "exchangefarcolumnYZ",
        "shuffleRand9x9",
        "godown1x1",
        "shufflecolumnXY",
        "changecolumnXY",
        "neighbourchange10",
        "changeRand16x16",
        "neighbourchange5",
        "changeRand9x9",
        "changeOneLayerZ",
        "changeOneLayerX",
        "changeOneLayerY",
        "changeOneLayerZ2",
        "changeOneLayerX2",
        "changeOneLayerY2",
        "jointwopointsZ",
        "dividepointsZ",
        "jointwopointsZ5",
        "dividepointsZ5",
        "mixingZLayers",
        "mixingVerticalLayersZ",
        "mixingVerticalLayersX",
        "mixingVerticalLayersY",
        "mixingYLayers",
        "mixingXLayers",
        "shuffleRand6x6x6",
        "shuffleRand5x5x5",
        "shufflecolumnYZ_3x3",
        "shufflecolumnXZ_3x3",
        "shufflecolumnXY_3x3",
        "shuffleRand7x7x7",
        "exchangefarcolumnXYMultiple",
        "shuffleRand6x6x2_X",
        "shuffleRand6x6x2_Y",
        "shuffleRand6x6x2_Z",
        "shuffleRand6x6x3_X",
        "shuffleRand6x6x3_Y",
        "shuffleRand6x6x3_Z",
        "shuffleRandBorder4x4x4",
        "shuffleRandBorder5x5x5",
        "shuffleRandBorder6x6x6",
        "shuffleRandBorder8x8x8",
        "shuffleRandBorder7x7x7",
        "shuffleRand6Lines",
        "shuffleRand6x6x6Multiple",
        "shuffleRand4x4x4Multiple",
        "shuffleRand5x5x5Multiple",
        "shuffleRand4x4x4",
        "shuffleRand9x9Multiple",
        "shufflecolumnXZgo6Multiple",
        "shufflecolumnYZgo6Multiple",
        "mixingZLayers3Times",
        "goupInOneLayer",
        "godownInOneLayer",
        "shuffleMaxBorder_LayerZ_width_4",
        "shuffleMaxBorder_LayerZ_width_3",
        "shuffleMaxBorder_LayerZ_width_2",
        "shuffleMaxBorder_LayerZ_width_1",
        "shuffledoublecrossinOneLayerZ",
        "shufflesquereBorderOneLayerZ",
        "shuffleMaxBorder_LayerZ_width_2_03",
        "shuffleMaxBorder_LayerZ_width_2_13",
        "shuffleMaxBorder_LayerZ_width_2_23",
        "shuffleMaxBorder_LayerZ_width_2_12",
        "shuffleMaxBorder_LayerZ_width_3_123",
        "shufflesquereBorderOneLayerZ_width2",
        "shufflesquereBorderOneLayerZMultiple",
        "shuffleMaxBorder_LayerZ_width_2Multiple",
        "shuffleonMatrixPower10",
        "shuffleonMatrixPower20",
        "shuffleonMatrixPower50",
        "shuffleonMatrixPower100",
        "shuffleonMatrixPower30",
        "shuffleonMatrixPower20Multi",
        "shuffleonMatrixPower10Multi",
        "shuffleonMatrixPower200",
        "shufflerytal2",
        "shufflerytal3",
        "shufflerytal4",
        "shufflerytal5",
        "rombono2_inZ",
        "rombono3_inZ",
        "rombono4_inZ",
        "shuffleonMatrixPower20_left",
        "shuffleonMatrixPower20_right",
        "shuffleonMatrixPower20_middle",
        "shuffleonMatrixPower20_toborder",
        "shuffleonMatrixPower50_left",
        "shuffleonMatrixPower50_right",
        "shuffleonMatrixPower50_middle",
        "shuffleonMatrixPower50_toborder",
        "shuffleonMatrixPower100_left",
        "shuffleonMatrixPower100_right",
        "shuffleonMatrixPower100_middle",
        "shuffleonMatrixPower100_toborder",
        "neighbourchange20",
        "neighbourchange50",
        "neighbourchange100",
        "liftDown",
        "liftDown5",
        "liftDown10",
        "liftDown20",
        "liftUp5",
        "liftUp10",
        "liftUp20",
        "liftDown10Up10",
        "liftUp2",
        "liftDown2",
        "liftDown2Up2",
        "liftBigDown",
        "liftBigUp",
        "liftUp",
        "shufflecolumnXZgo5",
        "partcolumnXZgo5",
        "replaceSquere3x3",
        "replaceSquere2x2",
        "replaceSquere4x4",
        "replaceSquere5x5",
        "replaceSquere4x4Random",
        "replaceSquere3x3Random",
        "replaceSquere5x5Random",
        "replaceSquere6x6Random",
        "replaceSquere6x6",
        "replaceSquere7x7",
        "replaceSquere7x7Random",
        "replaceRectangleRandom",
        "replaceRectangle",
        "neighbourchange2",
        "replaceSquere8x8Random",
        "replaceSquere8x8",
        "replaceSquere9x9Random",
        "replaceSquere9x9",
        "replaceSquere10x10Random2",
        "replaceSquere10x10Random3",
        "replaceSquere10x10Random4",
        "replaceSquere10x10Random5",
        "replaceSquere10x10Random6",
        "replaceSquere10x10",
        "shuffleSamePower",
        "shuffleSamePowerMulti",
        "mixingZLayersInRecatngle",
        "shuffleSamePowerWidth",
        "shuffleSamePowerWidth_10",
        "shuffleSamePowerWidth_50",
        "rombono3_inY",
        "rombono3_inX",
        "rombono2_inX",
        "replace3Squere5x5",
        "replace3Squere8x8",
        "replace3Squere10x10",
        "replace3Squere2x2",
        "replace3Squere2x2Multi",
        "change2PointsToMiddle",
        "diffPointson2Points",
        "join2Points",
        "replace3Squere4x4",
        "replace3Squere3x3",
        "middleColumn",
        "middleColumnRevert",
        "midd2",
        "layerInMiddle",
        "layerInMiddle2Down",
        "powerChangeOneLayerZ",
        "moveQuere4x4",
        "moveQuere4x4Multi",
        "moveQuere5x5",
        "moveQuere5x5Multi",
        "moveQuere3x3",
        "moveQuere3x3Multi",
        "moveQuere6x6",
        "moveQuere2x2Multi",
        "moveQuere2x2",
        "shuffleDiagonal_w1",
        "shuffleDiagonal_w2",
        "shuffleDiagonal_w3",
        "shuffleDiagonal_w4",
        "shuffleDiagonal_w5",
        "bw1",
        "bw2",
        "bw3",
        "bw4",
        "bw5",
        "bw12345",
        "bw12345rand50",
        "inveroZ",
        "neighbourchangeOnlyZMulti5",
        "neighbourchangeOnlyZ",
        "neighbourchangeOnlyZMulti8",
        "neighbourchangeOnlyZMulti16",
        "neighbourchangeOnlyZMulti32",
        "neighbourchangeOnlyZMulti64",
        "neighbourchangeOnlyZMulti128"
    ];

    public function setNumerMutation($nr)
    {
        $this->nrmutation = $nr;
    }

    public function addmutation($pop, $crossing, $method = NULL)
    {

        $max = count($pop);
        $mutationList = $this->mutationList;
        if ($method) {
            $mutationList = [$method];
        }
        $nrmed = count($mutationList) - 1;

        for ($i = 0; $i < $this->nrmutation; $i++) {
            $go = rand(0, $max - 1);
            $m = $mutationList[rand(0, $nrmed)];
            $area = $this->$m($pop[$go]);
            $pop[] = $area;
            $crossing[] = $m;
        }

        return [$pop, $crossing];
    }


    private function godown1x1($pop, $nr = 10)
    {

        $changed = 0;
        $i = 1500;
        while ($changed == 0 && $i > 0) {
            $x = rand(0, $nr - 1);
            $y = rand(0, $nr - 1);
            $z = rand(0, $nr - 1);
            if ($pop[$x][$y][$z] == 1) {
                $pop[$x][$y][$z] = 0;
                $changed = 1;
            }
            $i--;
        }

        return  $pop;
    }

    private function goup1x1($pop, $nr = 10)
    {
        $changed = 0;
        $i = 1500;
        while ($changed == 0 && $i > 0) {
            $x = rand(0, $nr - 1);
            $y = rand(0, $nr - 1);
            $z = rand(0, $nr - 1);
            if ($pop[$x][$y][$z] == 0) {
                $pop[$x][$y][$z] = 1;
                $changed = 1;
            }
            $i--;
        }
        return $pop;
    }

    private function goupanddown1x1($pop, $nr = 10)
    {
        $pop = $this->godown1x1($pop, $nr);
        $pop = $this->goup1x1($pop, $nr);
        return $pop;
    }

    private function changecolumnXY($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i == $pom1 && $j == $pom2) {
                        $pop[$i][$j][$z] = rand(0, 1);
                    }
                }
            }
        }
        return $pop;
    }

    private function changecolumnXZ($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i == $pom1 && $z == $pom2) {
                        $pop[$i][$j][$z] = rand(0, 1);
                    }
                }
            }
        }
        return $pop;
    }

    private function changecolumnYZ($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($z == $pom1 && $j == $pom2) {
                        $pop[$i][$j][$z] = rand(0, 1);
                    }
                }
            }
        }
        return $pop;
    }


    private function shufflecolumnXY($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i == $pom1 && $j == $pom2) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i == $pom1 && $j == $pom2) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }


    private function shufflecolumnXZ($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i == $pom1 && $z == $pom2) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i == $pom1 && $z == $pom2) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function shufflecolumnYZ($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($j == $pom1 && $z == $pom2) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($j == $pom1 && $z == $pom2) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }


    private function changeRand4x4($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 2);
        $pom2 = rand(0, $nr - 2);
        $pom3 = rand(0, $nr - 2);

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if (($i >= $pom1 && $i <= $pom1 + 1)
                        && ($j >= $pom2 && $j <= $pom2 + 1)
                        && ($z >= $pom3 && $z <= $pom3 + 1)
                    ) {
                        $pop[$i][$j][$z] = rand(0, 1);
                    }
                }
            }
        }
        return $pop;
    }

    private function changeRand9x9($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 3);
        $pom2 = rand(0, $nr - 3);
        $pom3 = rand(0, $nr - 3);

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if (($i >= $pom1 && $i <= $pom1 + 2)
                        && ($j >= $pom2 && $j <= $pom2 + 2)
                        && ($z >= $pom3 && $z <= $pom3 + 2)
                    ) {
                        $pop[$i][$j][$z] = rand(0, 1);
                    }
                }
            }
        }
        return $pop;
    }

    private function changeRand16x16($pop, $nr = 10)
    {
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
                        $pop[$i][$j][$z] = rand(0, 1);
                    }
                }
            }
        }
        return $pop;
    }

    private function shuffleRand4x4($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 2);
        $pom2 = rand(0, $nr - 2);
        $pom3 = rand(0, $nr - 2);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if (($i >= $pom1 && $i <= $pom1 + 1)
                        && ($j >= $pom2 && $j <= $pom2 + 1)
                        && ($z >= $pom3 && $z <= $pom3 + 1)
                    ) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if (($i >= $pom1 && $i <= $pom1 + 1)
                        && ($j >= $pom2 && $j <= $pom2 + 1)
                        && ($z >= $pom3 && $z <= $pom3 + 1)
                    ) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }

        return $pop;
    }

    private function shuffleRand9x9($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 3);
        $pom2 = rand(0, $nr - 3);
        $pom3 = rand(0, $nr - 3);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if (($i >= $pom1 && $i <= $pom1 + 2)
                        && ($j >= $pom2 && $j <= $pom2 + 2)
                        && ($z >= $pom3 && $z <= $pom3 + 2)
                    ) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if (($i >= $pom1 && $i <= $pom1 + 2)
                        && ($j >= $pom2 && $j <= $pom2 + 2)
                        && ($z >= $pom3 && $z <= $pom3 + 2)
                    ) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }

        return $pop;
    }


    private function shuffleRand16x16($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 4);
        $pom2 = rand(0, $nr - 4);
        $pom3 = rand(0, $nr - 4);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if (($i >= $pom1 && $i <= $pom1 + 3)
                        && ($j >= $pom2 && $j <= $pom2 + 3)
                        && ($z >= $pom3 && $z <= $pom3 + 3)
                    ) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if (($i >= $pom1 && $i <= $pom1 + 3)
                        && ($j >= $pom2 && $j <= $pom2 + 3)
                        && ($z >= $pom3 && $z <= $pom3 + 3)
                    ) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }


    private function neighbourchange($pop, $nr = 10)
    {

        $changed = 0;
        $ix = 500;
        while ($changed == 0 && $ix > 0) {

            $pom1 = rand(1, $nr - 2);
            $pom2 = rand(1, $nr - 2);
            $pom3 = rand(1, $nr - 2);

            $changex = rand(-1, 1);
            $changey = rand(-1, 1);
            $changez = rand(-1, 1);

            if ($pop[$pom1 + $changex][$pom2 + $changey][$pom3 + $changez] != $pop[$pom1][$pom2][$pom3]) {
                $pom = $pop[$pom1][$pom2][$pom3];
                $pop[$pom1][$pom2][$pom3] = $pop[$pom1 + $changex][$pom2 + $changey][$pom3 + $changez];
                $pop[$pom1 + $changex][$pom2 + $changey][$pom3 + $changez] = $pom;
                $changed = 1;
            }
            $ix--;
        }


        return $pop;
    }

    private function neighbourchange5($pop, $nr = 10)
    {
        for ($i = 0; $i < 5; $i++) {
            $pop = $this->neighbourchange($pop, $nr);
        }
        return $pop;
    }

    private function neighbourchange10($pop, $nr = 10)
    {
        for ($i = 0; $i < 10; $i++) {
            $pop = $this->neighbourchange($pop, $nr);
        }
        return $pop;
    }

    private function neighbourchange20($pop, $nr = 10)
    {
        for ($i = 0; $i < 20; $i++) {
            $pop = $this->neighbourchange($pop, $nr);
        }
        return $pop;
    }

    private function neighbourchange50($pop, $nr = 10)
    {
        for ($i = 0; $i < 50; $i++) {
            $pop = $this->neighbourchange($pop, $nr);
        }
        return $pop;
    }

    private function neighbourchange100($pop, $nr = 10)
    {
        for ($i = 0; $i < 100; $i++) {
            $pop = $this->neighbourchange($pop, $nr);
        }
        return $pop;
    }

    private function neighbourchange2($pop, $nr = 10)
    {
        for ($i = 0; $i < 2; $i++) {
            $pop = $this->neighbourchange($pop, $nr);
        }
        return $pop;
    }

    private function exchangecolumnXZ($pop, $nr = 10)
    {
        $pom1 = rand(1, $nr - 3);
        $pom2 = rand(1, $nr - 3);
        $used = 0;

        $changepom1 = rand(-1, 1);
        $changepom2 = rand(-1, 1);

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i == $pom1 && $z == $pom2) {
                        $used = $pop[$i][$j][$z];
                        $pop[$i][$j][$z] = $pop[$i + $changepom1][$j][$z + $changepom2];
                        $pop[$i + $changepom1][$j][$z + $changepom2] = $used;
                    }
                }
            }
        }
        return $pop;
    }

    private function exchangecolumnXY($pop, $nr = 10)
    {
        $pom1 = rand(1, $nr - 3);
        $pom2 = rand(1, $nr - 3);
        $used = 0;

        $changepom1 = rand(-1, 1);
        $changepom2 = rand(-1, 1);

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i == $pom1 && $j == $pom2) {
                        $used = $pop[$i][$j][$z];
                        $pop[$i][$j][$z] = $pop[$i + $changepom1][$j + $changepom2][$z];
                        $pop[$i + $changepom1][$j + $changepom2][$z] = $used;
                    }
                }
            }
        }
        return $pop;
    }

    private function exchangecolumnYZ($pop, $nr = 10)
    {
        $pom1 = rand(1, $nr - 3);
        $pom2 = rand(1, $nr - 3);
        $used = 0;

        $changepom1 = rand(-1, 1);
        $changepom2 = rand(-1, 1);

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($j == $pom1 && $z == $pom2) {
                        $used = $pop[$i][$j][$z];
                        $pop[$i][$j][$z] = $pop[$i][$j + $changepom1][$z + $changepom2];
                        $pop[$i][$j + $changepom1][$z + $changepom2] = $used;
                    }
                }
            }
        }
        return $pop;
    }


    private function exchangefarcolumnXZ($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $used = 0;

        $changepom1 = rand(0, $nr - 1);
        $changepom2 = rand(0, $nr - 1);

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i == $pom1 && $z == $pom2) {
                        $used = $pop[$i][$j][$z];
                        $pop[$i][$j][$z] = $pop[$changepom1][$j][$changepom2];
                        $pop[$changepom1][$j][$changepom2] = $used;
                    }
                }
            }
        }
        return $pop;
    }

    private function exchangefarcolumnXY($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $used = 0;

        $changepom1 = rand(0, $nr - 1);
        $changepom2 = rand(0, $nr - 1);

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i == $pom1 && $j == $pom2) {
                        $used = $pop[$i][$j][$z];
                        $pop[$i][$j][$z] = $pop[$changepom1][$changepom2][$z];
                        $pop[$changepom1][$changepom2][$z] = $used;
                    }
                }
            }
        }
        return $pop;
    }

    private function exchangefarcolumnYZ($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $used = 0;

        $changepom1 = rand(0, $nr - 1);
        $changepom2 = rand(0, $nr - 1);

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($j == $pom1 && $z == $pom2) {
                        $used = $pop[$i][$j][$z];
                        $pop[$i][$j][$z] = $pop[$i][$changepom1][$changepom2];
                        $pop[$i][$changepom1][$changepom2] = $used;
                    }
                }
            }
        }
        return $pop;
    }

    private function changecolumnYZgo6($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $pom3 = rand(0, 3);

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($z == $pom1 && $j == $pom2 && ($pom3 < $i && $pom3 + 6 >= $i)) {
                        $pop[$i][$j][$z] = rand(0, 1);
                    }
                }
            }
        }
        return $pop;
    }

    private function changecolumnXZgo6($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $pom3 = rand(0, 3);

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i == $pom1 && $j == $pom2  && ($pom3 < $z && $pom3 + 6 >= $z)) {
                        $pop[$i][$j][$z] = rand(0, 1);
                    }
                }
            }
        }
        return $pop;
    }

    private function changecolumnXYgo6($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $pom3 = rand(0, 3);

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($z == $pom1 && $i == $pom2 && ($pom3 < $j && $pom3 + 6 >= $j)) {
                        $pop[$i][$j][$z] = rand(0, 1);
                    }
                }
            }
        }
        return $pop;
    }

    private function shufflecolumnXZgo6($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $pom3 = rand(0, 3);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i == $pom1 && $z == $pom2 && ($pom3 < $j && $pom3 + 6 >= $j)) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i == $pom1 && $z == $pom2 && ($pom3 < $j && $pom3 + 6 >= $j)) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function shufflecolumnXYgo6($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $pom3 = rand(0, 3);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i == $pom1 && $j == $pom2 && ($pom3 < $z && $pom3 + 6 >= $z)) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i == $pom1 && $j == $pom2 && ($pom3 < $z && $pom3 + 6 >= $z)) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function shufflecolumnYZgo6($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $pom3 = rand(0, 3);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($j == $pom1 && $z == $pom2 && ($pom3 < $i && $pom3 + 6 >= $i)) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($j == $pom1 && $z == $pom2 && ($pom3 < $i && $pom3 + 6 >= $i)) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function changecolumnYZgo4($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $pom3 = rand(0, 5);

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($z == $pom1 && $j == $pom2 && ($pom3 < $i && $pom3 + 4 >= $i)) {
                        $pop[$i][$j][$z] = rand(0, 1);
                    }
                }
            }
        }
        return $pop;
    }

    private function changecolumnXZgo4($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $pom3 = rand(0, 5);

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i == $pom1 && $j == $pom2  && ($pom3 < $z && $pom3 + 4 >= $z)) {
                        $pop[$i][$j][$z] = rand(0, 1);
                    }
                }
            }
        }
        return $pop;
    }

    private function changecolumnXYgo4($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $pom3 = rand(0, 5);

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($z == $pom1 && $i == $pom2 && ($pom3 < $j && $pom3 + 4 >= $j)) {
                        $pop[$i][$j][$z] = rand(0, 1);
                    }
                }
            }
        }
        return $pop;
    }

    private function shufflecolumnXZgo4($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $pom3 = rand(0, 5);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i == $pom1 && $z == $pom2 && ($pom3 < $j && $pom3 + 4 >= $j)) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i == $pom1 && $z == $pom2 && ($pom3 < $j && $pom3 + 4 >= $j)) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function shufflecolumnXYgo4($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $pom3 = rand(0, 5);
        $used = [];

        $df = 2000;
        while ($df > 0 && $this->isNotDiffer($used)) {
            $used = [];
            $pom1 = rand(0, $nr - 1);
            $pom2 = rand(0, $nr - 1);
            $pom3 = rand(0, 5);
            for ($i = 0; $i < $nr; $i++) {
                for ($j = 0; $j < $nr; $j++) {
                    for ($z = 0; $z < $nr; $z++) {
                        if ($i == $pom1 && $j == $pom2 && ($pom3 < $z && $pom3 + 4 >= $z)) {
                            $used[] = $pop[$i][$j][$z];
                        }
                    }
                }
            }
            $df--;
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i == $pom1 && $j == $pom2 && ($pom3 < $z && $pom3 + 4 >= $z)) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function shufflecolumnYZgo4($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $pom3 = rand(0, 5);
        $used = [];

        $df = 2000;
        while ($df > 0 && $this->isNotDiffer($used)) {
            $used = [];
            $pom1 = rand(0, $nr - 1);
            $pom2 = rand(0, $nr - 1);
            $pom3 = rand(0, 5);
            for ($i = 0; $i < $nr; $i++) {
                for ($j = 0; $j < $nr; $j++) {
                    for ($z = 0; $z < $nr; $z++) {
                        if ($j == $pom1 && $z == $pom2 && ($pom3 < $i && $pom3 + 4 >= $i)) {
                            $used[] = $pop[$i][$j][$z];
                        }
                    }
                }
            }
            $df--;
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($j == $pom1 && $z == $pom2 && ($pom3 < $i && $pom3 + 4 >= $i)) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }


    private function clockwiseXYleft($pop, $nr = 10)
    {
        $pom = rand(0, $nr - 1);
        $pop2 = $pop;
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i == $pom) {
                        $pop2[$i][$j][$z] = $pop[$i][$z][$nr - $j - 1];
                    }
                }
            }
        }
        return $pop2;
    }

    private function clockwiseXZleft($pop, $nr = 10)
    {
        $pom = rand(0, $nr - 1);
        $pop2 = $pop;
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($j == $pom) {
                        $pop2[$i][$j][$z] = $pop[$z][$j][$nr - $i - 1];
                    }
                }
            }
        }
        return $pop2;
    }

    private function clockwiseYZleft($pop, $nr = 10)
    {
        $pom = rand(0, $nr - 1);
        $pop2 = $pop;
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($z == $pom) {
                        $pop2[$i][$j][$z] = $pop[$j][$nr - $i - 1][$z];
                    }
                }
            }
        }
        return $pop2;
    }

    private function clockwiseXYright($pop, $nr = 10)
    {
        $pom = rand(0, $nr - 1);
        $pop2 = $pop;
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i == $pom) {
                        $pop2[$i][$j][$z] =  $pop[$i][$nr - $z - 1][$j];
                    }
                }
            }
        }
        return $pop2;
    }

    private function clockwiseXZright($pop, $nr = 10)
    {
        $pom = rand(0, $nr - 1);
        $pop2 = $pop;
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($j == $pom) {
                        $pop2[$i][$j][$z] = $pop[$nr - 1 - $z][$j][$i];
                    }
                }
            }
        }
        return $pop2;
    }

    private function clockwiseYZright($pop, $nr = 10)
    {
        $pom = rand(0, $nr - 1);
        $pop2 = $pop;
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($z == $pom) {
                        $pop2[$i][$j][$z] = $pop2[$nr - 1 - $j][$i][$z];
                    }
                }
            }
        }
        return $pop2;
    }


    private function mirrorXY($pop, $nr = 10)
    {
        $pom = rand(0, $nr - 1);
        $pop2 = $pop;
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($z == $pom) {
                        $pop2[$i][$j][$z] = $pop[$i][$j][$nr - 1 - $z];
                    }
                }
            }
        }
        return $pop2;
    }

    private function mirrorXZ($pop, $nr = 10)
    {
        $pom = rand(0, $nr - 1);
        $pop2 = $pop;
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($j == $pom) {
                        $pop2[$i][$j][$z] = $pop[$i][$nr - 1 - $j][$z];
                    }
                }
            }
        }
        return $pop2;
    }

    private function mirrorYZ($pop, $nr = 10)
    {
        $pom = rand(0, $nr - 1);
        $pop2 = $pop;
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i == $pom) {
                        $pop2[$i][$j][$z] = $pop[$nr - 1 - $i][$j][$z];
                    }
                }
            }
        }
        return $pop2;
    }


    private function mirrorXY_d($pop, $nr = 10)
    {
        $pom = rand(0, $nr - 1);
        $pop2 = $pop;
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($z == $pom) {
                        $pop2[$i][$j][$z] = $pop[$nr - 1 - $j][$nr - 1 - $i][$z];
                    }
                }
            }
        }
        return $pop2;
    }

    private function mirrorXZ_d($pop, $nr = 10)
    {
        $pom = rand(0, $nr - 1);
        $pop2 = $pop;
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($j == $pom) {
                        $pop2[$i][$j][$z] = $pop[$nr - 1 - $z][$j][10 - 1 - $i];
                    }
                }
            }
        }
        return $pop2;
    }

    private function mirrorYZ_d($pop, $nr = 10)
    {
        $pom = rand(0, $nr - 1);
        $pop2 = $pop;
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i == $pom) {
                        $pop2[$i][$j][$z] = $pop[$i][$nr - 1 - $z][$nr - 1 - $j];
                    }
                }
            }
        }
        return $pop2;
    }


    private function changeOneLayerZ($pop, $nr = 10)
    {

        $pop2 = $pop;

        $z1 = rand(0, $nr - 1);
        $z2 = rand(0, $nr - 1);


        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($z != $z1 && $z != $z2) {
                        $pop2[$i][$j][$z] = $pop[$i][$j][$z];
                    } elseif ($z1 == $z) {
                        $pop2[$i][$j][$z] = $pop[$i][$j][$z2];
                    } elseif ($z2 == $z) {
                        $pop2[$i][$j][$z] = $pop[$i][$j][$z1];
                    }
                }
            }
        }
        return $pop2;
    }

    private function changeOneLayerX($pop, $nr = 10)
    {

        $pop2 = $pop;

        $p1 = rand(0, $nr - 1);
        $p2 = rand(0, $nr - 1);


        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i != $p1 && $i != $p2) {
                        $pop2[$i][$j][$z] = $pop[$i][$j][$z];
                    } elseif ($p1 == $i) {
                        $pop2[$i][$j][$z] = $pop[$p2][$j][$z];
                    } elseif ($p2 == $i) {
                        $pop2[$i][$j][$z] = $pop[$p1][$j][$z];
                    }
                }
            }
        }
        return $pop2;
    }

    private function changeOneLayerY($pop, $nr = 10)
    {

        $pop2 = $pop;

        $p1 = rand(0, $nr - 1);
        $p2 = rand(0, $nr - 1);


        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($j != $p1 && $j != $p2) {
                        $pop2[$i][$j][$z] = $pop[$i][$j][$z];
                    } elseif ($p1 == $j) {
                        $pop2[$i][$j][$z] = $pop[$i][$p2][$z];
                    } elseif ($p2 == $j) {
                        $pop2[$i][$j][$z] = $pop[$i][$p1][$z];
                    }
                }
            }
        }
        return $pop2;
    }

    private function changeOneLayerZ2($pop, $nr = 10)
    {
        $p1 = rand(1, 5);
        $pop2 = $pop;
        for ($i = 0; $i < $p1; $i++) {
            $pop2 = $this->changeOneLayerZ($pop2, $nr);
        }
        return $pop2;
    }

    private function changeOneLayerX2($pop, $nr = 10)
    {
        $p1 = rand(1, 5);
        $pop2 = $pop;
        for ($i = 0; $i < $p1; $i++) {
            $pop2 = $this->changeOneLayerX($pop2, $nr);
        }
        return $pop2;
    }

    private function changeOneLayerY2($pop, $nr = 10)
    {
        $p1 = rand(1, 5);
        $pop2 = $pop;
        for ($i = 0; $i < $p1; $i++) {
            $pop2 = $this->changeOneLayerY($pop2, $nr);
        }
        return $pop2;
    }

    private function jointwopointsZ($pop, $nr = 10)
    {
        $min = 1;
        $pop2 = $pop;
        $point1 = $this->searchPoint(1, $pop, $nr, $min);
        $point2 = $this->searchPoint(1, $pop, $nr, $min);
        if ($point1 == false || $point2 == false) {
            return $pop2;
        }
        $point3 = $this->searchPoint(0, $pop, min($point1['z'], $point2['z']), 1);

        if ($point3 == false) {
            return $pop2;
        }
        $pop2[$point1['x']][$point1['y']][$point1['z']] = 0;
        $pop2[$point2['x']][$point2['y']][$point2['z']] = 0;
        $pop2[$point3['x']][$point3['y']][$point3['z']] = 1;
        return $pop2;
    }

    private function dividepointsZ($pop, $nr = 10)
    {
        $min = 0;
        $pop2 = $pop;
        $point1 = $this->searchPoint(1, $pop, $nr, $min);
        if ($point1 == false) {
            return $pop2;
        }
        $point2 = $this->searchPoint(0, $pop, $nr, $point1['z']);
        $point3 = $this->searchPoint(0, $pop, $nr, $point1['z']);

        if ($point2 == false || $point3 == false) {
            return $pop2;
        }
        $pop2[$point1['x']][$point1['y']][$point1['z']] = 0;
        $pop2[$point2['x']][$point2['y']][$point2['z']] = 1;
        $pop2[$point3['x']][$point3['y']][$point3['z']] = 1;
        return $pop2;
    }


    private function searchPoint($found, $pop, $max, $min)
    {
        $try = 0;
        $point = false;
        while ($try < 20) {
            $x = rand(0, $max - 1);
            $y = rand(0, $max - 1);
            $z = rand($min, $max - 1);
            if ($pop[$x][$y][$z] == $found) {
                $point = ['x' => $x, 'y' => $y, 'z' => $z];
                break;
            }
            $try++;
        }
        return $point;
    }

    private function jointwopointsZ5($pop, $nr = 10)
    {
        $p1 = rand(1, 8);
        $pop2 = $pop;
        for ($i = 0; $i < $p1; $i++) {
            $pop2 = $this->jointwopointsZ($pop2, $nr);
        }
        return $pop2;
    }

    private function dividepointsZ5($pop, $nr = 10)
    {
        $p1 = rand(1, 8);
        $pop2 = $pop;
        for ($i = 0; $i < $p1; $i++) {
            $pop2 = $this->dividepointsZ($pop2, $nr);
        }
        return $pop2;
    }

    private function mixingZLayers($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 2);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($z == $pom1 || $z == $pom1 + 1) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($z == $pom1 || $z == $pom1 + 1) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function mixingVerticalLayersX($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 1);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i == $pom1) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i == $pom1) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function mixingVerticalLayersY($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 1);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($j == $pom1) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($j == $pom1) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function mixingVerticalLayersZ($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 1);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($z == $pom1) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($z == $pom1) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function mixingXLayers($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 2);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i == $pom1 || $i == $pom1 + 1) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i == $pom1 || $i == $pom1 + 1) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function mixingYLayers($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 2);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($j == $pom1 || $j == $pom1 + 1) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($j == $pom1 || $j == $pom1 + 1) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function shuffleRand5x5x5($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 5);
        $pom2 = rand(0, $nr - 5);
        $pom3 = rand(0, $nr - 5);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if (($i >= $pom1 && $i <= $pom1 + 4)
                        && ($j >= $pom2 && $j <= $pom2 + 4)
                        && ($z >= $pom3 && $z <= $pom3 + 4)
                    ) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if (($i >= $pom1 && $i <= $pom1 + 4)
                        && ($j >= $pom2 && $j <= $pom2 + 4)
                        && ($z >= $pom3 && $z <= $pom3 + 4)
                    ) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function shuffleRand6x6x6($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 6);
        $pom2 = rand(0, $nr - 6);
        $pom3 = rand(0, $nr - 6);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if (($i >= $pom1 && $i <= $pom1 + 5)
                        && ($j >= $pom2 && $j <= $pom2 + 5)
                        && ($z >= $pom3 && $z <= $pom3 + 5)
                    ) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if (($i >= $pom1 && $i <= $pom1 + 5)
                        && ($j >= $pom2 && $j <= $pom2 + 5)
                        && ($z >= $pom3 && $z <= $pom3 + 5)
                    ) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function shuffleRand7x7x7($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 7);
        $pom2 = rand(0, $nr - 7);
        $pom3 = rand(0, $nr - 7);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if (($i >= $pom1 && $i <= $pom1 + 6)
                        && ($j >= $pom2 && $j <= $pom2 + 6)
                        && ($z >= $pom3 && $z <= $pom3 + 6)
                    ) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if (($i >= $pom1 && $i <= $pom1 + 6)
                        && ($j >= $pom2 && $j <= $pom2 + 6)
                        && ($z >= $pom3 && $z <= $pom3 + 6)
                    ) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function shufflecolumnXY_3x3($pop, $nr = 10)
    {
        $pom1 = rand(1, $nr - 2);
        $pom2 = rand(1, $nr - 2);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i >= $pom1 - 1 && $i <= $pom1 + 1 && $j >= $pom2 - 1 && $j <= $pom2 + 1) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i >= $pom1 - 1 && $i <= $pom1 + 1 && $j >= $pom2 - 1 && $j <= $pom2 + 1) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function shufflecolumnXZ_3x3($pop, $nr = 10)
    {
        $pom1 = rand(1, $nr - 2);
        $pom2 = rand(1, $nr - 2);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i >= $pom1 - 1 && $i <= $pom1 + 1 && $z >= $pom2 - 1 && $z <= $pom2 + 1) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i >= $pom1 - 1 && $i <= $pom1 + 1 && $z >= $pom2 - 1 && $z <= $pom2 + 1) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function shufflecolumnYZ_3x3($pop, $nr = 10)
    {
        $pom1 = rand(1, $nr - 2);
        $pom2 = rand(1, $nr - 2);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($j >= $pom1 - 1 && $j <= $pom1 + 1 && $z >= $pom2 - 1 && $z <= $pom2 + 1) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($j >= $pom1 - 1 && $j <= $pom1 + 1 && $z >= $pom2 - 1 && $z <= $pom2 + 1) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function exchangefarcolumnXYMultiple($pop, $nr = 10)
    {
        $p1 = rand(2, 8);
        $pop2 = $pop;
        for ($i = 0; $i < $p1; $i++) {
            $pop2 = $this->exchangefarcolumnXY($pop2, $nr);
        }
        return $pop2;
    }

    private function shuffleRand6x6x3_Z($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 6);
        $pom2 = rand(0, $nr - 6);
        $pom3 = rand(0, $nr - 3);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if (($i >= $pom1 && $i <= $pom1 + 5)
                        && ($j >= $pom2 && $j <= $pom2 + 5)
                        && ($z >= $pom3 && $z <= $pom3 + 2)
                    ) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if (($i >= $pom1 && $i <= $pom1 + 5)
                        && ($j >= $pom2 && $j <= $pom2 + 5)
                        && ($z >= $pom3 && $z <= $pom3 + 2)
                    ) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function shuffleRand6x6x3_Y($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 6);
        $pom2 = rand(0, $nr - 3);
        $pom3 = rand(0, $nr - 6);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if (($i >= $pom1 && $i <= $pom1 + 5)
                        && ($j >= $pom2 && $j <= $pom2 + 2)
                        && ($z >= $pom3 && $z <= $pom3 + 5)
                    ) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if (($i >= $pom1 && $i <= $pom1 + 5)
                        && ($j >= $pom2 && $j <= $pom2 + 2)
                        && ($z >= $pom3 && $z <= $pom3 + 5)
                    ) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }


    private function shuffleRand6x6x3_X($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 3);
        $pom2 = rand(0, $nr - 6);
        $pom3 = rand(0, $nr - 6);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if (($i >= $pom1 && $i <= $pom1 + 2)
                        && ($j >= $pom2 && $j <= $pom2 + 5)
                        && ($z >= $pom3 && $z <= $pom3 + 5)
                    ) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if (($i >= $pom1 && $i <= $pom1 + 2)
                        && ($j >= $pom2 && $j <= $pom2 + 5)
                        && ($z >= $pom3 && $z <= $pom3 + 5)
                    ) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function shuffleRand6x6x2_Z($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 6);
        $pom2 = rand(0, $nr - 6);
        $pom3 = rand(0, $nr - 2);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if (($i >= $pom1 && $i <= $pom1 + 5)
                        && ($j >= $pom2 && $j <= $pom2 + 5)
                        && ($z >= $pom3 && $z <= $pom3 + 1)
                    ) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if (($i >= $pom1 && $i <= $pom1 + 5)
                        && ($j >= $pom2 && $j <= $pom2 + 5)
                        && ($z >= $pom3 && $z <= $pom3 + 1)
                    ) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function shuffleRand6x6x2_Y($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 6);
        $pom2 = rand(0, $nr - 2);
        $pom3 = rand(0, $nr - 6);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if (($i >= $pom1 && $i <= $pom1 + 5)
                        && ($j >= $pom2 && $j <= $pom2 + 1)
                        && ($z >= $pom3 && $z <= $pom3 + 5)
                    ) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if (($i >= $pom1 && $i <= $pom1 + 5)
                        && ($j >= $pom2 && $j <= $pom2 + 1)
                        && ($z >= $pom3 && $z <= $pom3 + 5)
                    ) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }


    private function shuffleRand6x6x2_X($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 2);
        $pom2 = rand(0, $nr - 6);
        $pom3 = rand(0, $nr - 6);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if (($i >= $pom1 && $i <= $pom1 + 1)
                        && ($j >= $pom2 && $j <= $pom2 + 5)
                        && ($z >= $pom3 && $z <= $pom3 + 5)
                    ) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if (($i >= $pom1 && $i <= $pom1 + 1)
                        && ($j >= $pom2 && $j <= $pom2 + 5)
                        && ($z >= $pom3 && $z <= $pom3 + 5)
                    ) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function shuffleRand6Lines($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $pom3 = rand(0, $nr - 1);
        $pom4 = rand(0, $nr - 1);
        $pom5 = rand(0, $nr - 1);
        $pom6 = rand(0, $nr - 1);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if (($i == $pom1 || $i == $pom4)
                        || ($j == $pom2 || $j == $pom5)
                        || ($z == $pom3 || $z == $pom6)
                    ) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if (($i == $pom1 || $i == $pom4)
                        || ($j == $pom2 || $j == $pom5)
                        || ($z == $pom3 || $z == $pom6)
                    ) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function shuffleRandBorder8x8x8($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 8);
        $pom2 = rand(0, $nr - 8);
        $pom3 = rand(0, $nr - 8);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    $cond = (($i >= $pom2 && $i <= $pom2 + 7) && ($i >= $pom3 && $i <= $pom3 + 7) &&
                        ($j >= $pom1 && $j <= $pom1 + 7) && ($j >= $pom3 && $j <= $pom3 + 7) &&
                        ($z >= $pom1 && $z <= $pom1 + 7) && ($z >= $pom2 && $z <= $pom2 + 7));


                    if ((($i == $pom1 || $i == $pom1 + 7)
                        || ($j == $pom2 || $j == $pom2 + 7)
                        || ($z == $pom3 || $z == $pom3 + 7)) && $cond) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    $cond = (($i >= $pom2 && $i <= $pom2 + 7) && ($i >= $pom3 && $i <= $pom3 + 7) &&
                        ($j >= $pom1 && $j <= $pom1 + 7) && ($j >= $pom3 && $j <= $pom3 + 7) &&
                        ($z >= $pom1 && $z <= $pom1 + 7) && ($z >= $pom2 && $z <= $pom2 + 7));

                    if ((($i == $pom1 || $i == $pom1 + 7)
                        || ($j == $pom2 || $j == $pom2 + 7)
                        || ($z == $pom3 || $z == $pom3 + 7)) && $cond) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function shuffleRandBorder7x7x7($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 7);
        $pom2 = rand(0, $nr - 7);
        $pom3 = rand(0, $nr - 7);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    $cond = (($i >= $pom2 && $i <= $pom2 + 6) && ($i >= $pom3 && $i <= $pom3 + 6) &&
                        ($j >= $pom1 && $j <= $pom1 + 6) && ($j >= $pom3 && $j <= $pom3 + 6) &&
                        ($z >= $pom1 && $z <= $pom1 + 6) && ($z >= $pom2 && $z <= $pom2 + 6));

                    if ((($i == $pom1 || $i == $pom1 + 6)
                        || ($j == $pom2 || $j == $pom2 + 6)
                        || ($z == $pom3 || $z == $pom3 + 6)) && $cond) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    $cond = (($i >= $pom2 && $i <= $pom2 + 6) && ($i >= $pom3 && $i <= $pom3 + 6) &&
                        ($j >= $pom1 && $j <= $pom1 + 6) && ($j >= $pom3 && $j <= $pom3 + 6) &&
                        ($z >= $pom1 && $z <= $pom1 + 6) && ($z >= $pom2 && $z <= $pom2 + 6));

                    if ((($i == $pom1 || $i == $pom1 + 6)
                        || ($j == $pom2 || $j == $pom2 + 6)
                        || ($z == $pom3 || $z == $pom3 + 6)) && $cond) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }



    private function shuffleRandBorder6x6x6($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 6);
        $pom2 = rand(0, $nr - 6);
        $pom3 = rand(0, $nr - 6);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    $cond = (($i >= $pom2 && $i <= $pom2 + 5) && ($i >= $pom3 && $i <= $pom3 + 5) &&
                        ($j >= $pom1 && $j <= $pom1 + 5) && ($j >= $pom3 && $j <= $pom3 + 5) &&
                        ($z >= $pom1 && $z <= $pom1 + 5) && ($z >= $pom2 && $z <= $pom2 + 5));

                    if ((($i == $pom1 || $i == $pom1 + 5)
                        || ($j == $pom2 || $j == $pom2 + 5)
                        || ($z == $pom3 || $z == $pom3 + 5)) && $cond) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    $cond = (($i >= $pom2 && $i <= $pom2 + 5) && ($i >= $pom3 && $i <= $pom3 + 5) &&
                        ($j >= $pom1 && $j <= $pom1 + 5) && ($j >= $pom3 && $j <= $pom3 + 5) &&
                        ($z >= $pom1 && $z <= $pom1 + 5) && ($z >= $pom2 && $z <= $pom2 + 5));

                    if ((($i == $pom1 || $i == $pom1 + 5)
                        || ($j == $pom2 || $j == $pom2 + 5)
                        || ($z == $pom3 || $z == $pom3 + 5)) && $cond) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function shuffleRandBorder5x5x5($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 5);
        $pom2 = rand(0, $nr - 5);
        $pom3 = rand(0, $nr - 5);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    $cond = (($i >= $pom2 && $i <= $pom2 + 4) && ($i >= $pom3 && $i <= $pom3 + 4) &&
                        ($j >= $pom1 && $j <= $pom1 + 4) && ($j >= $pom3 && $j <= $pom3 + 4) &&
                        ($z >= $pom1 && $z <= $pom1 + 4) && ($z >= $pom2 && $z <= $pom2 + 4));

                    if ((($i == $pom1 || $i == $pom1 + 4)
                        || ($j == $pom2 || $j == $pom2 + 4)
                        || ($z == $pom3 || $z == $pom3 + 4)) && $cond) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    $cond = (($i >= $pom2 && $i <= $pom2 + 4) && ($i >= $pom3 && $i <= $pom3 + 4) &&
                        ($j >= $pom1 && $j <= $pom1 + 4) && ($j >= $pom3 && $j <= $pom3 + 4) &&
                        ($z >= $pom1 && $z <= $pom1 + 4) && ($z >= $pom2 && $z <= $pom2 + 4));

                    if ((($i == $pom1 || $i == $pom1 + 4)
                        || ($j == $pom2 || $j == $pom2 + 4)
                        || ($z == $pom3 || $z == $pom3 + 4)) && $cond) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function shuffleRandBorder4x4x4($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 4);
        $pom2 = rand(0, $nr - 4);
        $pom3 = rand(0, $nr - 4);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    $cond = (($i >= $pom2 && $i <= $pom2 + 3) && ($i >= $pom3 && $i <= $pom3 + 3) &&
                        ($j >= $pom1 && $j <= $pom1 + 3) && ($j >= $pom3 && $j <= $pom3 + 3) &&
                        ($z >= $pom1 && $z <= $pom1 + 3) && ($z >= $pom2 && $z <= $pom2 + 3));

                    if ((($i == $pom1 || $i == $pom1 + 3)
                        || ($j == $pom2 || $j == $pom2 + 3)
                        || ($z == $pom3 || $z == $pom3 + 3)) && $cond) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    $cond = (($i >= $pom2 && $i <= $pom2 + 3) && ($i >= $pom3 && $i <= $pom3 + 3) &&
                        ($j >= $pom1 && $j <= $pom1 + 3) && ($j >= $pom3 && $j <= $pom3 + 3) &&
                        ($z >= $pom1 && $z <= $pom1 + 3) && ($z >= $pom2 && $z <= $pom2 + 3));

                    if ((($i == $pom1 || $i == $pom1 + 3)
                        || ($j == $pom2 || $j == $pom2 + 3)
                        || ($z == $pom3 || $z == $pom3 + 3)) && $cond) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }


    private function shuffleRand4x4x4($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 4);
        $pom2 = rand(0, $nr - 4);
        $pom3 = rand(0, $nr - 4);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if (($i >= $pom1 && $i <= $pom1 + 3)
                        && ($j >= $pom2 && $j <= $pom2 + 3)
                        && ($z >= $pom3 && $z <= $pom3 + 3)
                    ) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if (($i >= $pom1 && $i <= $pom1 + 3)
                        && ($j >= $pom2 && $j <= $pom2 + 3)
                        && ($z >= $pom3 && $z <= $pom3 + 3)
                    ) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function shuffleRand4x4x4Multiple($pop, $nr = 10)
    {
        $rand = rand(2, 4);
        $res = $pop;
        for ($i = 2; $i <= $rand; $i++) {
            $res = $this->shuffleRand4x4x4($res, $nr);
        }
        return $res;
    }

    private function shuffleRand5x5x5Multiple($pop, $nr = 10)
    {
        $rand = rand(2, 3);
        for ($i = 2; $i <= $rand; $i++) {
            $pop = $this->shuffleRand5x5x5($pop, $nr);
        }
        return $pop;
    }

    private function shuffleRand6x6x6Multiple($pop, $nr = 10)
    {
        $rand = rand(2, 3);
        for ($i = 2; $i <= $rand; $i++) {
            $pop = $this->shuffleRand6x6x6($pop, $nr);
        }
        return $pop;
    }

    private function shuffleRand9x9Multiple($pop, $nr = 10)
    {
        $rand = rand(2, 6);
        for ($i = 2; $i <= $rand; $i++) {
            $pop = $this->shuffleRand9x9($pop, $nr);
        }
        return $pop;
    }

    private function shufflecolumnYZgo6Multiple($pop, $nr = 10)
    {
        $rand = rand(2, 6);
        for ($i = 2; $i <= $rand; $i++) {
            $pop = $this->shufflecolumnYZgo6($pop, $nr);
        }
        return $pop;
    }

    private function shufflecolumnXZgo6Multiple($pop, $nr = 10)
    {
        $rand = rand(2, 6);
        for ($i = 2; $i <= $rand; $i++) {
            $pop = $this->shufflecolumnXZgo6($pop, $nr);
        }
        return $pop;
    }

    private function mixingZLayers3Times($pop, $nr = 10)
    {

        for ($i = 0; $i < 3; $i++) {
            $pop = $this->mixingZLayers($pop, $nr);
        }
        return $pop;
    }

    private function godownInOneLayer($pop, $nr = 10)
    {

        $z = rand(0, $nr - 1);
        $nr = rand(2, 10);
        for ($i = 0; $i < $nr; $i++) {
            $x = rand(0, $nr - 1);
            $y = rand(0, $nr - 1);
            $pop[$x][$y][$z] = 0;
        }


        return  $pop;
    }

    private function goupInOneLayer($pop, $nr = 10)
    {

        $z = rand(0, $nr - 1);
        $nr = rand(2, 10);
        for ($i = 0; $i < $nr; $i++) {
            $x = rand(0, $nr - 1);
            $y = rand(0, $nr - 1);
            $pop[$x][$y][$z] = 1;
        }

        return  $pop;
    }

    private function shuffledoublecrossinOneLayerZ($pop, $nr = 10)
    {
        $pom_x1 = rand(0, $nr - 1);
        $pom_x2 = rand(0, $nr - 1);
        $pom_y1 = rand(0, $nr - 1);
        $pom_y2 = rand(0, $nr - 1);
        $pom_z = rand(0, $nr - 1);

        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if ($z == $pom_z && ($i == $pom_x1 || $i == $pom_x2 || $j == $pom_y1 || $j == $pom_y2)) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($z == $pom_z && ($i == $pom_x1 || $i == $pom_x2 || $j == $pom_y1 || $j == $pom_y2)) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function shuffleMaxBorder_LayerZ_width_1($pop, $nr = 10)
    {
        $pom_z = rand(0, $nr - 1);

        $possible_x = [];
        $possible_y = [];

        for ($i = 0; $i < 1; $i++) {
            $possible_x[] = $i;
            $possible_y[] = $i;
            $possible_x[] = $nr - $i - 1;
            $possible_y[] = $nr - $i - 1;
        }


        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if ($z == $pom_z && (in_array($i, $possible_x) || in_array($j, $possible_y))) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if ($z == $pom_z && (in_array($i, $possible_x) || in_array($j, $possible_y))) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function shuffleMaxBorder_LayerZ_width_2($pop, $nr = 10)
    {
        $pom_z = rand(0, $nr - 1);

        $possible_x = [];
        $possible_y = [];

        for ($i = 0; $i < 2; $i++) {
            $possible_x[] = $i;
            $possible_y[] = $i;
            $possible_x[] = $nr - $i - 1;
            $possible_y[] = $nr - $i - 1;
        }


        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if ($z == $pom_z && (in_array($i, $possible_x) || in_array($j, $possible_y))) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if ($z == $pom_z && (in_array($i, $possible_x) || in_array($j, $possible_y))) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function shuffleMaxBorder_LayerZ_width_3($pop, $nr = 10)
    {
        $pom_z = rand(0, $nr - 1);

        $possible_x = [];
        $possible_y = [];

        for ($i = 0; $i < 3; $i++) {
            $possible_x[] = $i;
            $possible_y[] = $i;
            $possible_x[] = $nr - $i - 1;
            $possible_y[] = $nr - $i - 1;
        }


        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if ($z == $pom_z && (in_array($i, $possible_x) || in_array($j, $possible_y))) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if ($z == $pom_z && (in_array($i, $possible_x) || in_array($j, $possible_y))) {
                        $pop[$i][$j][$z] = array_shift($used);;
                    }
                }
            }
        }
        return $pop;
    }

    private function shuffleMaxBorder_LayerZ_width_4($pop, $nr = 10)
    {
        $pom_z = rand(0, $nr - 1);

        $possible_x = [];
        $possible_y = [];

        for ($i = 0; $i < 4; $i++) {
            $possible_x[] = $i;
            $possible_y[] = $i;
            $possible_x[] = $nr - $i - 1;
            $possible_y[] = $nr - $i - 1;
        }


        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if ($z == $pom_z && (in_array($i, $possible_x) || in_array($j, $possible_y))) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if ($z == $pom_z && (in_array($i, $possible_x) || in_array($j, $possible_y))) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }


    private function shuffleMaxBorder_LayerZ_width_3_123($pop, $nr = 10)
    {
        $pom_z = rand(0, $nr - 1);

        $possible_x = [1, 2, 3, 6, 7, 8];
        $possible_y = $possible_x;

        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if ($z == $pom_z && (in_array($i, $possible_x) || in_array($j, $possible_y))) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if ($z == $pom_z && (in_array($i, $possible_x) || in_array($j, $possible_y))) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }


    private function shuffleMaxBorder_LayerZ_width_2_12($pop, $nr = 10)
    {
        $pom_z = rand(0, $nr - 1);

        $possible_x = [1, 2, 7, 8];
        $possible_y = $possible_x;

        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if ($z == $pom_z && (in_array($i, $possible_x) || in_array($j, $possible_y))) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if ($z == $pom_z && (in_array($i, $possible_x) || in_array($j, $possible_y))) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function shuffleMaxBorder_LayerZ_width_2_23($pop, $nr = 10)
    {
        $pom_z = rand(0, $nr - 1);

        $possible_x = [2, 3, 6, 7];
        $possible_y = $possible_x;

        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if ($z == $pom_z && (in_array($i, $possible_x) || in_array($j, $possible_y))) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if ($z == $pom_z && (in_array($i, $possible_x) || in_array($j, $possible_y))) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function shuffleMaxBorder_LayerZ_width_2_13($pop, $nr = 10)
    {
        $pom_z = rand(0, $nr - 1);

        $possible_x = [1, 8, 3, 6];
        $possible_y = $possible_x;

        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if ($z == $pom_z && (in_array($i, $possible_x) || in_array($j, $possible_y))) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if ($z == $pom_z && (in_array($i, $possible_x) || in_array($j, $possible_y))) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function shuffleMaxBorder_LayerZ_width_2_03($pop, $nr = 10)
    {
        $pom_z = rand(0, $nr - 1);

        $possible_x = [0, 9, 3, 6];
        $possible_y = $possible_x;

        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if ($z == $pom_z && (in_array($i, $possible_x) || in_array($j, $possible_y))) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if ($z == $pom_z && (in_array($i, $possible_x) || in_array($j, $possible_y))) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function shufflesquereBorderOneLayerZ($pop, $nr = 10)
    {
        $pom_x1 = rand(0, $nr - 3);
        $pom_x2 = rand($pom_x1 + 2, $nr - 1);
        $pom_y1 = rand(0, $nr - 3);
        $pom_y2 = rand($pom_y1 + 2, $nr - 1);
        $pom_z = rand(0, $nr - 1);

        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if (
                        $z == $pom_z &&
                        ((($i == $pom_x1 || $i == $pom_x2) && ($j >= $pom_y1 && $j <= $pom_y2)) ||
                            (($j == $pom_y1 || $j == $pom_y2) && ($i >= $pom_x1 && $i <= $pom_x2))
                        )
                    ) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if (
                        $z == $pom_z &&
                        ((($i == $pom_x1 || $i == $pom_x2) && ($j >= $pom_y1 && $j <= $pom_y2)) ||
                            (($j == $pom_y1 || $j == $pom_y2) && ($i >= $pom_x1 && $i <= $pom_x2))
                        )
                    ) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function shufflesquereBorderOneLayerZ_width2($pop, $nr = 10)
    {
        $pom_x1 = rand(0, $nr - 3);
        $pom_x2 = rand($pom_x1 + 2, $nr - 1);
        $pom_y1 = rand(0, $nr - 3);
        $pom_y2 = rand($pom_y1 + 2, $nr - 1);
        $pom_z = rand(0, $nr - 1);

        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if (
                        $z == $pom_z &&
                        ((($i == $pom_x1 || $i == $pom_x2 || $i == $pom_x1 - 1 || $i == $pom_x2 + 1) && ($j >= $pom_y1 - 1 && $j <= $pom_y2 + 1)) ||
                            (($j == $pom_y1 || $j == $pom_y2 || $j == $pom_y1 - 1 || $j == $pom_y2 + 1) && ($i >= $pom_x1 - 1 && $i <= $pom_x2 + 1))
                        )
                    ) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if (
                        $z == $pom_z &&
                        ((($i == $pom_x1 || $i == $pom_x2 || $i == $pom_x1 - 1 || $i == $pom_x2 + 1) && ($j >= $pom_y1 - 1 && $j <= $pom_y2 + 1)) ||
                            (($j == $pom_y1 || $j == $pom_y2 || $j == $pom_y1 - 1 || $j == $pom_y2 + 1) && ($i >= $pom_x1 - 1 && $i <= $pom_x2 + 1))
                        )
                    ) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function shufflesquereBorderOneLayerZMultiple($pop, $nr = 10)
    {

        $many = rand(2, 10);
        for ($i = 0; $i < $many; $i++) {
            $pop = $this->shufflesquereBorderOneLayerZ($pop, $nr);
        }
        return $pop;
    }

    private function shuffleMaxBorder_LayerZ_width_2Multiple($pop, $nr = 10)
    {
        $methods = [
            "shuffleMaxBorder_LayerZ_width_1",
            "shuffleMaxBorder_LayerZ_width_2_12",
            "shuffleMaxBorder_LayerZ_width_2",
            "shuffleMaxBorder_LayerZ_width_2_23",
            "shufflesquereBorderOneLayerZ_width2",
            "shuffleMaxBorder_LayerZ_width_2_03"
        ];
        $many = rand(2, 10);
        for ($i = 0; $i < $many; $i++) {
            $m = $methods[rand(0, count($methods) - 1)];
            $pop = $this->$m($pop, $nr);
        }
        return $pop;
    }

    private function shuffleonMatrixPower10($pop, $nr = 10)
    {
        return $this->shuffleonMatrixPower($pop, $nr, 1);
    }

    private function shuffleonMatrixPower20($pop, $nr = 10)
    {
        return $this->shuffleonMatrixPower($pop, $nr, 2);
    }

    private function shuffleonMatrixPower50($pop, $nr = 10)
    {
        return $this->shuffleonMatrixPower($pop, $nr, 3);
    }

    private function shuffleonMatrixPower100($pop, $nr = 10)
    {
        return $this->shuffleonMatrixPower($pop, $nr, 4);
    }

    private function shuffleonMatrixPower30($pop, $nr = 10)
    {
        return $this->shuffleonMatrixPower($pop, $nr, 5);
    }

    private function shuffleonMatrixPower200($pop, $nr = 10)
    {
        return $this->shuffleonMatrixPower($pop, $nr, 6);
    }

    private function shuffleonMatrixPower10Multi($pop, $nr = 10)
    {
        $xn = rand(2, 8);
        for ($l = 0; $l < $xn; $l++) {
            $pop = $this->shuffleonMatrixPower($pop, $nr, 1);
        }
        return $pop;
    }

    private function shuffleonMatrixPower20Multi($pop, $nr = 10)
    {
        $xn = rand(2, 8);
        for ($l = 0; $l < $xn; $l++) {
            $pop = $this->shuffleonMatrixPower($pop, $nr, 2);
        }
        return $pop;
    }

    private function shuffleonMatrixPower($pop, $nr = 10, $trybe = 1, $howshuffle = 1)
    {

        $orders = $this->getOrders($nr);
        if (!$orders) {
            return $pop;
        }

        $size = 2;
        $place = rand(0, count($orders) - 1);
        switch ($trybe) {
            case 1:
                $size = rand(5, 10);
                break;
            case 2:
                $size = rand(10, 20);
                break;
            case 3:
                $size = rand(20, 50);
                break;
            case 4:
                $size = rand(50, 100);
                break;
            case 5:
                $size = rand(20, 30);
                break;
            case 6:
                $size = rand(100, 200);
                break;
        }

        $keys = $this->getSliceOrders($orders, $place, $size);
        $used = [];
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $key = $i . "-" . $j . "-" . $z;
                    if (in_array($key, $keys)) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }

        if (count($used) < 3) {
            $howshuffle = 1;
        }

        switch ($howshuffle) {
            case 1:
                shuffle($used);
                break;
            case 2:
                sort($used);
                break;
            case 3:
                rsort($used);
                break;
            case 4:
                $diff = array_chunk($used, ceil(count($used) / 2));
                sort($diff[0]);
                rsort($diff[1]);
                $used = array_merge($diff[0], $diff[1]);
                break;
            case 5:
                $diff = array_chunk($used, ceil(count($used) / 2));
                rsort($diff[0]);
                sort($diff[1]);
                $used = array_merge($diff[0], $diff[1]);
                break;
        }


        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $key = $i . "-" . $j . "-" . $z;
                    if (in_array($key, $keys)) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }

        return $pop;
    }

    private function getSliceOrders($orders, $place, $size)
    {

        $keys = [];
        $i = 0;
        foreach ($orders as $key => $value) {
            if ($i >= $place && $i <= $place + $size) {
                $keys[] = $key;
            }
            $i++;
        }
        return $keys;
    }

    private function getOrders($size = 10)
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


    public function getAllMethod()
    {
        return $this->mutationList;
    }

    public function changeMutationList($methods)
    {
        $this->mutationList = $methods;
    }

    public function setNrMutation($nr)
    {
        $this->nrmutation = $nr;
    }

    private function isNotDiffer($used)
    {
        $res = 1;
        $c = count($used);
        if ($c == 0) {
            return $res;
        }
        $val = $used[0];

        for ($i = 0; $i < $c; $i++) {
            if ($used[$i] != $val) {
                $res = 0;
                break;
            }
        }
        return $res;
    }

    private function shufflerytal3($pop, $nr = 10)
    {
        $pom_x = rand(0, $nr - 1);
        $pom_y = rand(0, $nr - 1);
        $pom_z = rand(0, $nr - 1);

        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = abs($i - $pom_x) + abs($j - $pom_y) + abs($z - $pom_z);

                    if ($sum <= 3) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = abs($i - $pom_x) + abs($j - $pom_y) + abs($z - $pom_z);

                    if ($sum <= 3) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function shufflerytal2($pop, $nr = 10)
    {
        $pom_x = rand(0, $nr - 1);
        $pom_y = rand(0, $nr - 1);
        $pom_z = rand(0, $nr - 1);

        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = abs($i - $pom_x) + abs($j - $pom_y) + abs($z - $pom_z);

                    if ($sum <= 2) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = abs($i - $pom_x) + abs($j - $pom_y) + abs($z - $pom_z);

                    if ($sum <= 2) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function shufflerytal4($pop, $nr = 10)
    {
        $pom_x = rand(0, $nr - 1);
        $pom_y = rand(0, $nr - 1);
        $pom_z = rand(0, $nr - 1);

        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = abs($i - $pom_x) + abs($j - $pom_y) + abs($z - $pom_z);

                    if ($sum <= 4) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = abs($i - $pom_x) + abs($j - $pom_y) + abs($z - $pom_z);

                    if ($sum <= 4) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function shufflerytal5($pop, $nr = 10)
    {
        $pom_x = rand(0, $nr - 1);
        $pom_y = rand(0, $nr - 1);
        $pom_z = rand(0, $nr - 1);

        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = abs($i - $pom_x) + abs($j - $pom_y) + abs($z - $pom_z);

                    if ($sum <= 5) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = abs($i - $pom_x) + abs($j - $pom_y) + abs($z - $pom_z);

                    if ($sum <= 5) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }


    private function rombono4_inZ($pop, $nr = 10)
    {
        $pom_x = rand(0, $nr - 1);
        $pom_y = rand(0, $nr - 1);
        $pom_z1 = rand(0, $nr - 2);
        $pom_z2 = rand($pom_z1, $nr - 1);

        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = abs($i - $pom_x) + abs($j - $pom_y);

                    if ($sum <= 4 && $z >= $pom_z1 && $z <= $pom_z2) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = abs($i - $pom_x) + abs($j - $pom_y);

                    if ($sum <= 4 && $z >= $pom_z1 && $z <= $pom_z2) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }


    private function rombono3_inZ($pop, $nr = 10)
    {
        $pom_x = rand(0, $nr - 1);
        $pom_y = rand(0, $nr - 1);
        $pom_z1 = rand(0, $nr - 2);
        $pom_z2 = rand($pom_z1, $nr - 1);

        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = abs($i - $pom_x) + abs($j - $pom_y);

                    if ($sum <= 3 && $z >= $pom_z1 && $z <= $pom_z2) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = abs($i - $pom_x) + abs($j - $pom_y);

                    if ($sum <= 3 && $z >= $pom_z1 && $z <= $pom_z2) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function rombono2_inZ($pop, $nr = 10)
    {
        $pom_x = rand(0, $nr - 1);
        $pom_y = rand(0, $nr - 1);
        $pom_z1 = rand(0, $nr - 2);
        $pom_z2 = rand($pom_z1, $nr - 1);

        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = abs($i - $pom_x) + abs($j - $pom_y);

                    if ($sum <= 2 && $z >= $pom_z1 && $z <= $pom_z2) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = abs($i - $pom_x) + abs($j - $pom_y);

                    if ($sum <= 2 && $z >= $pom_z1 && $z <= $pom_z2) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function shuffleonMatrixPower20_left($pop, $nr = 10)
    {
        return $this->shuffleonMatrixPower($pop, $nr, 2, 2);
    }

    private function shuffleonMatrixPower20_right($pop, $nr = 10)
    {
        return $this->shuffleonMatrixPower($pop, $nr, 2, 3);
    }

    private function shuffleonMatrixPower20_middle($pop, $nr = 10)
    {
        return $this->shuffleonMatrixPower($pop, $nr, 2, 4);
    }

    private function shuffleonMatrixPower20_toborder($pop, $nr = 10)
    {
        return $this->shuffleonMatrixPower($pop, $nr, 2, 5);
    }

    private function shuffleonMatrixPower50_left($pop, $nr = 10)
    {
        return $this->shuffleonMatrixPower($pop, $nr, 3, 2);
    }

    private function shuffleonMatrixPower50_right($pop, $nr = 10)
    {
        return $this->shuffleonMatrixPower($pop, $nr, 3, 3);
    }

    private function shuffleonMatrixPower50_middle($pop, $nr = 10)
    {
        return $this->shuffleonMatrixPower($pop, $nr, 3, 4);
    }

    private function shuffleonMatrixPower50_toborder($pop, $nr = 10)
    {
        return $this->shuffleonMatrixPower($pop, $nr, 3, 5);
    }

    private function shuffleonMatrixPower100_left($pop, $nr = 10)
    {
        return $this->shuffleonMatrixPower($pop, $nr, 4, 2);
    }

    private function shuffleonMatrixPower100_right($pop, $nr = 10)
    {
        return $this->shuffleonMatrixPower($pop, $nr, 4, 3);
    }

    private function shuffleonMatrixPower100_middle($pop, $nr = 10)
    {
        return $this->shuffleonMatrixPower($pop, $nr, 4, 4);
    }

    private function shuffleonMatrixPower100_toborder($pop, $nr = 10)
    {
        return $this->shuffleonMatrixPower($pop, $nr, 4, 5);
    }

    private function liftUp($pop, $nr = 10)
    {

        $change = 0;
        $i = 0;
        while ($change == 0 && $i < 100) {
            $x = rand(0, $nr - 1);
            $y = rand(0, $nr - 1);
            $z = rand(1, $nr - 1);
            if ($pop[$x][$y][$z] == 1 && $pop[$x][$y][$z - 1] == 0) {
                $pop[$x][$y][$z] = 0;
                $pop[$x][$y][$z - 1] = 1;
                $change = 1;
            }
            $i++;
        }
        return $pop;
    }

    private function liftUp5($pop, $nr = 10)
    {
        for ($i = 0; $i < 5; $i++) {
            $pop = $this->liftUp($pop, $nr);
        }
        return $pop;
    }

    private function liftUp2($pop, $nr = 10)
    {
        for ($i = 0; $i < 2; $i++) {
            $pop = $this->liftUp($pop, $nr);
        }
        return $pop;
    }

    private function liftUp10($pop, $nr = 10)
    {
        for ($i = 0; $i < 10; $i++) {
            $pop = $this->liftUp($pop, $nr);
        }
        return $pop;
    }

    private function liftUp20($pop, $nr = 10)
    {
        for ($i = 0; $i < 20; $i++) {
            $pop = $this->liftUp($pop, $nr);
        }
        return $pop;
    }

    private function liftDown($pop, $nr = 10)
    {

        $change = 0;
        $i = 0;
        while ($change == 0 && $i < 100) {
            $x = rand(0, $nr - 1);
            $y = rand(0, $nr - 1);
            $z = rand(0, $nr - 2);
            if ($pop[$x][$y][$z] == 1 && $pop[$x][$y][$z + 1] == 0) {
                $pop[$x][$y][$z] = 0;
                $pop[$x][$y][$z + 1] = 1;
                $change = 1;
            }
            $i++;
        }
        return $pop;
    }

    private function liftDown5($pop, $nr = 10)
    {
        for ($i = 0; $i < 5; $i++) {
            $pop = $this->liftDown($pop, $nr);
        }
        return $pop;
    }

    private function liftDown10($pop, $nr = 10)
    {
        for ($i = 0; $i < 10; $i++) {
            $pop = $this->liftDown($pop, $nr);
        }
        return $pop;
    }

    private function liftDown20($pop, $nr = 10)
    {
        for ($i = 0; $i < 20; $i++) {
            $pop = $this->liftDown($pop, $nr);
        }
        return $pop;
    }

    private function liftDown2($pop, $nr = 10)
    {
        for ($i = 0; $i < 2; $i++) {
            $pop = $this->liftDown($pop, $nr);
        }
        return $pop;
    }

    private function liftDown10Up10($pop, $nr = 10)
    {
        $pop = $this->liftDown10($pop, $nr);
        $pop = $this->liftUp10($pop, $nr);
        return $pop;
    }

    private function liftDown2Up2($pop, $nr = 10)
    {
        $pop = $this->liftDown2($pop, $nr);
        $pop = $this->liftUp2($pop, $nr);
        return $pop;
    }

    private function liftBigDown($pop, $nr = 10)
    {

        $change = 0;
        $i = 0;
        while ($change == 0 && $i < 100) {
            $x = rand(0, $nr - 1);
            $y = rand(0, $nr - 1);
            $z = rand(0, $nr - 3);
            if ($pop[$x][$y][$z] == 1 && $pop[$x][$y][$z + 2] == 0) {
                $pop[$x][$y][$z] = 0;
                $pop[$x][$y][$z + 2] = 1;
                $change = 1;
            }
            $i++;
        }
        return $pop;
    }

    private function liftBigUp($pop, $nr = 10)
    {

        $change = 0;
        $i = 0;
        while ($change == 0 && $i < 100) {
            $x = rand(0, $nr - 1);
            $y = rand(0, $nr - 1);
            $z = rand(2, $nr - 1);
            if ($pop[$x][$y][$z] == 1 && $pop[$x][$y][$z - 2] == 0) {
                $pop[$x][$y][$z] = 0;
                $pop[$x][$y][$z - 2] = 1;
                $change = 1;
            }
            $i++;
        }
        return $pop;
    }

    private function checSameArray($used)
    {
        if (count($used) == 0) {
            return 0;
        }
        $res = 1;
        $val = $used[0];
        for ($i = 0; $i < count($used); $i++) {
            if ($val != $used[$i]) {
                $res = 0;
                break;
            }
        }
        return $res;
    }

    private function shufflecolumnXZgo5($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $pom3 = rand(0, 4);
        $used = [];

        $isthesame = 1;
        $des = 100;
        while ($isthesame && $des > 0) {
            $used = [];
            for ($i = 0; $i < $nr; $i++) {
                for ($j = 0; $j < $nr; $j++) {
                    for ($z = 0; $z < $nr; $z++) {
                        if ($i == $pom1 && $z == $pom2 && ($pom3 < $j && $pom3 + 5 >= $j)) {
                            $used[] = $pop[$i][$j][$z];
                        }
                    }
                }
            }
            $des--;
            $isthesame = $this->checSameArray($used);
        }
        $old = $used;
        $des = 10;
        shuffle($used);
        while ($old == $used && $des > 0) {
            shuffle($used);
            $des--;
        }

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i == $pom1 && $z == $pom2 && ($pom3 < $j && $pom3 + 5 >= $j)) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function partcolumnXZgo5($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 1);
        $pom2 = rand(0, $nr - 1);
        $pom3 = rand(0, 4);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i == $pom1 && $z == $pom2 && ($pom3 < $j && $pom3 + 5 >= $j)) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }

        $diff = array_chunk($used, 3);
        rsort($diff[0]);
        sort($diff[1]);
        $used = array_merge($diff[0], $diff[1]);

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($i == $pom1 && $z == $pom2 && ($pom3 < $j && $pom3 + 5 >= $j)) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function checkNumbers($pomZ, $pomZ2)
    {
        if ($pomZ == $pomZ2) {
            if ($pomZ2 == 0) {
                $pomZ2 = 1;
            } else {
                $pomZ2--;
            }
        }
        return $pomZ2;
    }

    private function replaceSquere3x3($pop, $nr = 10)
    {

        $pom1 = rand(0, $nr - 3);
        $pom2 = rand(0, $nr - 3);
        $pomZ = rand(0, $nr - 1);
        $pomZ2 = rand(0, $nr - 1);
        $pomZ2 = $this->checkNumbers($pomZ, $pomZ2);


        for ($x = 0; $x <= 2; $x++) {
            for ($y = 0; $y <= 2; $y++) {
                $pom = $pop[$pom1 + $x][$pom2 + $y][$pomZ];
                $pop[$pom1 + $x][$pom2 + $y][$pomZ] = $pop[$pom1 + $x][$pom2 + $y][$pomZ2];
                $pop[$pom1 + $x][$pom2 + $y][$pomZ2] = $pom;
            }
        }

        return $pop;
    }

    private function replaceSquere4x4($pop, $nr = 10)
    {

        $pom1 = rand(0, $nr - 4);
        $pom2 = rand(0, $nr - 4);
        $pomZ = rand(0, $nr - 1);
        $pomZ2 = rand(0, $nr - 1);
        $pomZ2 = $this->checkNumbers($pomZ, $pomZ2);

        for ($x = 0; $x <= 3; $x++) {
            for ($y = 0; $y <= 3; $y++) {
                $pom = $pop[$pom1 + $x][$pom2 + $y][$pomZ];
                $pop[$pom1 + $x][$pom2 + $y][$pomZ] = $pop[$pom1 + $x][$pom2 + $y][$pomZ2];
                $pop[$pom1 + $x][$pom2 + $y][$pomZ2] = $pom;
            }
        }

        return $pop;
    }

    private function replaceSquere2x2($pop, $nr = 10)
    {

        $pom1 = rand(0, $nr - 2);
        $pom2 = rand(0, $nr - 2);
        $pomZ = rand(0, $nr - 1);
        $pomZ2 = rand(0, $nr - 1);
        $pomZ2 = $this->checkNumbers($pomZ, $pomZ2);

        for ($x = 0; $x <= 1; $x++) {
            for ($y = 0; $y <= 1; $y++) {
                $pom = $pop[$pom1 + $x][$pom2 + $y][$pomZ];
                $pop[$pom1 + $x][$pom2 + $y][$pomZ] = $pop[$pom1 + $x][$pom2 + $y][$pomZ2];
                $pop[$pom1 + $x][$pom2 + $y][$pomZ2] = $pom;
            }
        }

        return $pop;
    }

    private function replaceSquere5x5($pop, $nr = 10)
    {

        $pom1 = rand(0, $nr - 5);
        $pom2 = rand(0, $nr - 5);
        $pomZ = rand(0, $nr - 1);
        $pomZ2 = rand(0, $nr - 1);
        $pomZ2 = $this->checkNumbers($pomZ, $pomZ2);

        for ($x = 0; $x <= 4; $x++) {
            for ($y = 0; $y <= 4; $y++) {
                $pom = $pop[$pom1 + $x][$pom2 + $y][$pomZ];
                $pop[$pom1 + $x][$pom2 + $y][$pomZ] = $pop[$pom1 + $x][$pom2 + $y][$pomZ2];
                $pop[$pom1 + $x][$pom2 + $y][$pomZ2] = $pom;
            }
        }

        return $pop;
    }

    private function replaceSquere5x5Random($pop, $nr = 10)
    {

        $pom1 = rand(0, $nr - 5);
        $pom2 = rand(0, $nr - 5);
        $pomZ = rand(0, $nr - 1);
        $pomZ2 = rand(0, $nr - 1);
        $pomZ2 = $this->checkNumbers($pomZ, $pomZ2);

        for ($x = 0; $x <= 4; $x++) {
            for ($y = 0; $y <= 4; $y++) {
                $r = rand(0, 1);
                if ($r == 0) {
                    continue;
                }
                $pom = $pop[$pom1 + $x][$pom2 + $y][$pomZ];
                $pop[$pom1 + $x][$pom2 + $y][$pomZ] = $pop[$pom1 + $x][$pom2 + $y][$pomZ2];
                $pop[$pom1 + $x][$pom2 + $y][$pomZ2] = $pom;
            }
        }

        return $pop;
    }

    private function replaceSquere4x4Random($pop, $nr = 10)
    {

        $pom1 = rand(0, $nr - 4);
        $pom2 = rand(0, $nr - 4);
        $pomZ = rand(0, $nr - 1);
        $pomZ2 = rand(0, $nr - 1);
        $pomZ2 = $this->checkNumbers($pomZ, $pomZ2);

        for ($x = 0; $x <= 3; $x++) {
            for ($y = 0; $y <= 3; $y++) {
                $r = rand(0, 1);
                if ($r == 0) {
                    continue;
                }
                $pom = $pop[$pom1 + $x][$pom2 + $y][$pomZ];
                $pop[$pom1 + $x][$pom2 + $y][$pomZ] = $pop[$pom1 + $x][$pom2 + $y][$pomZ2];
                $pop[$pom1 + $x][$pom2 + $y][$pomZ2] = $pom;
            }
        }

        return $pop;
    }

    private function replaceSquere3x3Random($pop, $nr = 10)
    {

        $pom1 = rand(0, $nr - 3);
        $pom2 = rand(0, $nr - 3);
        $pomZ = rand(0, $nr - 1);
        $pomZ2 = rand(0, $nr - 1);
        $pomZ2 = $this->checkNumbers($pomZ, $pomZ2);

        for ($x = 0; $x <= 2; $x++) {
            for ($y = 0; $y <= 2; $y++) {
                $r = rand(0, 1);
                if ($r == 0) {
                    continue;
                }
                $pom = $pop[$pom1 + $x][$pom2 + $y][$pomZ];
                $pop[$pom1 + $x][$pom2 + $y][$pomZ] = $pop[$pom1 + $x][$pom2 + $y][$pomZ2];
                $pop[$pom1 + $x][$pom2 + $y][$pomZ2] = $pom;
            }
        }

        return $pop;
    }

    private function replaceSquere6x6Random($pop, $nr = 10)
    {

        $pom1 = rand(0, $nr - 6);
        $pom2 = rand(0, $nr - 6);
        $pomZ = rand(0, $nr - 1);
        $pomZ2 = rand(0, $nr - 1);
        $pomZ2 = $this->checkNumbers($pomZ, $pomZ2);

        for ($x = 0; $x <= 5; $x++) {
            for ($y = 0; $y <= 5; $y++) {
                $r = rand(0, 1);
                if ($r == 0) {
                    continue;
                }
                $pom = $pop[$pom1 + $x][$pom2 + $y][$pomZ];
                $pop[$pom1 + $x][$pom2 + $y][$pomZ] = $pop[$pom1 + $x][$pom2 + $y][$pomZ2];
                $pop[$pom1 + $x][$pom2 + $y][$pomZ2] = $pom;
            }
        }

        return $pop;
    }

    private function replaceSquere6x6($pop, $nr = 10)
    {

        $pom1 = rand(0, $nr - 6);
        $pom2 = rand(0, $nr - 6);
        $pomZ = rand(0, $nr - 1);
        $pomZ2 = rand(0, $nr - 1);
        $pomZ2 = $this->checkNumbers($pomZ, $pomZ2);

        for ($x = 0; $x <= 5; $x++) {
            for ($y = 0; $y <= 5; $y++) {
                $pom = $pop[$pom1 + $x][$pom2 + $y][$pomZ];
                $pop[$pom1 + $x][$pom2 + $y][$pomZ] = $pop[$pom1 + $x][$pom2 + $y][$pomZ2];
                $pop[$pom1 + $x][$pom2 + $y][$pomZ2] = $pom;
            }
        }

        return $pop;
    }

    private function replaceSquere7x7($pop, $nr = 10)
    {

        $pom1 = rand(0, $nr - 7);
        $pom2 = rand(0, $nr - 7);
        $pomZ = rand(0, $nr - 1);
        $pomZ2 = rand(0, $nr - 1);
        $pomZ2 = $this->checkNumbers($pomZ, $pomZ2);

        for ($x = 0; $x <= 6; $x++) {
            for ($y = 0; $y <= 6; $y++) {
                $pom = $pop[$pom1 + $x][$pom2 + $y][$pomZ];
                $pop[$pom1 + $x][$pom2 + $y][$pomZ] = $pop[$pom1 + $x][$pom2 + $y][$pomZ2];
                $pop[$pom1 + $x][$pom2 + $y][$pomZ2] = $pom;
            }
        }

        return $pop;
    }

    private function replaceSquere7x7Random($pop, $nr = 10)
    {

        $pom1 = rand(0, $nr - 7);
        $pom2 = rand(0, $nr - 7);
        $pomZ = rand(0, $nr - 1);
        $pomZ2 = rand(0, $nr - 1);
        $pomZ2 = $this->checkNumbers($pomZ, $pomZ2);

        for ($x = 0; $x <= 6; $x++) {
            for ($y = 0; $y <= 6; $y++) {
                $r = rand(0, 1);
                if ($r == 0) {
                    continue;
                }
                $pom = $pop[$pom1 + $x][$pom2 + $y][$pomZ];
                $pop[$pom1 + $x][$pom2 + $y][$pomZ] = $pop[$pom1 + $x][$pom2 + $y][$pomZ2];
                $pop[$pom1 + $x][$pom2 + $y][$pomZ2] = $pom;
            }
        }

        return $pop;
    }

    private function replaceRectangle($pop, $nr = 10)
    {

        $pomx1 = rand(0, $nr - 2);
        $pomx2 = rand($pomx1 + 1, $nr - 1);
        $pomy1 = rand(0, $nr - 2);
        $pomy2 = rand($pomy1, $nr - 1);
        $pomZ = rand(0, $nr - 1);
        $pomZ2 = rand(0, $nr - 1);
        $pomZ2 = $this->checkNumbers($pomZ, $pomZ2);

        for ($x = $pomx1; $x <= $pomx2; $x++) {
            for ($y = $pomy1; $y <= $pomy2; $y++) {
                $pom = $pop[$x][$y][$pomZ];
                $pop[$x][$y][$pomZ] = $pop[$x][$y][$pomZ2];
                $pop[$x][$y][$pomZ2] = $pom;
            }
        }

        return $pop;
    }

    private function replaceRectangleRandom($pop, $nr = 10)
    {

        $pomx1 = rand(0, $nr - 2);
        $pomx2 = rand($pomx1 + 1, $nr - 1);
        $pomy1 = rand(0, $nr - 2);
        $pomy2 = rand($pomy1, $nr - 1);
        $pomZ = rand(0, $nr - 1);
        $pomZ2 = rand(0, $nr - 1);
        $pomZ2 = $this->checkNumbers($pomZ, $pomZ2);

        for ($x = $pomx1; $x <= $pomx2; $x++) {
            for ($y = $pomy1; $y <= $pomy2; $y++) {
                $r = rand(0, 1);
                if ($r == 0) {
                    continue;
                }
                $pom = $pop[$x][$y][$pomZ];
                $pop[$x][$y][$pomZ] = $pop[$x][$y][$pomZ2];
                $pop[$x][$y][$pomZ2] = $pom;
            }
        }

        return $pop;
    }

    private function replaceSquere8x8($pop, $nr = 10)
    {

        $pom1 = rand(0, $nr - 8);
        $pom2 = rand(0, $nr - 8);
        $pomZ = rand(0, $nr - 1);
        $pomZ2 = rand(0, $nr - 1);
        $pomZ2 = $this->checkNumbers($pomZ, $pomZ2);

        for ($x = 0; $x <= 7; $x++) {
            for ($y = 0; $y <= 7; $y++) {
                $pom = $pop[$pom1 + $x][$pom2 + $y][$pomZ];
                $pop[$pom1 + $x][$pom2 + $y][$pomZ] = $pop[$pom1 + $x][$pom2 + $y][$pomZ2];
                $pop[$pom1 + $x][$pom2 + $y][$pomZ2] = $pom;
            }
        }

        return $pop;
    }

    private function replaceSquere8x8Random($pop, $nr = 10)
    {

        $pom1 = rand(0, $nr - 8);
        $pom2 = rand(0, $nr - 8);
        $pomZ = rand(0, $nr - 1);
        $pomZ2 = rand(0, $nr - 1);
        $pomZ2 = $this->checkNumbers($pomZ, $pomZ2);

        for ($x = 0; $x <= 7; $x++) {
            for ($y = 0; $y <= 7; $y++) {
                $r = rand(0, 1);
                if ($r == 0) {
                    continue;
                }
                $pom = $pop[$pom1 + $x][$pom2 + $y][$pomZ];
                $pop[$pom1 + $x][$pom2 + $y][$pomZ] = $pop[$pom1 + $x][$pom2 + $y][$pomZ2];
                $pop[$pom1 + $x][$pom2 + $y][$pomZ2] = $pom;
            }
        }

        return $pop;
    }

    private function replaceSquere9x9($pop, $nr = 10)
    {

        $pom1 = rand(0, $nr - 9);
        $pom2 = rand(0, $nr - 9);
        $pomZ = rand(0, $nr - 1);
        $pomZ2 = rand(0, $nr - 1);
        $pomZ2 = $this->checkNumbers($pomZ, $pomZ2);

        for ($x = 0; $x <= 8; $x++) {
            for ($y = 0; $y <= 8; $y++) {
                $pom = $pop[$pom1 + $x][$pom2 + $y][$pomZ];
                $pop[$pom1 + $x][$pom2 + $y][$pomZ] = $pop[$pom1 + $x][$pom2 + $y][$pomZ2];
                $pop[$pom1 + $x][$pom2 + $y][$pomZ2] = $pom;
            }
        }

        return $pop;
    }

    private function replaceSquere9x9Random($pop, $nr = 10)
    {

        $pom1 = rand(0, $nr - 9);
        $pom2 = rand(0, $nr - 9);
        $pomZ = rand(0, $nr - 1);
        $pomZ2 = rand(0, $nr - 1);
        $pomZ2 = $this->checkNumbers($pomZ, $pomZ2);

        for ($x = 0; $x <= 8; $x++) {
            for ($y = 0; $y <= 8; $y++) {
                $r = rand(0, 1);
                if ($r == 0) {
                    continue;
                }
                $pom = $pop[$pom1 + $x][$pom2 + $y][$pomZ];
                $pop[$pom1 + $x][$pom2 + $y][$pomZ] = $pop[$pom1 + $x][$pom2 + $y][$pomZ2];
                $pop[$pom1 + $x][$pom2 + $y][$pomZ2] = $pom;
            }
        }

        return $pop;
    }

    private function replaceSquere10x10($pop, $nr = 10)
    {


        $pomZ = rand(0, $nr - 1);
        $pomZ2 = rand(0, $nr - 1);
        $pomZ2 = $this->checkNumbers($pomZ, $pomZ2);

        for ($x = 0; $x < $nr; $x++) {
            for ($y = 0; $y < $nr; $y++) {
                $pom = $pop[$x][$y][$pomZ];
                $pop[$x][$y][$pomZ] = $pop[$x][$y][$pomZ2];
                $pop[$x][$y][$pomZ2] = $pom;
            }
        }

        return $pop;
    }

    private function replaceSquere10x10Random2($pop, $nr = 10)
    {
        return $this->replaceSquere10x10Random($pop, $nr, 1);
    }

    private function replaceSquere10x10Random3($pop, $nr = 10)
    {
        return $this->replaceSquere10x10Random($pop, $nr, 2);
    }

    private function replaceSquere10x10Random4($pop, $nr = 10)
    {
        return $this->replaceSquere10x10Random($pop, $nr, 3);
    }

    private function replaceSquere10x10Random5($pop, $nr = 10)
    {
        return $this->replaceSquere10x10Random($pop, $nr, 4);
    }

    private function replaceSquere10x10Random6($pop, $nr = 10)
    {
        return $this->replaceSquere10x10Random($pop, $nr, 5);
    }


    private function replaceSquere10x10Random($pop, $nr = 10, $chance = 1)
    {


        $pomZ = rand(0, $nr - 1);
        $pomZ2 = rand(0, $nr - 1);
        $pomZ2 = $this->checkNumbers($pomZ, $pomZ2);

        for ($x = 0; $x < $nr; $x++) {
            for ($y = 0; $y < $nr; $y++) {
                $r = rand(0, $chance);
                if ($r == 0) {
                    continue;
                }
                $pom = $pop[$x][$y][$pomZ];
                $pop[$x][$y][$pomZ] = $pop[$x][$y][$pomZ2];
                $pop[$x][$y][$pomZ2] = $pom;
            }
        }

        return $pop;
    }

    private function shuffleSamePower($pop, $nr = 10)
    {

        $orders = $this->getOrders($nr);
        if (!$orders) {
            return $pop;
        }

        $isthesame = 1;
        $des = 100;
        $val = 0;
        while ($isthesame && $des > 0) {
            $used = [];
            $x = rand(0, $nr - 1);
            $y = rand(0, $nr - 1);
            $z = rand(0, $nr - 1);

            $val = $orders[$x . "-" . $y . "-" . $z];

            for ($i = 0; $i < $nr; $i++) {
                for ($j = 0; $j < $nr; $j++) {
                    for ($z = 0; $z < $nr; $z++) {

                        if ($orders[$x . "-" . $y . "-" . $z] == $val) {
                            $used[] = $pop[$i][$j][$z];
                        }
                    }
                }
            }
            $des--;
            $isthesame = $this->checSameArray($used);
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($orders[$i . "-" . $j . "-" . $z] == $val) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function shuffleSamePowerMulti($pop, $nr = 10)
    {
        $rand = rand(2, 3);
        for ($i = 0; $i < $rand; $i++) {
            $pop = $this->shuffleSamePower($pop, $nr);
        }
        return $pop;
    }

    private function mixingZLayersInRecatngle($pop, $nr = 10)
    {
        $pom1 = rand(0, $nr - 2);
        $used = [];

        $x1 = rand(0, $nr - 2);
        $x2 = rand($x1 + 1, $nr - 1);
        $y1 = rand(0, $nr - 2);
        $y2 = rand($y1 + 1, $nr - 1);

        for ($i = $x1; $i <= $x2; $i++) {
            for ($j = $y1; $j <= $y2; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($z == $pom1 || $z == $pom1 + 1) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = $x1; $i <= $x2; $i++) {
            for ($j = $y1; $j <= $y2; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($z == $pom1 || $z == $pom1 + 1) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }


    private function shuffleSamePowerWidth($pop, $nr = 10, $witdh = 0.2)
    {

        $orders = $this->getOrders($nr);
        if (!$orders) {
            return $pop;
        }

        $isthesame = 1;
        $des = 100;
        $val = 0;
        while ($isthesame && $des > 0) {
            $used = [];
            $x = rand(0, $nr - 1);
            $y = rand(0, $nr - 1);
            $z = rand(0, $nr - 1);

            $val = $orders[$x . "-" . $y . "-" . $z];

            for ($i = 0; $i < $nr; $i++) {
                for ($j = 0; $j < $nr; $j++) {
                    for ($z = 0; $z < $nr; $z++) {

                        if ($orders[$x . "-" . $y . "-" . $z] - $witdh <= $val && $orders[$x . "-" . $y . "-" . $z] + $witdh >= $val) {
                            $used[] = $pop[$i][$j][$z];
                        }
                    }
                }
            }
            $des--;
            $isthesame = $this->checSameArray($used);
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($orders[$i . "-" . $j . "-" . $z] - $witdh <= $val && $orders[$i . "-" . $j . "-" . $z] + $witdh >= $val) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function shuffleSamePowerWidth_10($pop, $nr = 10)
    {
        return $this->shuffleSamePowerWidth($pop, $nr, 0.1);
    }

    private function shuffleSamePowerWidth_50($pop, $nr = 10)
    {
        return $this->shuffleSamePowerWidth($pop, $nr, 0.5);
    }

    private function rombono3_inX($pop, $nr = 10)
    {
        $pom_x = rand(0, $nr - 1);
        $pom_y = rand(0, $nr - 1);
        $pom_z1 = rand(0, $nr - 2);
        $pom_z2 = rand($pom_z1, $nr - 1);

        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = abs($j - $pom_x) + abs($z - $pom_y);

                    if ($sum <= 3 && $i >= $pom_z1 && $i <= $pom_z2) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = abs($j - $pom_x) + abs($z - $pom_y);

                    if ($sum <= 3 && $i >= $pom_z1 && $i <= $pom_z2) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function rombono3_inY($pop, $nr = 10)
    {
        $pom_x = rand(0, $nr - 1);
        $pom_y = rand(0, $nr - 1);
        $pom_z1 = rand(0, $nr - 2);
        $pom_z2 = rand($pom_z1, $nr - 1);

        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = abs($i - $pom_x) + abs($z - $pom_y);

                    if ($sum <= 3 && $j >= $pom_z1 && $j <= $pom_z2) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = abs($i - $pom_x) + abs($z - $pom_y);

                    if ($sum <= 3 && $j >= $pom_z1 && $j <= $pom_z2) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function rombono2_inX($pop, $nr = 10)
    {
        $pom_x = rand(0, $nr - 1);
        $pom_y = rand(0, $nr - 1);
        $pom_z1 = rand(0, $nr - 2);
        $pom_z2 = rand($pom_z1, $nr - 1);

        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = abs($j - $pom_x) + abs($z - $pom_y);

                    if ($sum <= 2 && $i >= $pom_z1 && $i <= $pom_z2) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = abs($j - $pom_x) + abs($z - $pom_y);

                    if ($sum <= 2 && $i >= $pom_z1 && $i <= $pom_z2) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function replace3Squere5x5($pop, $nr = 10)
    {
        return $this->replace3Squere($pop, 5, $nr);
    }

    private function replace3Squere4x4($pop, $nr = 10)
    {
        return $this->replace3Squere($pop, 4, $nr);
    }

    private function replace3Squere3x3($pop, $nr = 10)
    {
        return $this->replace3Squere($pop, 3, $nr);
    }

    private function replace3Squere8x8($pop, $nr = 10)
    {
        return $this->replace3Squere($pop, 8, $nr);
    }

    private function replace3Squere10x10($pop, $nr = 10)
    {
        return $this->replace3Squere($pop, 10, $nr);
    }

    private function replace3Squere2x2($pop, $nr = 10)
    {
        return $this->replace3Squere($pop, 2, $nr);
    }

    private function replace3Squere2x2Multi($pop, $nr = 10)
    {
        $r = rand(2, 12);
        for ($i = 0; $i < $r; $i++) {
            $pop = $this->replace3Squere($pop, 2, $nr);
        }
        return $pop;
    }

    private function replace3Squere($pop, $size, $nr = 10)
    {
        $pom1 = rand(0, $nr - $size);
        $pom2 = rand(0, $nr - $size);
        $pomZ = rand(1, $nr - 2);

        for ($x = 0; $x <= $size - 1; $x++) {
            for ($y = 0; $y <= $size - 1; $y++) {

                $rand = rand(0, 1);

                $pomZ2 = $pomZ;
                if ($rand == 0) {
                    $pomZ2--;
                } else {
                    $pomZ2++;
                }

                $pom = $pop[$pom1 + $x][$pom2 + $y][$pomZ];
                $pop[$pom1 + $x][$pom2 + $y][$pomZ] = $pop[$pom1 + $x][$pom2 + $y][$pomZ2];
                $pop[$pom1 + $x][$pom2 + $y][$pomZ2] = $pom;
            }
        }

        return $pop;
    }

    private function change2PointsToMiddle($pop, $nr = 10)
    {
        $orders = $this->getOrders($nr);
        $sumPower = 0;
        $changed = 0;
        while ($changed < 2) {
            $x = rand(0, $nr - 1);
            $y = rand(0, $nr - 1);
            $z = rand(0, $nr - 1);
            if ($pop[$x][$y][$z] == 1) {
                $changed++;
                $pop[$x][$y][$z] = 0;
                $sumPower += $orders[$x . "-" . $y . "-" . $z];
            }
        }
        $search = ($sumPower / 2) * 0.8;
        $valuechange = 0;
        foreach ($orders as $klucz => $wartosc) {
            if ($wartosc < $search) {
                $dl = explode("-", $klucz);
                if ($pop[(int) $dl[0]][(int)  $dl[1]][(int)  $dl[2]] == 0) {
                    $valuechange = $wartosc;
                    $pop[$dl[0]][$dl[1]][$dl[2]] = 1;
                    break;
                }
            }
        }
        $search = $search - $valuechange;
        foreach ($orders as $klucz => $wartosc) {
            if ($wartosc < $search) {
                $dl = explode("-", $klucz);
                if ($pop[(int) $dl[0]][(int)  $dl[1]][(int)  $dl[2]] == 0) {
                    $pop[$dl[0]][$dl[1]][$dl[2]] = 1;
                    break;
                }
            }
        }

        return $pop;
    }

    private function diffPointson2Points($pop, $nr = 10)
    {
        $orders = $this->getOrders($nr);
        $sumPower = 0;
        $changed = 0;
        while ($changed < 1) {
            $x = rand(0, $nr - 1);
            $y = rand(0, $nr - 1);
            $z = rand(0, $nr - 1);
            if ($pop[$x][$y][$z] == 1) {
                $changed++;
                $pop[$x][$y][$z] = 0;
                $sumPower += $orders[$x . "-" . $y . "-" . $z];
            }
        }
        $search = ($sumPower / 2) * 0.8;
        $valuechange = 0;
        foreach ($orders as $klucz => $wartosc) {
            if ($wartosc < $search) {
                $dl = explode("-", $klucz);
                if ($pop[(int) $dl[0]][(int)  $dl[1]][(int)  $dl[2]] == 0) {
                    $valuechange = $wartosc;
                    $pop[$dl[0]][$dl[1]][$dl[2]] = 1;
                    break;
                }
            }
        }
        $search = $search - $valuechange;
        foreach ($orders as $klucz => $wartosc) {
            if ($wartosc < $search) {
                $dl = explode("-", $klucz);
                if ($pop[(int) $dl[0]][(int)  $dl[1]][(int)  $dl[2]] == 0) {
                    $pop[$dl[0]][$dl[1]][$dl[2]] = 1;
                    break;
                }
            }
        }

        return $pop;
    }

    private function join2Points($pop, $nr = 10)
    {
        $orders = $this->getOrders($nr);
        $sumPower = 0;
        $changed = 0;
        while ($changed < 2) {
            $x = rand(0, $nr - 1);
            $y = rand(0, $nr - 1);
            $z = rand(0, $nr - 1);
            if ($pop[$x][$y][$z] == 1) {
                $changed++;
                $pop[$x][$y][$z] = 0;
                $sumPower += $orders[$x . "-" . $y . "-" . $z];
            }
        }
        $search = $sumPower;
        foreach ($orders as $klucz => $wartosc) {
            if ($wartosc < $search) {
                $dl = explode("-", $klucz);
                if ($pop[(int) $dl[0]][(int)  $dl[1]][(int)  $dl[2]] == 0) {
                    $pop[$dl[0]][$dl[1]][$dl[2]] = 1;
                    break;
                }
            }
        }


        return $pop;
    }

    private function middleColumn($pop, $nr = 10)
    {

        $change = 0;
        $i = 0;
        while ($change == 0 && $i < 100) {
            $x = rand(0, $nr - 1);
            $y = rand(0, $nr - 1);
            $z = rand(2, $nr - 1);
            if ($pop[$x][$y][$z] == 0) {
                $pop[$x][$y][$z] = 1;
                $change = 1;
                $change2 = 0;
                $max = 50;
                while ($change2 == 0 && $max > 0) {
                    $xch = rand(-1, 1);
                    $ych = rand(-1, 1);
                    if (isset($pop[$x + $xch][$y + $ych][$z - 2]) && $pop[$x + $xch][$y + $ych][$z - 2] == 1) {
                        $change2 = 0;
                        $pop[$x + $xch][$y + $ych][$z - 2] = 0;
                    }
                    $max--;
                }
            }
            $i++;
        }
        return $pop;
    }

    private function middleColumnRevert($pop, $nr = 10)
    {

        $change = 0;
        $i = 0;
        while ($change == 0 && $i < 100) {
            $x = rand(0, $nr - 1);
            $y = rand(0, $nr - 1);
            $z = rand(2, $nr - 1);
            if ($pop[$x][$y][$z] == 1) {
                $pop[$x][$y][$z] = 0;
                $change = 1;
                $change2 = 0;
                $max = 50;
                while ($change2 == 0 && $max > 0) {
                    $xch = rand(-1, 1);
                    $ych = rand(-1, 1);
                    if (isset($pop[$x + $xch][$y + $ych][$z - 2]) && $pop[$x + $xch][$y + $ych][$z - 2] == 0) {
                        $change2 = 0;
                        $pop[$x + $xch][$y + $ych][$z - 2] = 1;
                    }
                    $max--;
                }
            }
            $i++;
        }
        return $pop;
    }

    private function midd2($pop, $nr = 10)
    {
        $pop = $this->middleColumn($pop, $nr);
        $pop = $this->middleColumnRevert($pop, $nr);
        return $pop;
    }

    private function layerInMiddle($pop, $nr = 10)
    {

        $pom = rand(1, $nr - 2);

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($z == $pom - 1 || $z == $pom + 1) {
                        $r = rand(0, 7);
                        if ($r == 1) {
                            $pop[$i][$j][$z] = 0;
                        }
                    }
                    if ($z == $pom) {
                        $r = rand(0, 3);
                        if ($r == 1) {
                            $pop[$i][$j][$z] = 1;
                        }
                    }
                }
            }
        }
        return $pop;
    }

    private function layerInMiddle2Down($pop, $nr = 10)
    {

        $pom = rand(1, $nr - 2);

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    if ($z == $pom - 1) {
                        $r = rand(0, 3);
                        if ($r == 1) {
                            $pop[$i][$j][$z] = 0;
                        }
                    }
                    if ($z == $pom || $z == $pom + 1) {
                        $r = rand(0, 3);
                        if ($r == 1) {
                            $pop[$i][$j][$z] = 1;
                        }
                    }
                }
            }
        }
        return $pop;
    }

    private function powerChangeOneLayerZ($pop, $nr = 10)
    {
        $pomZ = rand(0, $nr - 1);
        $orders = $this->getOrders($nr);
        $sum = 0;
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                $r = rand(0, 5);
                if ($r == 0 && $pop[$i][$j][$pomZ] == 1) {
                    $pop[$i][$j][$pomZ] = 0;
                    $sum += $orders[$i . "-" . $j . "-" . $pomZ];
                }
            }
        }

        $r = 1000;
        $r2 = 1000;
        while ($sum > 0 && $r > 0 && $r2 > 0) {
            $x = rand(0, $nr - 1);
            $y = rand(0, $nr - 1);

            if ($pop[$x][$y][$pomZ] == 0 && $orders[$x . "-" . $y . "-" . $pomZ]  < $sum && $sum > 0) {
                $pop[$x][$y][$pomZ] = 1;
                $sum = $sum - $orders[$x . "-" . $y . "-" . $pomZ];
                $r = 1000;
            }
            $r--;
            if ($r == 0 && $sum > 0.1) {

                $i = rand(0, $nr - 1);
                $j = rand(0, $nr - 1);
                while ($pop[$i][$j][$pomZ] == 0) {
                    $i = rand(0, $nr - 1);
                    $j = rand(0, $nr - 1);
                }
                $r2--;
                $pop[$i][$j][$pomZ] = 1;
                $sum += $orders[$i . "-" . $j . "-" . $pomZ];
                $r = 1000;
            }
        }

        return $pop;
    }

    private function moveQuere4x4($pop, $nr = 10, $z = -1)
    {
        return $this->moveQuere4x4Head($pop, $nr, 4, $z);
    }

    private function moveQuere4x4Head($pop, $nr = 10, $size = 4, $z = -1)
    {
        $pomZ = $z;
        if ($pomZ < 0) {
            $pomZ = rand(0, $nr - 1);
        }

        $pomX = rand(1, $nr - $size - 1);
        $pomY = rand(1, $nr - $size - 1);
        $tryb = rand(0, 3);
        $chX = 0;
        $chY = 0;
        $pop2 = $pop;

        switch ($tryb) {
            case 0:
                $chX = 1;
                for ($i = 0; $i < $size; $i++) {
                    $pop[$pomX + $i][$pomY][$pomZ] = $pop[$pomX + $i + $chX][$pomY][$pomZ];
                }
                break;
            case 1:
                $chX = -1;
                for ($i = 0; $i < $size; $i++) {
                    $pop[$pomX + $i][$pomY + $size - 1][$pomZ] = $pop[$pomX + $i + $chX][$pomY + $size - 1][$pomZ];
                }
                break;
            case 2:
                $chY = 1;
                for ($i = 0; $i < $size; $i++) {
                    $pop[$pomX][$pomY + $i][$pomZ] = $pop[$pomX][$pomY + $i + $chY][$pomZ];
                }
                break;
            case 3:
                $chY  = -1;
                for ($i = 0; $i < $size; $i++) {
                    $pop[$pomX + $size - 1][$pomY + $i][$pomZ] = $pop[$pomX + $size - 1][$pomY + $i + $chY][$pomZ];
                }
                break;
        }

        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size; $j++) {
                $pop[$pomX + $i + $chX][$pomY + $j + $chY][$pomZ] = $pop2[$pomX + $i][$pomY + $j][$pomZ];
            }
        }
        return $pop;
    }

    private function moveQuere4x4Multi($pop, $nr = 10)
    {
        $r = rand(2, 4);
        $pomZ = rand(0, $nr - 1);
        for ($i = 0; $i < $r; $i++) {
            $pop = $this->moveQuere4x4($pop, $nr, $pomZ);
        }
        return $pop;
    }

    private function moveQuere5x5($pop, $nr = 10, $z = -1)
    {
        return $this->moveQuere4x4Head($pop, $nr, 5, $z);
    }

    private function moveQuere5x5Multi($pop, $nr = 10)
    {
        $r = 2;
        $pomZ = rand(0, $nr - 1);
        for ($i = 0; $i < $r; $i++) {
            $pop = $this->moveQuere5x5($pop, $nr, $pomZ);
        }
        return $pop;
    }


    private function moveQuere3x3($pop, $nr = 10, $z = -1)
    {
        return $this->moveQuere4x4Head($pop, $nr, 3, $z);
    }

    private function moveQuere3x3Multi($pop, $nr = 10)
    {
        $r = rand(2, 8);
        $pomZ = rand(0, $nr - 1);
        for ($i = 0; $i < $r; $i++) {
            $pop = $this->moveQuere3x3($pop, $nr, $pomZ);
        }
        return $pop;
    }

    private function moveQuere6x6($pop, $nr = 10, $z = -1)
    {
        return $this->moveQuere4x4Head($pop, $nr, 6, $z);
    }

    private function moveQuere2x2($pop, $nr = 10, $z = -1)
    {
        return $this->moveQuere4x4Head($pop, $nr, 2, $z);
    }

    private function moveQuere2x2Multi($pop, $nr = 10)
    {
        $r = rand(2, 8);
        $pomZ = rand(0, $nr - 1);
        for ($i = 0; $i < $r; $i++) {
            $pop = $this->moveQuere2x2($pop, $nr, $pomZ);
        }
        return $pop;
    }

    private function shuffleDiagonal_w1($pop, $nr = 10)
    {
        return $this->shuffleDiagonalWidth($pop, $nr, 1);
    }

    private function shuffleDiagonal_w2($pop, $nr = 10)
    {
        return $this->shuffleDiagonalWidth($pop, $nr, 2);
    }

    private function shuffleDiagonal_w3($pop, $nr = 10)
    {
        return $this->shuffleDiagonalWidth($pop, $nr, 3);
    }

    private function shuffleDiagonal_w4($pop, $nr = 10)
    {
        return $this->shuffleDiagonalWidth($pop, $nr, 4);
    }

    private function shuffleDiagonal_w5($pop, $nr = 10)
    {
        return $this->shuffleDiagonalWidth($pop, $nr, 5);
    }

    private function shuffleDiagonalWidth($pop, $nr = 10, $w = 1)
    {
        $pom_z = rand(0, $nr - 1);
        $w = $w - 1;
        $pom = rand(1, ($nr - 1) * 2);
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = $i + $j;
                    if ($z == $pom_z && $sum >= $pom && $pom <= $sum + $w) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }
        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $sum = $i + $j;
                    if ($z == $pom_z && $sum >= $pom && $pom <= $sum + $w) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function bw1($pop, $nr = 10)
    {
        return $this->shuffleBorderinZtype2($pop, $nr, 0);
    }

    private function bw2($pop, $nr = 10)
    {
        return $this->shuffleBorderinZtype2($pop, $nr, 1);
    }

    private function bw3($pop, $nr = 10)
    {
        return $this->shuffleBorderinZtype2($pop, $nr, 2);
    }

    private function bw4($pop, $nr = 10)
    {
        return $this->shuffleBorderinZtype2($pop, $nr, 3);
    }

    private function bw5($pop, $nr = 10)
    {
        return $this->shuffleBorderinZtype2($pop, $nr, 4);
    }

    private function bw12345($pop, $nr = 10)
    {
        $pom_z = rand(0, $nr - 1);
        $pop = $this->shuffleBorderinZtype2($pop, $nr, 0, $pom_z);
        $pop = $this->shuffleBorderinZtype2($pop, $nr, 1, $pom_z);
        $pop = $this->shuffleBorderinZtype2($pop, $nr, 2, $pom_z);
        $pop = $this->shuffleBorderinZtype2($pop, $nr, 3, $pom_z);
        $pop = $this->shuffleBorderinZtype2($pop, $nr, 4, $pom_z);
        return $pop;
    }

    private function bw12345rand50($pop, $nr = 10)
    {
        $pom_z = rand(0, $nr - 1);
        for ($i = 0; $i <= 4; $i++) {
            if (rand(0, 1) == 1) {
                $pop = $this->shuffleBorderinZtype2($pop, $nr, $i, $pom_z);
            }
        }

        return $pop;
    }


    private function shuffleBorderinZtype2($pop, $nr = 10, $dist = 0, $z = -1)
    {
        $pom_z = $z;
        if ($pom_z < 0) {
            $pom_z = rand(0, $nr - 1);
        }
        $max = $nr - 1;
        $used = [];

        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $min = min($i, $j, $max - $i, $max - $j);
                    if ($pom_z == $z && $min == $dist) {
                        $used[] = $pop[$i][$j][$z];
                    }
                }
            }
        }

        shuffle($used);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {
                    $min = min($i, $j, $max - $i, $max - $j);
                    if ($pom_z == $z && $min == $dist) {
                        $pop[$i][$j][$z] = array_shift($used);
                    }
                }
            }
        }
        return $pop;
    }

    private function inveroZ($pop, $nr = 10)
    {
        $pomZ = rand(0, $nr - 1);
        for ($i = 0; $i < $nr; $i++) {
            for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    if ($pomZ == $z) {
                        if ($pop[$i][$j][$z] == 1) {
                            $pop[$i][$j][$z] = 0;
                        } elseif ($pop[$i][$j][$z] == 0) {
                            $pop[$i][$j][$z] = 1;
                        }
                    }
                }
            }
        }
        return $pop;
    }

    private function neighbourchangeOnlyZ($pop, $nr = 10, $zz = -1)
    {

        $changed = 0;
        $ix = 500;
        $pomZ = $zz;
        if ($pomZ < 0) {
            $pomZ = rand(0, $nr - 1);
        }

        while ($changed == 0 && $ix > 0) {

            $pom1 = rand(1, $nr - 2);
            $pom2 = rand(1, $nr - 2);

            $changex = rand(-1, 1);
            $changey = rand(-1, 1);

            if ($pop[$pom1 + $changex][$pom2 + $changey][$pomZ] != $pop[$pom1][$pom2][$pomZ]) {
                $pom = $pop[$pom1][$pom2][$pomZ];
                $pop[$pom1][$pom2][$pomZ] = $pop[$pom1 + $changex][$pom2 + $changey][$pomZ];
                $pop[$pom1 + $changex][$pom2 + $changey][$pomZ] = $pom;
                $changed = 1;
            }
            $ix--;
        }


        return $pop;
    }

    private function neighbourchangeOnlyZMulti5($pop, $nr = 10)
    {
        return $this->neighbourchangeOnlyZMulti($pop, $nr, 4);
    }

    private function neighbourchangeOnlyZMulti($pop, $nr = 10, $many = 4)
    {
        $pomZ = rand(0, $nr - 1);
        for ($i = 0; $i < $many; $i++) {
            $pop = $this->neighbourchangeOnlyZ($pop, $nr, $pomZ);
        }
        return $pop;
    }

    private function neighbourchangeOnlyZMulti16($pop, $nr = 10)
    {
        return $this->neighbourchangeOnlyZMulti($pop, $nr, 16);
    }

    private function neighbourchangeOnlyZMulti32($pop, $nr = 10)
    {
        return $this->neighbourchangeOnlyZMulti($pop, $nr, 32);
    }

    private function neighbourchangeOnlyZMulti64($pop, $nr = 10)
    {
        return $this->neighbourchangeOnlyZMulti($pop, $nr, 64);
    }

    private function neighbourchangeOnlyZMulti8($pop, $nr = 10)
    {
        return $this->neighbourchangeOnlyZMulti($pop, $nr, 8);
    }

    private function neighbourchangeOnlyZMulti128($pop, $nr = 10)
    {
        return $this->neighbourchangeOnlyZMulti($pop, $nr, 128);
    }
}
