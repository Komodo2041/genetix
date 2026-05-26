<?php

namespace App\Http\Controllers;

use App\Services\MeerDataGenerator;
use App\Services\GenetixDataGenerator;
use App\Services\CrossingData;
use App\Services\MutationData; 
use App\Services\BigMutatorData;
 
use App\Services\LevelStering;
use App\Services\MatrixHelper;
  
  
use Illuminate\Http\Request;

use App\Models\Area; 
use App\Models\Calculation; 
use App\Models\Clones;
use App\Models\Diamond;
use App\Models\Diamondcalc;
use App\Models\Matrix;
use App\Models\Waga;
use App\Models\Accuratecalc;
 

use App\Models\CrossMatrix;
use App\Models\PowerSelect; 
 
// COMAND :
// 0 - ostatni, 1 - 4 najlepsze lvl, 2 - next level, 3 -> wszystkie levele
// php artisan app:run-area-calc 0
// php artisan app:run-area-calc 1
// php artisan app:run-area-calc 2
// php artisan app:run-area-calc 3
 

class MainController extends Controller
{

    public function __construct() {
        $this->ls = new LevelStering();
        $this->helperMatrix = new MatrixHelper();
    }

    private $populationName = [
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
    ];

    private $debugInfo = 0;
    private $saveCalculationInCrossAndMuationMatrix = 0;

    public $nrMaxPopulation = 120;

    public $startPopulation = 800;
    public $useBigMutator = 0;
    public $funcMutator = 0;

    public $maxNumberInCalculation = 5;

    public $addpopulation = 0;
    public $additionalPopulationSize = 20;

    public $Numhalstep = 2; // 2
    private $maxPopulation = 60;
    private $nrTimes = 8;


    private $saveCrosMutationMatrix = 1.000001;
     

    private $diamondCrossing = [130, 131, 132, 133, 134, 135, 136, 137];
 
    private $selectUsingPower = [31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62];
    private $selectUsingPowerBottomLayerZero = [51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62];
    private $selectUsingPowerNoBestData = 1;

 
    private $normalSelecting = [0, 1, 2, 3, 10, 23, 24, 28 ];

    private $stillPatternOrClone = [4, 5, 6, 7, 8, 9];
    private $biglayerSelecting = [11, 12, 13, 14, 65, 66, 67, 68, 69, 70, 71, 72];
    private $biglayerSelectingShort = [12, 13, 14, 65, 66, 67, 68, 69, 70, 71, 72];

    private $wagaSelecting = [17, 18, 19, 20];
    private $avgdetailcalcSelecting = [76, 77, 78, 79, 80];

    private $noSelectingPopulation = [-1, 21, 22, 25, 30, 63];


    private $randomDoingTrybe = 6;


    private $usingPower = 0;

    private function getRandomDoing() {
         $randomDoing = -1;
         while (in_array($randomDoing, $this->noSelectingPopulation)) {
             $randomDoing = rand(0, 80);
             if ($this->randomDoingTrybe  == 1) {
                 $randomDoing = rand(min($this->selectUsingPower), max($this->selectUsingPower));
             } elseif ($this->randomDoingTrybe  == 2) { // NORMAL
                if (!in_array($randomDoing, $this->normalSelecting)) {
                    $randomDoing = -1;
                }                   
             } elseif ($this->randomDoingTrybe  == 3) {
                $randomDoing = rand(min($this->selectUsingPowerBottomLayerZero), max($this->selectUsingPowerBottomLayerZero));             
             } elseif ($this->randomDoingTrybe  == 4) { // NO WAGA
                if (in_array($randomDoing, $this->wagaSelecting)) {
                    $randomDoing = -1;
                }              
             } elseif ($this->randomDoingTrybe == 5) {
                if (!in_array($randomDoing, $this->biglayerSelecting)) {
                    $randomDoing = -1;
                } 
             } elseif ($this->randomDoingTrybe == 6) { // AVG
                $randomDoing = rand(min($this->avgdetailcalcSelecting), max($this->avgdetailcalcSelecting));  
             }   
         }
        return $randomDoing; 
    }

    public function list(Request $request, MeerDataGenerator $mdg) {
 
        $area = Area::with("calculations")->where("hide", 0)->get();
        
        $calco = Calculation::selectRaw('COUNT(id) AS count, area_id, level, MAX(obtainedresult) as max, AVG(obtainedresult) as avg')->groupBy('area_id', 'level')->orderBy("level")->get()->toArray();
        $calcoData = [];
        foreach ($calco AS $c) {
           $calcoData[$c["area_id"]][] = $c; 
        }

        $save =  $request->input('save');
        if ($save) {
            $action = $request->input('action');
            switch($action) {
                case "Dodaj test Dno morza":
                    $res = $mdg->generateMeer(10);
                       Area::create(["name" => $res["name"], "data" => json_encode($res['data'])]);
                       return redirect("/")->with('success', 'Utworzono nowy obszar dna');
                    break;
                 case "Dodaj obszar 0 i 1":
                    $res = $mdg->generate0and1(10);
                       Area::create(["name" => $res["name"], "data" => json_encode($res['data'])]);
                       return redirect("/")->with('success', 'Utworzono obszar 0 i 1');
                    break;
                case "Dodaj przekladaniec Z":
                    $res = $mdg->generateprzekladaniecZ(10);
                       Area::create(["name" => $res["name"], "data" => json_encode($res['data'])]);
                       return redirect("/")->with('success', 'Utworzono przekladniec Z');
                    break;
                case "Dodaj przekladaniec X":
                    $res = $mdg->generateprzekladaniecX(10);
                       Area::create(["name" => $res["name"], "data" => json_encode($res['data'])]);
                       return redirect("/")->with('success', 'Utworzono przekladniec X');
                    break;
                case "Dodaj przekladaniec Y":
                    $res = $mdg->generateprzekladaniecY(10);
                       Area::create(["name" => $res["name"], "data" => json_encode($res['data'])]);
                       return redirect("/")->with('success', 'Utworzono przekladniec Y');
                    break;
                case "Generuj jaskinie":
                    $res = $mdg->generateCave(10);
                       Area::create(["name" => $res["name"], "data" => json_encode($res['data'])]);
                       return redirect("/")->with('success', 'Utworzono jaskinię');
                    break;                    
                case "3 różne warstwy Z":
                    $res = $mdg->generateprze3otherLayerZ(10);
                       Area::create(["name" => $res["name"], "data" => json_encode($res['data'])]);
                       return redirect("/")->with('success', 'Utworzono 3 warstwy w osi Z');
                    break;         
            }
        }
 
        return view("main", ['area' => $area, 'calco' => $calcoData, "nrTimes" => $this->nrTimes]);
    }
 
    public function calcarea_level($id, $lvl,  GenetixDataGenerator $gtx, CrossingData $cross, MutationData $mutation, BigMutatorData $bigmutation, $dId = null) {
        
        set_time_limit(40000);
        $halfStep = $this->getSteps($this->maxPopulation);
        $useonlyMutation = 0;

        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $table = json_decode($area->data);
        $headPoints = $gtx->calcPoints($this->nrMaxPopulation, $table);
        $gtx->setPowerMatrixSize(10);  
 
        $population0 = [];


        if ($area->matrixtribe > 0) {
            if ($area->matrixtribe == 1) {
               $methods = Matrix::where("area_id", $id)->where("hide", 0)->where("result", ">", 0)->get()->pluck("name")->toArray();
            } else {
               $methods = Matrix::where("area_id", $id)->where("hide", 0)->where("result", ">", 0)->orderBy("result", "DESC")->take(10)->get()->pluck("name")->toArray();
            }
 
           if ($methods) {
               $mutation->changeMutationList($methods);
           }
        }

        if ($area->matrixcross > 0) {
            if ($area->matrixcross == 1) {
               $methods = CrossMatrix::where("area_id", $id)->where("hide", 0)->where("max", ">", 1)->get()->pluck("name")->toArray(); 
            } else {
               $methods = CrossMatrix::where("area_id", $id)->where("hide", 0)->where("max", ">", 1)->orderBy("max", "DESC")->take(10)->get()->pluck("name")->toArray();
            }
 
           if ($methods) {
               $cross->changeMethodList($methods);
           }
        }

 
        if (!$dId) {
            
            $randomDoing = $this->getRandomDoing();
            // $randomDoing = rand(73, 74);
             
            //  $randomDoing = 75;  
        } else {
            $nrDiamond = count($this->diamondCrossing);
            $randomDoing = $this->diamondCrossing[rand(0, $nrDiamond - 1 )];  
       
            $diamonds = ["diamond_id" => $dId];
        }

        $clones = ["area_id" => $id];
        $usedcalc = [];  

        $minimumCalc = $this->ls->getminimum($id, $lvl - 1);
        $minimumCalc2 = $this->ls->getminimum($id, $lvl - 1, 1);
 
        $individual = 10;
        $lvl = $lvl - 1;
        $additionalPopulation = [];

        if ($lvl <= 0 ) {
            
            $population0 = $gtx->getFirstGeneration(10, 1, $this->startPopulation);
            $randomDoing = 0;
    
        } elseif ($randomDoing == 0 || $lvl == 1) {
        
            $calculations = $this->getCalculationLevel($id, $lvl, 10);  
            $population0 = [];
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data);
                $usedcalc[] = $c->id;
            }
            $randomDoing = -1;

        } elseif ($randomDoing == 1) {
          
            $calculations = $this->getCalculationLevel($id, $lvl, 5); 
            $population0 = [];
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data);
                $usedcalc[] = $c->id;
            }
            $ix = rand(1, $lvl-1);
            $calculations = Calculation::where("area_id", $id)->where("level", $ix)->take(5)->orderByRaw('RAND()')->get();
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data);
                $usedcalc[] = $c->id;
            }               
        } elseif ($randomDoing == 2) {
             
            $calculations = $this->getCalculationLevel($id, $lvl, 50, 0);  
            $population0 = [];
            $mostdifferent = $this->getmostdifferent($calculations, 2);  
            foreach ($mostdifferent AS $c) {
                $population0[] = json_decode($c->data);
                $usedcalc[] = $c->id;
            }
            
                
        } elseif ($randomDoing == 3) {
         
            $calculations = $this->getCalculationLevel($id, $lvl, 50, 0);  
            $population0 = [];
            $number = rand(3, 10);
            $mostdifferent = $this->getmostdifferent($calculations, $number);  
            foreach ($mostdifferent AS $c) {
                $population0[] = json_decode($c->data);
                $usedcalc[] = $c->id;
            }
                  
        } elseif ($randomDoing == 4) {
            $calculations = $this->getCalculationLevel($id, $lvl, 50, 0);
            $usedpercent = rand(70,99);
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data); 
            }                
            $power = $gtx->getPower($population0);

            $stiffPattern = $gtx->getStiffPattern($calculations, $usedpercent, 10);
            $population0 = $gtx->getStableGeneration(10, $this->startPopulation, $stiffPattern[0], $stiffPattern[1]);
            $population0 = $gtx->usepower($population0, $power);
        } elseif ($randomDoing == 5) { 
        
            $calculations = $this->getCalculationLevel($id, $lvl, 50, 0, 1);
            $usedpercent = rand(70,99);
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data); 
            }                
            $power = $gtx->getPower($population0);     

            $stiffPattern = $gtx->getStiffPattern($calculations, $usedpercent, 10);
            $population0 = $gtx->getStableGeneration(10, $this->startPopulation, $stiffPattern[0], $stiffPattern[1]);

            $population0 = $gtx->usepower($population0, $power);

        } elseif ($randomDoing == 6) { // 10% change

            $change = 100;
            $calculations = $this->getCalculationLevel($id, $lvl, 5, 0);
            $tempplate = $gtx->getStiilPatern(10, $change);
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data); 
            }                
            $power = $gtx->getPower($population0);   
            $population0 = $gtx->getPopulationFromStillTemplate(10, $this->startPopulation,  $tempplate, $calculations[0], $change);
            $population0 = $gtx->usepower($population0, $power);

        }  elseif ($randomDoing == 7) {  // clone

            $calculations = $this->getCalculationLevel($id, $lvl, 50, 0, 1);
            $area2 = json_decode($calculations[0]->data);
            $change = rand(1, 20);
            $res = $gtx->clonePattern($area2, 1, $change);
            $population0 = [$area2, $res[0]];
            

            $clones["calc_id"] = $calculations[0]->id;
            $clones["oldresult"] = $calculations[0]->obtainedresult;
            $clones["change"] = $change;

        }  elseif ($randomDoing == 8) { // multiple clone

            $calculations = $this->getCalculationLevel($id, $lvl, 50, 0);
            $area2 = json_decode($calculations[0]->data);
            $change = rand(1, 20);
            $size = rand(6, 12);
            $res = $gtx->clonePattern($area2, $size, $change);
            $population0 = $res;
           
            
            $clones["calc_id"] = $calculations[0]->id;
            $clones["oldresult"] = $calculations[0]->obtainedresult;
            $clones["change"] = $change;     

        } elseif ($randomDoing == 9) { // xz xy yz change

            $change = 100;
            $calculations = $this->getCalculationLevel($id, $lvl, 5, 0);
            $tempplate = $gtx->getStiilPaternXYZ(10);
             foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data); 
            }                
            $power = $gtx->getPower($population0);  
            $population0 = $gtx->getPopulationFromStillTemplate(10, $this->startPopulation,  $tempplate, $calculations[0], $change);
            $population0 = $gtx->usepower($population0, $power);

        } elseif ($randomDoing == 10 || $randomDoing == 23) {  // start with 3 *  mutations
            $calculations = $this->getCalculationLevel($id, $lvl, 10);  
            $population0 = [];
            $cr = [];
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data);
                $cr[] = "generation";
                $usedcalc[] = $c->id;
            }
             
            $res = $mutation->addmutation($population0, $cr);
            $res = $mutation->addmutation($res[0], $res[1]);
            $res = $mutation->addmutation($res[0], $res[1]);
            $population0 = $res[0];

            if ($randomDoing == 23) {
                $useonlyMutation = 1;
            }
 
        } elseif ($randomDoing == 11) {
            
            $calculations = $this->getCalculationLevel($id, $lvl, 2, 0, 1);
            $area2 = json_decode($calculations[0]->data);
            $usedcalc[] = $calculations[0]->id;
            $population0 = $bigmutation->bigLayerMutation($this->startPopulation, 10, $area2);

           $this->useBigMutator = 1;

        } elseif ( in_array($randomDoing, $this->biglayerSelectingShort)) {

            $calculations = $this->getCalculationLevel($id, $lvl, 10);  
            $population0 = [];
            foreach ($calculations AS $c) {
                $usedcalc[] = $c->id;
                $population0[] = json_decode($c->data);
            }
            if ($randomDoing == 12 || $randomDoing == 65 || $randomDoing == 67 || $randomDoing == 69 || $randomDoing == 71) {
               $this->useBigMutator = 1;
            } elseif ($randomDoing == 13 || $randomDoing == 66 || $randomDoing == 68 || $randomDoing == 70 || $randomDoing == 72) {
               $this->useBigMutator = 2;
            } elseif ($randomDoing == 14) {
                $this->useBigMutator = 3;
                $this->funcMutator = $bigmutation->getIdFunc("bigLayerMutationCircle");                
            }

            if ($randomDoing == 65 || $randomDoing == 66) {
                $bigmutation->setPercent(70);
            } elseif ($randomDoing == 67 || $randomDoing == 68) {
                $bigmutation->setPercent(40);
            } elseif ($randomDoing == 69 || $randomDoing == 70) {
                $bigmutation->setPercent(20);
            } elseif ($randomDoing == 71 || $randomDoing == 72) {
                $bigmutation->setPercent(10);
            }

        }  elseif ($randomDoing == 15) { // Join Rivers

            $calculations = $this->getCalculationMaxBest($id, 2);  
            $population0 = []; 
            foreach ($calculations AS $c) {
                $usedcalc[] = $c->id;
                $population0[] = json_decode($c->data);
            }

            $areas = Area::where("river", $id)->get();
            foreach ($areas AS $ar) {
                $calculations = $this->getCalculationMaxBest($ar->id, 2);
                foreach ($calculations AS $c) {
                    $population0[] = json_decode($c->data);
                }                
            }
 
          
        } elseif ($randomDoing == 16) { // Join More Rivers 

            $calculations = $this->getCalculationMaxBest($id, 2);  
            $population0 = []; 
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data);
            }

            $areas = Area::where("river", $id)->get();
            foreach ($areas AS $ar) {
                $calculations = $this->getCalculationMaxBest($ar->id, 10);
                foreach ($calculations AS $c) {
                    $population0[] = json_decode($c->data);
                }                
            } 
  
            
        }  elseif ( in_array($randomDoing, $this->wagaSelecting)) {
            $bestResult = Calculation::where("area_id", $id)->where("level", $lvl)->orderByRaw('RAND()')->first();
            if (!$bestResult) {
                return redirect("/")->with('error', 'Brak obliczeń dla podanego area');
            }
            $wg = Waga::where("calculation_id", $bestResult->id)->first();
            $dataBest = json_decode($bestResult->data);
            if (!$wg) { 
                $wdiff = $this->getdiffwaga($dataBest, $headPoints, $id, $bestResult->id, $gtx);
            } else {
                $wdiff = json_decode($wg->data);
            }
            
            $power = $gtx->getPower([$dataBest]);
            if ($randomDoing == 17) {
               $population0 = $gtx->createPopulation0FromWaga($this->startPopulation, $dataBest, $wdiff, 0.10); 
            } elseif ($randomDoing == 18)  {
               $population0 = $gtx->createPopulation0FromWaga($this->startPopulation, $dataBest, $wdiff, 0.25);
            } elseif ($randomDoing == 19)  {
               $population0 = $gtx->createPopulation0FromWaga($this->startPopulation, $dataBest, $wdiff, 0.03); 
            } elseif ($randomDoing == 20)  {
               $population0 = $gtx->createPopulation0FromWaga($this->startPopulation, $dataBest, $wdiff, 0.01); 
            }
            $population0 = $gtx->usepower($population0, $power);
            $population0[] = $dataBest;
 
            
        } elseif ($randomDoing == 24) {

            $calculations = $this->getCalculationLevel($id, $lvl, 10, 1, 2);  
            $population0 = [];
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data);
                $usedcalc[] = $c->id;
            }

        } elseif ($randomDoing == 26) {

            $calculations = Calculation::where("area_id", $id)->orderBy("level", "DESC")->inRandomOrder()->take($this->startPopulation)->get();  
    
            $population0 = [];
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data);
            }
            $power = $gtx->getPower($population0);
            $population0 = $cross->goThrough($population0, "blob6random");
            $population0 = $gtx->usepower($population0, $power);
 
        } elseif ($randomDoing == 27) {

            $calculations = Calculation::where("area_id", $id)->orderBy("level", "DESC")->inRandomOrder()->take($this->startPopulation)->get();  
            $population0 = [];
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data);
            }
            $power = $gtx->getPower($population0);
            $population0 = $cross->goThrough($population0, "blob3random");
            $population0 = $gtx->usepower($population0, $power);

        } elseif ($randomDoing == 28) {

            $calculations = $this->getCalculationLevel($id, $lvl, 10);  
            $population0 = [];
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data);
                $usedcalc[] = $c->id;
            }
            $this->addpopulation = 1;
        
            $calculations = $this->getCalculationLevel($id, $lvl, $this->additionalPopulationSize); 
            foreach ($calculations AS $c) {
                $additionalPopulation[] = json_decode($c->data);
            }            
  
        }  elseif ($randomDoing == 29) {

            $calculations = Calculation::where("area_id", $id)->orderBy("level", "DESC")->inRandomOrder()->take($this->startPopulation)->get();  
            $population0 = [];
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data);
            }

            $power = $gtx->getPower($population0); 
            while (count($population0) > 80) {
                $population0 = $cross->goThrough($population0, "random50");
            } 
            $population0 = $gtx->usepower($population0, $power);


        } elseif ( in_array($randomDoing, $this->selectUsingPower)) { 
        
            $bestResult = Calculation::where("area_id", $id)->where("level", $lvl)->orderByRaw('RAND()')->first();
          
            if (!$bestResult) {
                return redirect("/")->with('error', 'Brak obliczeń dla podanego area');
            } 
            $dataBest = json_decode($bestResult->data); 
            $power = $gtx->getPower([$dataBest]);
            $pattern = $dataBest;
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
    
            $usepowerDetails = rand(1, 5);
            $population0 = $gtx->generatePopinPower($this->startPopulation, $pattern, $power, $usepowerDetails);
            if ($this->selectUsingPowerNoBestData == 0) {
                $population0[] = $dataBest;
            }
       
        } elseif ($randomDoing == 64) {
        
            $calculations = Calculation::where("area_id", $id)->where("level", $lvl)->where("typecalc", 63)->orderByRaw('RAND()')->take(10)->get();
            if (!$calculations) {
                $calculations = $this->getCalculationLevel($id, $lvl, 10);  
                $randomDoing = -1;
            }
            $population0 = [];
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data);
                $usedcalc[] = $c->id;
            }


        } elseif ($randomDoing == 73) { 
        
            $calculations = $this->getCalculationLevel($id, $lvl, 10);  
            $population0 = [];
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data);
            }
            $power = $gtx->getPower($population0); 
            $population0 = $cross->createPopulationFromBloBFromLevel($population0, $this->startPopulation, 10, 1);
            $population0 = $gtx->usepower($population0, $power);

        }  elseif ($randomDoing == 74) { 
        
            $calculations = $this->getCalculationLevel($id, $lvl, 10);  
            $population0 = [];
            foreach ($calculations AS $c) {
            
                $population0[] = json_decode($c->data);
            }
          
            $power = $gtx->getPower($population0); 
            $population0 = $cross->createPopulationFromBloBFromLevel($population0, $this->startPopulation, 10, 2);
            $population0 = $gtx->usepower($population0, $power);

        } elseif ($randomDoing == 75) { 
        
            $calculations = Calculation::where("area_id", $id)->where("level", "<=", $lvl)->orderBy("result2", "DESC")->orderBy("obtainedresult", "DESC")->take(200)->get();
            $calculations = $calculations->shuffle()->take(10);
            $population0 = [];
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data);
            }
 
        } elseif ( in_array($randomDoing, $this->avgdetailcalcSelecting)) {

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
            $ids = Accuratecalc::where("area_id", $id)->take(50)->orderBy($order, $desc)->get();
            $selected = [];
            if ($ids) {
                foreach ($ids AS $ac) {
                    $selected[] = $ac->calc_id;
                }
                $calculations = Calculation::where("area_id", $id)->whereIn("id", $selected)->get();
            } else {
                $calculations = $this->getCalculationLevel($id, $lvl, 10);  
    
                $randomDoing = -1;
            }
            $population0 = [];
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data);
                $usedcalc[] = $c->id;
            }
        
        } elseif ( in_array($randomDoing, $this->diamondCrossing)) {

            $res = $this->stereDiaomond($randomDoing, $mutation, $bigmutation);
            $population0 = $res[0];
            $clones = $res[1];
        } 

 

        if (count($population0) == 0) {
            return redirect("/")->with('error', "Pojawił się brak populacji dla random : ".$randomDoing);
        }

        $individual = count($population0);
        if ($individual > 10) {
            $individual = 10;
        }
 

        if ($usedcalc) {
            Calculation::whereIn('id', $usedcalc)->increment('calculation');
        }
 
        $power = $gtx->getPower($population0);
        $res = $gtx->calcPopulation($population0, $headPoints);
        unset($population0);
 
        if ($this->debugInfo) {
            $this->debugInfo($res, $randomDoing);
        }
 

        if ($this->usingPower == 1) {
            return [$res, $bestResult, $randomDoing];
        }
 

        $maxQ = $res[0]['sum'];
        $oldQ = $res[0]['sum'];
        $maxQ2 = $res[1]['sum'];
        $oldQ2 = $res[1]['sum'];
 
        $first = $res[0]['sum'];
 
        $repeatQ = 0;
        $maxPoints = $gtx->getmaxPoints($this->nrMaxPopulation);
        $nrPop = 0;
        $maxPop = $this->maxPopulation;
 
        $info = [];
        $usedmodify = [];

        $bestArea = $res[0]['area'];
        $usebestArea = 0;
        $nrBetter = 0;

        $t3 = microtime(true);
          // HEAD LOOP
         
 
        while ($repeatQ < 20 && $nrPop < $maxPop && $maxQ < $maxPoints) {
 
            $selectedIndividuals = $gtx->getindyvidual($res, $individual);
        
            if ($usebestArea == 1) {
                $selectedIndividuals[] = $bestArea;
            }

       
            $gtx->choosemodify($res, 10, $usedmodify);

            if ($this->addpopulation) {
             
                $new = $additionalPopulation[rand(0, count($additionalPopulation) - 1)];
                $selectedIndividuals[] = $new;
                 
            }
 
            if ($this->useBigMutator > 0  && $nrPop % 2 == 1  ) {

                $pop_result = $bigmutation->createNewPopulation($selectedIndividuals, $this->useBigMutator, $this->funcMutator);
                $newpopulaton = $gtx->usepower($pop_result[0], $power);
                $pop_result[0] = $newpopulaton;
                
            } elseif ($useonlyMutation == 0) {

                $pop_result = $cross->createNewPopulation($selectedIndividuals);
                $newpopulaton = $gtx->usepower($pop_result[0], $power);
                $pop_result = $mutation->addmutation($newpopulaton, $pop_result[1]);

            } elseif ($useonlyMutation == 1) {
                
                $mutation->setNumerMutation($this->startPopulation);
                $pop_result = $mutation->addmutation($selectedIndividuals, []);
                $newpopulaton = $gtx->usepower($pop_result[0], $power);
                $pop_result[0] = $newpopulaton;
            }
            
            if ($usebestArea == 1) {
                $pop_result[0][] = $bestArea;
                $usebestArea = 0;
                $pop_result[1][] = "Used best Area";
            }

            $res = $gtx->calcPopulation($pop_result[0], $headPoints, $pop_result[1]);
            $power = $gtx->getPowerfromarea($res);
            $maxQ = $res[0]['sum'];
            $maxQ2 = $res[1]['sum']; 

            if ($maxQ == $oldQ && $maxQ2 == $oldQ2) {
                $repeatQ++; 
            } else {
                $repeatQ = 0;
            }    
 
            $diff = $maxQ / $oldQ;
            if ($diff < 1) {
                $diff = -1;
                $usebestArea = 1;
            } else {
                
                $bestArea = $res[0]['area'];
              
            }
 
            $nrBetter = $this->calcBetter($oldQ, $res);

            if ($area->flex == 1) {
                $individual = $nrBetter;
                if ($individual < 4) {
                    $individual = 10; 
                }
            } else {
                $individual = 10; 
            }
            
            $oldQ = $res[0]['sum'];
            $oldQ2 = $res[1]['sum'];
 

            $info[] = [
               "pop" => $nrPop,
               "diff" => $diff,
               'calc' => $nrBetter
            ];

            if (in_array($nrPop, $halfStep)) {
                 
                $halfreso = $res[0]['sum'] / $maxPoints;
                if ($halfreso >= $minimumCalc2) {
                    Calculation::create(["result" => "Wynik pośredni ", "data" => json_encode($res[0]['area']), "area_id" => $id, "level" => $lvl + 1, "obtainedresult" => $halfreso,
                           "typecalc" => 30, "population" => $nrPop  ]);   
                }                        
            } 

            $nrPop++;             
        }
        $last = $res[0]['sum'];
        $t4 = microtime(true);
        arsort($usedmodify); 
       
       
        $result2 = $maxQ / $maxPoints; 
        if ($result2  > $minimumCalc) {
            $name = "Wynik w pokoleniu ".$nrPop." Wynik: ". $result2 ." Czas generacji ".($t4 - $t3)." s";
            $pgc =  (1 - $result2) / ( ($last / $first) - 1);
            
            $cred = Calculation::create(["result" => $name, "data" => json_encode($res[0]['area']), "area_id" => $id, "level" => $lvl + 1, "obtainedresult" => $result2,
            "usedmod" => json_encode($usedmodify), "typecalc" => $randomDoing, "population" => $nrPop, "info" => json_encode($info), "progress" => $last / $first, "start" => $first / $maxPoints,
            "progcalc" => $pgc]);

            if ($randomDoing == 7 || $randomDoing == 8 || $randomDoing == 130 || $randomDoing == 131 ) {
                $clones["result"] = $result2;
            
                Clones::create($clones);
            } 
            if ( in_array($randomDoing, $this->diamondCrossing)) {
                $diamonds["result"] = $result2;
                $diamonds["calc_id"] = $cred->id;
                Diamondcalc::create($diamonds);
            }
       
            $additionalresultsmsg = "\n\n";  
            $usedcalculations = [$res[0]['area']];
            $other = 0;
            for ($i = 1; $i < count($res); $i++) {
 
                $condo = $result2 * 0.99999;
                if ($result2 > 0.99999) {
                    $condo = $result2 * $result2;
                }
                if ($condo >= $res[$i]['sum']/$maxPoints) {
                    $additionalresultsmsg .= "Przerwano ze względu na słabsze wyniki dla ".$i." potega ".($condo )." resu ".($res[$i]['sum'] / $maxPoints)." \n";
                    break;
                }
                
                $diff = $this->checkedSameResultsinLine($usedcalculations, $res[$i]['area']);
                if ($diff === 0) {
                    $usedcalculations[] = $res[$i]['area'];
                    $result =  $res[$i]['sum'] / $maxPoints;
                    Calculation::create(["result" => $name, "data" => json_encode($res[$i]['area']), "area_id" => $id, "level" => $lvl + 1, 
                    "obtainedresult" => $result, "nrcalc" => $i + 1, "typecalc" => $randomDoing, "population" => $nrPop ]);
                    $additionalresultsmsg .= "Dodano dodatkowe obliczenie Result : ".$i." Wynik: ".$result." - (".$other.")  (".$this->maxNumberInCalculation.") \n";

                    $other++;     
                    if ($this->maxNumberInCalculation < $other + 1) {
                        break;
                    }                               
                } 
            }

            $this->ls->calclevel($id, $lvl + 1);
            return redirect("/")->with('success', 'Dokonano obliczeń dla obszaru '.$id." Wynik: ". $result2. " Level: ".($lvl + 1). " Wynik w pokoleniu : ".$nrPop. $additionalresultsmsg); 

        } else {
            $lvlReso = $this->ls->savenocalc($id, $lvl + 1, $result2, $minimumCalc, $randomDoing );
            if ($lvlReso[0] > 0) {
                $pgc =  (1 - $result2) / ( ($last / $first) - 1);
                $calco = Calculation::create(["result" => "Spadocorniarz z ".($lvl + 1)." na level ".$lvlReso[0]." (".$randomDoing.") ", "data" => json_encode($res[0]['area']), 
                "area_id" => $id, "level" => $lvlReso[0], "obtainedresult" => $result2, "typecalc" => 22, "population" => $nrPop, "start" => $first / $maxPoints, "result2" => $result2,
                  "progress" => $last / $first, "progcalc" => $pgc, "info" => json_encode($info)]);
                $this->ls->saveCalco($calco->id, $lvlReso[1]); 
            }
  
            return redirect("/")->with('error', "Zapisano słabe obliczenie w bazie danych ");
        }
 
    }

    private function getmostdifferent($calculations, $nr) {
 
       $count = count($calculations);
       $results = [];
       $res = [];
       $used = [];
       for ($i = 0; $i < $count; $i++) {
          for ($j = 0; $j < $count; $j++) {
             if ($i == $j) {
                 $results[$i][$j] = 0;
                 continue;
             }
             $results[$i][$j] = 1000 - $this->calcpointer(json_decode($calculations[$i]->data), json_decode($calculations[$j]->data));
          }
       }

       $maxpairs = [];
       $max = 0;
       for ($i = 0; $i < $count; $i++) {
          for ($j = 0; $j < $count; $j++) {
             if ($i == $j) { 
                 continue;
             }
             if ($results[$i][$j] > $max) {
                $maxpairs = [$i, $j];
                $max = $results[$i][$j];
             }
          }
       }       
 
 
       for ($i = 2; $i <= $nr; $i++) {
           $max = 0;
           for ($j = 0; $j < $count; $j++) {
              if (in_array($j, $maxpairs)) {
                 continue;
              }
              $sum = 0;
              $newNumber = -1;
              foreach ($maxpairs AS $m) {
                  $sum += $results[$j][$m];
              }
              if ($sum > $max) {
                $max = $sum;
                $newNumber = $j;
              }

           }
           if ($newNumber > -1) {
               $maxpairs[] = $newNumber;
           }
       }

       foreach ($maxpairs AS $m) {
          $res[] = $calculations[$m];
       }

       return $res;

    }

    private function getCalculationLevel($id, $lvl, $nr, $norepeat = 1, $obtain = 0) {
        $used = [];
        $newcalc = [];
        if ($obtain == 0) {
            $calc = Calculation::where("area_id", $id)->where("level", $lvl)->orderByRaw('RAND()')->get();
        } elseif ($obtain == 1) {
            $calc = Calculation::where("area_id", $id)->where("level", $lvl)->orderByRaw('obtainedresult DESC')->get();
        } elseif ($obtain == 2) {
            $calc = Calculation::where("area_id", $id)->where("level", $lvl)->orderByRaw('calculation ASC')->get();
        }
        foreach ($calc AS $c) {
           if (in_array($c->same, $used)) {
            continue;
           } 
           $newcalc[] = $c;
           if ($c->same) {
             $used[] = $c->same;
           }
           if (count($newcalc) >= $nr) {
            break;
           }
        }
        if ($norepeat != 0) {
            if (count($newcalc) < $nr) {
                $newcalc = array_merge($newcalc, $newcalc);
            }
        }
        return $newcalc;
    }
 

    public function percentshow($id) {
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $calc = [];
        $table = json_decode($area->data);

 
        $maxlevel = 1;
        $caclcount = count($area->calculations);
        $i = 0;
        foreach ($area->calculations AS $c) {
            $i++;
           if ($i + 1000 < $caclcount) {
             continue;
           }
           $pc = json_decode($c->data);
 
           $calc[] = [
              'id' => $c->id,
              'level' => $c->level,
              'sum' => $c->obtainedresult,
              'points' => $this->calcpointer( $table, $pc)
           ]; 
           if ( $c->level > $maxlevel) {
              $maxlevel = $c->level;
           }
           
        }
 
 
        return view("percent", ['calco' => $calc ]);

    }

    private function calcpointer($one, $two) {
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

 
    private function checkedSameResultsinLine($usedcalculations, $area) {
       $res = 0;
       foreach ($usedcalculations AS $one ) {
          $all = $this->calcpointer($one, $area);
          
          if ($all > 999) {
            $res = $all;
            break;
          }
       }
        
       return $res;
    }


    private function getnumber2inarea($one) {
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

 

    private function calcallinLevel($one, $two) {
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
     
    private function calcallinHistogramLevel($one, $two, $res) {
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

    private function gethistogram($hist, $maxo = 30) {
        $nr = 10;
        for ($i= 0; $i < $maxo; $i++ ) {
            $res[$i] = 0;
        }
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

    public function mutations(CrossingData $cross, MutationData $mutation, BigMutatorData $bigmutation) {

        $calculations = Calculation::wherenull("nrcalc" )->take(10)->orderBy("id", "desc")->get();
        $result = [];
        foreach ($calculations AS $c) {
           if ($c->usedmod) {
              $table = json_decode($c->usedmod);
              foreach ($table AS $key => $value) {
                if (isset($result[$key])) {
                   $result[$key] += $value;
                } else {
                   $result[$key] = $value;
                }
              }
           }
        }
        $all = 0;
        arsort($result);
        foreach ($result AS $key => $value) {
            $all += $value;
        }
        $crossings = $cross->getAllMethod();
        $mutations = $mutation->getAllMethod();
        $bigmutations = $bigmutation->getAllMethod();
        $nonusedcross = [];
        $nonusedmutations = [];
        foreach ($crossings AS $c) {
           if (!isset($result[$c])) {
             $nonusedcross[] = $c;
           }
        }
        foreach ($mutations AS $m) {
           if (!isset($result[$m])) {
             $nonusedmutations[] = $m;
           }
        }        
        
        return view("mutations", ['mutations' => $result, "all" => $all, 'cross' => $crossings, 'mutaions' => $mutations, 'bigmutations' => $bigmutations,
           "nc" => implode(", ", $nonusedcross ), "nm" => implode(", ", $nonusedmutations )   ]);

    }


    public function histogram($id) {
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
        foreach ($area->calculations AS $c) {
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
              'points' => $this->calcpointer( $table, $pc)
           ]; 
           if ( $c->level > $maxlevel) {
              $maxlevel = $c->level;
           }
           $levels[$c->level]['areabulb'] = $this->calcallinLevel($levels[$c->level]['areabulb'], $pc);
           $levels[$c->level]['histogram'] = $this->calcallinHistogramLevel($levels[$c->level]['tohistogram'], $pc, $levels[$c->level]['histogram']);
        }
 
        foreach ($levels AS $key => $value) {
            if ($levels[$key]["all"] > 0) {
                $levels[$key]["avg"] = $levels[$key]["sum"] /  $levels[$key]["all"];
            } else {
                $levels[$key]["avg"] = 0;
            }
            $levels[$key]["divlvl"] = 1;
        }
        for ($i = 1; $i <= $maxlevel; $i++) {
            if (!isset( $levels[$i]) || !isset( $levels[$i - 1])) {
                continue;
            }
            $levels[$i]["divlvl"] = $levels[$i]["avg"] - $levels[$i - 1]["avg"];
            $levels[$i]["toone"] = $levels[$i]["divlvl"] / (1 - $levels[$i - 1]["avg"]);
            $levels[$i]["sameinlevel"] = $this->getnumber2inarea($levels[$i]['areabulb']);
            $levels[$i]["show_histogram"] = $this->gethistogram($levels[$i]['histogram'], $levels[$i]['all']);
        }
 
        $samecalculations = Calculation::selectRaw(' count(id) AS count, level')->where("area_id", $id)->whereNotNull("same")->groupBy( 'level')->orderBy("level")->get();
        $samecalculations = $samecalculations->pluck("count", "level")->toArray();
         

        return view("histogram", ['calco' => $calc, 'levels' => $levels, 'samecalc' => $samecalculations]);

    }


    public function samecalculations($id) {

        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }

        set_time_limit(3600);
        
        $calculations = Calculation::where("area_id", $id)->where("same", null)->orderBy("id", "asc")->get();
        $used = [];
       
        foreach ($calculations AS $c) {
            if (in_array($c->id, $used)) {
                continue;                    
            }            
            $samecalculations = Calculation::where("area_id", $id)->where("data", $c->data)->where("id", "!=", $c->id)->get();
             
            if ($samecalculations->count() > 0) {
                foreach ($samecalculations AS $same) {
                    $used[] = $same->id;
                }
                Calculation::where("area_id", $id)->where("data", $c->data)->update(["same" => $c->id]);
            }

        }
        return redirect("/")->with('success', 'Szukano takich samych obliczeń. Znaleziono '.count($used)." takich samych obliczeń "); 
    }

    public function adddiamond($id) {
       $calc = Calculation::find($id);
       if (!$calc) {
          return redirect("/")->with('error',  "Nie znaleziono obliczenia"); 
       }
       $d = Diamond::create(["area_id" => $calc->area_id, "calc_id" => $id]);
       Diamondcalc::create(["calc_id" => $id, "result" => $calc->obtainedresult, "diamond_id" => $d->id ]);
       return redirect("/")->with('success',  "Dodano diament");
    }

    private function getDiamond($dId) {
        $dc = Diamondcalc::where("diamond_id", $dId)->orderByRaw("result DESC")->first();
        if (!$dc) {
          return redirect("/")->with('error',  "Nie znaleziono obliczenia"); 
        }
        $calc = Calculation::find($dc->calc_id);
        if (!$calc) {
          return redirect("/")->with('error',  "Nie znaleziono obliczenia"); 
        }   
        return $calc;
    }

    private function getDiamondCalculations($dId) {
        $dc = Diamondcalc::where("diamond_id", $dId)->orderByRaw("result DESC")->take(10)->get();
        $calco = [];
        foreach ($dc AS $d) {
            $calco[] = $d->calc_id;
        }
        return Calculation::whereIn('id', $calco)->get();
    }

    public function showerros($id) {
       $calc = Calculation::find($id);
       if (!$calc) {
          return redirect("/")->with('error',  "Nie znaleziono obliczenia"); 
       }
        $area = Area::find($calc->area_id);
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
 
        return view("showdiff", ['calc' => $data, 'area' => $area, 'res' => $res, 'res2' => $res2 ]);

    }

    public function showring($id) {
       $calc = Calculation::find($id);
        if (!$calc) {
           return redirect("/")->with('error',  "Nie znaleziono obliczenia"); 
        }
        $area = Area::find($calc->area_id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $nr = 10;
        $res = array_fill(0, $nr, array_fill(0, floor($nr / 2), 0));
        $res2 =  array_fill(0, $nr, array_fill(0, floor($nr / 2), 0));
        $data = json_decode($calc->data);
        $area = json_decode($area->data);
        

        for ($i = 0; $i < $nr; $i++) {
           for ($j = 0; $j < $nr; $j++) {
                for ($z = 0; $z < $nr; $z++) {

                    for ($k =0, $l = $nr - 1; $k < $l; $k++, $l--) {   
                        if (($i == $k || $i == $l || $j == $k || $j == $l) && ($i >= $k && $i <= $l) && ($j >= $k && $j <= $l) ) {
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
 
        return view("showring", ['calc' => $data, 'area' => $area, 'res' => $res, 'res2' => $res2 ]);


    }

   
    public function calcallavg($id) {
        $this->ls->calcarea($id);
        return redirect("/")->with('success',  "Przeliczono średnią dla area ID:".$id); 
    }

    public function addRiver($id) {
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        Area::create(["name" => $area->name." - rzeka", "data" => $area->data, "river" => $id ]);
        return redirect("/")->with('success', 'Utworzono rzekę');
    }

    public function hide($id) {
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $area->hide = 1;
        $area->save();
        Area::where("river", $id)->update(["hide" => 1]);
        return redirect("/")->with('success', 'Ukryto obszar');
    }

    public function pourRiver($id) {
        $area = Area::find($id);
        if (!$area || !$area->river) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area lub nie ma rzeki');
        }

        $maxArea = Calculation::where("area_id", $id)->max("level");
        $maxRiver = Calculation::where("area_id", $area->river)->max("level");
        $maxRiver--;

        $calco = Calculation::where("area_id", $id)->where("level", $maxArea)->get();
        foreach ($calco AS $c) {
          Calculation::create([
             "area_id" => $area->river,
             "result" => $c->result,
             "data" => $c->data,
             "level" => $maxRiver, 
             "obtainedresult" => $c->obtainedresult,
             "typecalc" => -2
          ]);
        }

        $this->ls->calcarea($area->river);
        return redirect("/")->with('success', 'Wlano rzekę');
    }

    public function cloneRiver($id) {
        $area = Area::find($id);
        if (!$area || !$area->river) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area lub nie ma rzeki');
        }
        $newArea = Area::create([
            "data" => $area->data,
            "name" => "Klon: ".$area->name,
            "river" => $area->river,
            "hide" => 0
        ]);

        $calco = Calculation::where("area_id", $id)->get();
        foreach ($calco AS $c) {
          Calculation::create([
             "area_id" => $newArea->id,
             "result" => $c->result,
             "data" => $c->data,
             "level" => $c->level, 
             "obtainedresult" => $c->obtainedresult,
             "typecalc" => $c->typecalc
          ]);
        }

        $this->ls->calcarea($newArea->id);
        return redirect("/")->with('success', 'Sopiowano rzekę');           

    }

    public function getCalculationMaxBest($id, $number) {

        return  Calculation::where("area_id", $id)->orderByDesc("obtainedresult" )->limit(max(0, $number))->get();
 
    }

    public function showRiver($id) {
   
        $area = Area::find($id);
        if (!$area ) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area lub nie ma rzeki');
        }

        $table = json_decode($area->data);        
        $res = []; 
        $calculations = $this->getCalculationMaxBest($id, 10);  
        $population0 = []; 
        foreach ($calculations AS $c) {
            $data = json_decode($c->data);
            $record = [
                "name" => $area->name,
                'level' => $c->level,
                'sum' => $c->obtainedresult,
                'points' => $this->calcpointer( $table, $data)
            ];
            $res[] = $record;
        }

        $areas = Area::where("river", $id)->get();
        foreach ($areas AS $ar) {
            $calculations = $this->getCalculationMaxBest($ar->id, 10);
            foreach ($calculations AS $c) {
                $data = json_decode($c->data);
                $record = [
                    "name" => $ar->name,
                    'level' => $c->level,
                    'sum' => $c->obtainedresult,
                    'points' => $this->calcpointer( $table, $data)
                ];
                $res[] = $record;            
            }
        }

        return view("showriver", ['calco' => $res ]);    

    }

    public function usedmethods($id) {
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $calco = Calculation::selectRaw('COUNT(id) AS count,  level, MAX(obtainedresult) as max, AVG(obtainedresult) as avg, typecalc')->where("area_id", $id)
        ->groupBy( 'level', 'typecalc')->orderBy("level", "asc")->orderBy("avg", "desc")->get()->toArray();
 
        return view("showselectedpopulation", ['calco' => $calco, "names" => $this->populationName ]);

    }

    public function calcMatrix($id, MutationData $mutation, GenetixDataGenerator $gtx, $nrM = null) {
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
 
        if ($nrM) {
            $mutation->setNrMutation($nrM);
        }

        set_time_limit(12000);
        $mutations = $mutation->getAllMethod();  
        $table = json_decode($area->data);
        $headPoints = $gtx->calcPoints($this->nrMaxPopulation, $table);

        $gtx->setPowerMatrixSize(10);  
        $power = $gtx->getPower([$table]);

        $bestResult = Calculation::where("area_id", $id)->orderBy("obtainedresult", "DESC")->take(1)->get();
 
        if (!$bestResult) {
            return redirect("/")->with('error', 'Brak obliczeń dla podanego area');
        }

        $lvlmax = Calculation::where("area_id", $id)->max("level");

        $mresults = [];
        foreach ($mutations AS $key => $method) {
   
            $population0 = [];
            $result = [0, 0];
          
            $cr = ["generation"];
            $population0[] = json_decode($bestResult[0]->data);
     
            $res = $mutation->addmutation($population0, $cr, $method);   
            $population0 = $gtx->usepower($res[0], $power);
            $res = $gtx->calcPopulation($population0, $headPoints, $res[1]);
 
            $sum = 0;
            $all = 0;
            $same = 0;
            $max = 0;

            $oldMaxResult = 0;
            $maxPoints = $gtx->getmaxPoints($this->nrMaxPopulation);

            foreach ($res AS $key2 => $calc) {
                 if ($calc['howitwascreated'] == "generation") {
                    $oldMaxResult = $calc['sum'];
                    break;
                 } 
            }
 
            foreach ($res AS $key3 => $calc) {
                
                if ($calc['howitwascreated'] == "generation") {
                    continue;
                }
                if ($max < $calc['sum']) {
                    $max = $calc['sum'];
                }
                if ($calc['sum'] > $oldMaxResult) {
                    $result[0]++;
                    if ($this->saveCalculationInCrossAndMuationMatrix && $oldMaxResult * $this->saveCrosMutationMatrix < $calc['sum']) {
                       $je = json_encode($calc['area']);                       
                       if (Calculation::where("area_id", $id)->where("data", $je)->count() == 0) {
                          Calculation::create(["result" => "Wynik dzięki mutacji ".$method , "data" => $je, "area_id" => $id, 
                            "level" => $lvlmax, "obtainedresult" => $calc['sum'] / $maxPoints,  "typecalc" => 21  ]);
                       }                    
                    }
                } else {
                    $result[1]++;
                    if ($calc['sum'] == $oldMaxResult) {
                       $same++;
                    }
                }
                $sum += $calc['sum'];
                $all++;
            }
            $mresults[] = [
               "key" => $key,
               "name" => $method,
               "res" => $result,
               "same" => $same,
               "max" => $max / $oldMaxResult,
               'calc' => ($sum / $all) / $oldMaxResult
            ];
           
        }
 
        Matrix::where("area_id", $id)->update(["hide" => 1]);
        foreach ($mresults AS $res) {
            $all = $res['res'][0] + $res['res'][1];
            $c = $res['res'][0] / $all;
            Matrix::create(["area_id" => $id, "key" => $res['key'], "name" => $res['name'], "result" => $c, "calc" => $res['calc'], "same" => $res['same'], "max" => $res['max']]);
        }

        return redirect("/")->with('success', 'Obliczono matrycę mutacji dla area: '.$id); 

    }

    public function showMatrix($id, Request $request) {
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }

        $order = $request->input('order');
        $desc = $request->input('desc');
        if (!$order) {
            $order = "result";
        }
        if (!$desc) {
            $desc = "DESC";
        }

        $matrix = Matrix::where("area_id", $id)->where("hide", 0)->orderBy($order, $desc)->get();
        return view("showmatrix", ['matrix' => $matrix, 'area' => $area, "order" => $order, "desc" => $desc]);
    }

    public function turnMatrix($id) {
        Area::where("id", $id)->update(["matrixtribe" => 1]);
        return redirect("/")->with('success', 'Włączono matrycę mutacji dla area: '.$id); 
    }

    public function turnoffMatrix($id) { 
        Area::where("id", $id)->update(["matrixtribe" => 0]);
        return redirect("/")->with('success', 'Wyłączono matrycę mutacji dla area: '.$id);         
    }

    public function turnofftwoMatrix($id) { 
        Area::where("id", $id)->update(["matrixtribe" => 2]);
        return redirect("/")->with('success', 'Wyłączono inny tryb matrycy: '.$id);         
    }    
     

    public function createweighingscale($id, GenetixDataGenerator $gtx) {
        set_time_limit(3600);
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $bestResult = Calculation::where("area_id", $id)->orderBy("obtainedresult", "DESC")->first();
        if (!$bestResult) {
            return redirect("/")->with('error', 'Brak obliczeń dla podanego area');
        }
        $data = json_decode($bestResult->data);
 
        $table = json_decode($area->data);
        $headPoints = $gtx->calcPoints($this->nrMaxPopulation, $table);
  
        $this->getdiffwaga($data, $headPoints, $id, $bestResult->id, $gtx);
        return redirect("/")->with('success', 'Obliczono wagę dla area: '.$id);   

    }

    private function getdiffwaga($data, $headPoints, $areaId, $cId, $gtx) {
        $weightDiffo = [];
        $diff = 0.4;
        $points = 0;
        $step = 0;
        $size = 10;
        $maxpoints = round(0.1 * $size * $size * $size);
        while ($points < $maxpoints && $step < 50) {
             $weightDiffo = $gtx->getWeightScale($data, $headPoints, $size, $diff);
             $step++;
             $points = $gtx->calcpointinarea($weightDiffo, $size);
             $diff = $diff / 1.3; 
        }
  
        Waga::create(["data" => json_encode($weightDiffo), "area_id" => $areaId, "calculation_id" => $cId ]); 

        return $weightDiffo;        
    }

    public function calcCrossMatrix($id, CrossingData $cross, GenetixDataGenerator $gtx, $nrM = null) {
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
 
        if ($nrM) {
            $cross->setNr($nrM);
        }

        set_time_limit(12000);
        $crossings = $cross->getAllMethod();  
        $table = json_decode($area->data);
        $headPoints = $gtx->calcPoints($this->nrMaxPopulation, $table);
        $bestResult = Calculation::where("area_id", $id)->orderBy("obtainedresult", "DESC")->take(20)->get();
 
        $lvlmax = Calculation::where("area_id", $id)->max("level");

        if (!$bestResult || count($bestResult) < 10) {
            return redirect("/")->with('error', 'Brak obliczeń dla podanego area');
        }
        $population0 = [];
        foreach ( $bestResult AS $c) {
            $population0[] = json_decode($c->data);
        }
        $gtx->setPowerMatrixSize(10);  
        $power = $gtx->getPower($population0);
        $headCalc = $gtx->calcPopulation($population0, $headPoints);
        $min = 0;
        $max = 0;
        foreach ($headCalc AS $c) {
           if ($c['sum'] > $max) {
              $max = $c['sum'];
           }
           if ($min == 0) {
              $min = $c['sum'];
           }
           if ($c['sum'] < $min) {
              $min = $c['sum'];
           }           
        }
        $maxPoints = $gtx->getmaxPoints($this->nrMaxPopulation);
        

        $mresults = [];
        foreach ($crossings AS $cr) {
            $pop_result = $cross->createNewPopulation($population0, $cr);
            $all = count($pop_result[0]);

            $pop_result[0] = $gtx->usepower($pop_result[0], $power);

            $res = $gtx->calcPopulation($pop_result[0], $headPoints);
            $record = [0, 0, 0];
            $mmax = 0;
            foreach ($res AS $row) {
                if ($row['sum'] < $min) {
                   $record[0]++;
                } elseif ($row['sum'] <= $max) {
                   $record[1]++;
                } else {
                   $record[2]++;
                }
                if ($row['sum'] >= $mmax) {
                    $mmax = $row['sum'];
                }

                if ($this->saveCalculationInCrossAndMuationMatrix && $max * $this->saveCrosMutationMatrix < $row['sum']) {
                        $je = json_encode($row['area']);
                        if (Calculation::where("area_id", $id)->where("data", $je)->count() == 0) {
                
                            Calculation::create(["result" => "Wynik dzięki krzyżowaniu ".$cr, "data" => $je, "area_id" => $id, 
                            "level" => $lvlmax, "obtainedresult" => $row['sum'] / $maxPoints,  "typecalc" => 25  ]);
                        }                  
                }                 
            }
            $mresults[] = [ 
               "name" => $cr,
               "area_id" => $id,
               "bad_result" => ($record[0] / $all),
               "middle_result" => ($record[1] / $all),                
               "best_result" => ($record[2] / $all),
               "max" => $mmax / $max,  
            ];
 
        }
 
       CrossMatrix::where("area_id", $id)->update(["hide" => 1]);
 
        foreach ($mresults AS $res) {
 
            CrossMatrix::create(["area_id" => $id, "name" => $res['name'], "max" => $res['max'],
               "bad_result" => $res['bad_result'], "middle_result" => $res['middle_result'], "best_result" => $res['best_result'] ]);
               
        }

        return redirect("/")->with('success', 'Obliczono matrycę krzyżowań dla area: '.$id); 

    }
 

    public function showCrossMatrix($id, Request $request) {
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }

        $order = $request->input('order');
        $desc = $request->input('desc');
        if (!$order) {
            $order = "max";
        }
        if (!$desc) {
            $desc = "DESC";
        }

        $matrix = CrossMatrix::where("area_id", $id)->where("hide", 0)->orderBy($order, $desc)->get();
        return view("showcrossmatrix", ['matrix' => $matrix, 'area' => $area, "order" => $order, "desc" => $desc]);
    }    

    public function setmatrixcross($id, $val) {
        Area::where("id", $id)->update(["matrixcross" => $val]);
        return redirect("/")->with('success', 'Włączono inny tryb matrycy krzyżowań dla: '.$id." VAL: ".$val);         
    }

    /*
       TRYBE
       0 - max level
       1 - 3 ostatnie levele
       2 - level++
       3 - wszystkie levele

    */
    public function calcareamoretimes($id, $trybe, GenetixDataGenerator $gtx, CrossingData $cross, MutationData $mutation, BigMutatorData $bigmutation) {
        set_time_limit(36000);
        ini_set('memory_limit', '200M');
 

        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }

        $random = 0;
 
        $lvlmax = Calculation::where("area_id", $id)->max("level");
        if (!$lvlmax) {
            $lvlmax = 1;
        }
        $lvlmin = $lvlmax;
 
        if ($trybe == 2) {
            $count = Calculation::where("area_id", $id)->where("level", $lvlmax)->count();
            if ($count < 20) {
                $trybe = 1;
            } else {
                $lvlmax++;
            }
        }

        if ($trybe == 1 || $trybe == 3) {
            if ($lvlmax > 5 && $trybe == 1) {
                $lvlmin = $lvlmax - 3;
            } else { 
                $lvlmin = 1;
            }
            $random = 1;
        }

        for ($i = 0; $i < $this->nrTimes; $i++) {
            $lvl = $lvlmax;
            if ($random) {
                $lvl = rand($lvlmin, $lvlmax);
            }
            $this->calcarea_level($id, $lvl, $gtx, $cross, $mutation, $bigmutation);
            $this->addpopulation = 0;
            $this->useBigMutator = 0;
        }
        echo "OK"; exit();
    }
    

    private function stereDiaomond($randomDoing, $mutation, $bigmutation) {
 
        if ($randomDoing == 130) {  // diamond - clone

            $calculations = $this->getDiamond($dId);
            $area = json_decode($calculations->data);
            $change = rand(1, 10);
            $res = $gtx->clonePattern($area, 1, $change);
            $population0 = [$area, $res[0]];
         

            $clones["calc_id"] = $calculations->id;
            $clones["oldresult"] = $calculations->obtainedresult;
            $clones["change"] = $change;
        } elseif ($randomDoing == 131) { // multiple clone

            $calculations = $this->getDiamond($dId);
            $area = json_decode($calculations->data);
            $change = rand(1, 10);
            $size = 10;
            $res = $gtx->clonePattern($area, $this->startPopulation, $change);
            $population0 = $res;
         
            
            $clones["calc_id"] = $calculations->id;
            $clones["oldresult"] = $calculations->obtainedresult;
            $clones["change"] = $change;     
        }  elseif ($randomDoing == 132) {  

            $calculations = $this->getDiamondCalculations($dId);           
            $population0 = [];  
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data);
            }
       
   
        } elseif ($randomDoing == 133) { 
            $calculations = $this->getDiamondCalculations($dId);  
            $population0 = [];
            $cr = [];
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data);
                $cr[] = "generation";
            }
             
            $res = $mutation->addmutation($population0, $cr);
            $res = $mutation->addmutation($res[0], $res[1]);
            $res = $mutation->addmutation($res[0], $res[1]);
            $population0 = $res[0];

        } elseif ($randomDoing == 134) { 
            $calculations = $this->getDiamond($dId);
            $area = json_decode($calculations->data);
            $population0 = [];
            $population0[] = $area;
            $cr = ["generation"];
 
            $res = $mutation->addmutation($population0, $cr);
            $res = $mutation->addmutation($res[0], $res[1]);
            $res = $mutation->addmutation($res[0], $res[1]);
            $population0 = $res[0];

        } elseif ($randomDoing == 135) {
            
            $calculations = $this->getDiamond($dId);
            $area = json_decode($calculations->data);
            $this->useBigMutator = 1;
            $bigmethod = $bigmutation->getRandomMethod();
            $population0 = $bigmutation->$bigmethod($this->startPopulation, 10, $area);
 
        } elseif ($randomDoing == 136) {
            
            $calculations = $this->getDiamond($dId);
            $area = json_decode($calculations->data);
            $this->useBigMutator = 2;
            $bigmethod = $bigmutation->getRandomMethod();
            $population0 = $bigmutation->$bigmethod($this->startPopulation, 10, $area);

        } elseif ($randomDoing == 137) {
            
            $calculations = $this->getDiamond($dId);
            $area = json_decode($calculations->data);
            $this->useBigMutator = 3;
            $bigmethod = $bigmutation->getRandomMethod();
            $this->funcMutator = $bigmutation->getIdFunc($bigmethod);
            $population0 = $bigmutation->$bigmethod($this->startPopulation, 10, $area);

        }   

        return [$population0, $clones];

    }


    private function getSteps($nr) {

       if ($this->Numhalstep <= 1) {
          return [];
       }
       $step = floor($nr / $this->Numhalstep);
       $res = [];
       $nem  = 0;
       while ($nem + $step < $nr) {
           $nem += $step;
           $res[] = $nem;
       }
       return $res;
   
    }

    private function calcBetter($sum, $res) {
        $result = 0;
        foreach ($res AS $rekord) {
            if ($rekord['sum'] > $sum) {
                $result++;
            } else {
                break;
            }
        }
        return $result;
    }

    public function changeFlex($id, $tr) {
        Area::where("id", $id)->update(["flex" => $tr]);
        return redirect("/")->with('success', 'Włączono Flex dla: '.$id." VAL: ".$tr);         
    }

    public function calcAllPowerSelect($id, GenetixDataGenerator $gtx, CrossingData $cross, MutationData $mutation, BigMutatorData $bigmutation) {
        set_time_limit(36000);
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $lvlmax = Calculation::where("area_id", $id)->max("level");

        $this->usingPower = 1;
        $this->randomDoingTrybe = 1;
        $this->selectUsingPowerNoBestData = 0;

        $maxPoints = $gtx->getmaxPoints($this->nrMaxPopulation);
        $maxPoints2 = $this->ls->getminimum($id, $lvlmax, 1);

        for ($i = 0; $i < $this->maxPopulation; $i++) {
            $result = $this->calcarea_level($id, $lvlmax,  $gtx, $cross, $mutation, $bigmutation);
            $res = $result[0];
            $best = $result[1];
            $selectId = $result[2];
            $checked = $best->obtainedresult * $maxPoints;
            $checked2 =  $maxPoints2  * $maxPoints;

            $max = 0;
            $sum = 0;
            $nr = 0;
            $more = 0;
            $more2 = 0;
            foreach ($res AS $r) {
                $sum += $r['sum'];
                if ($r['sum'] > $max) {
                    $max = $r['sum'];
                }
                if ($r['sum'] >= $checked) {
                    $more++;

                    Calculation::create(["result" => "Calculating powerMatrix", "data" => json_encode($r['area']), "area_id" => $id, "level" => $lvlmax, 
                            "obtainedresult" => $r['sum'] / $maxPoints, "typecalc" => 63 ]);

                }
                if ($r['sum'] >= $checked2) {
                    $more2++;
                }                
                $nr++; 

            }
            $avg = $sum / $nr;
            PowerSelect::create([
                "area_id" => $id,
                "lvl" => $lvlmax,
                "max" => $max / $maxPoints,
                "avg" => $avg / $maxPoints,
                "more" => $more,
                "more2" => $more2,
                "selectId" => $selectId
            ]);            
 
        }
         
        return redirect("/")->with('success', " Obliczono wybór populacji przez użycie matrycy siły ");  


    }

    public function showPowerSelect($id, Request $request) {
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
      
        $order = $request->input('order');
        $desc = $request->input('desc');
        if (!$order) {
            $order = "max";
        }
        if (!$desc) {
            $desc = "DESC";
        }

        $calco = PowerSelect::selectRaw('SUM(more) AS more, MAX(max) as max, AVG(avg) as avg, selectId, lvl')->where("area_id", $id)->groupBy('selectId', 'lvl')->orderBy("lvl", "DESC")->orderBy($order, $desc)->get()->toArray();
 
        return view("showpowerselect", ['calco' => $calco, 'area' => $area, "order" => $order, "desc" => $desc, "pname" => $this->populationName]);
    }

    private function debugInfo($res, $randomDoing) {
        echo $randomDoing."<br/>";
        foreach ($res AS $r) {
            echo $r['sum']."</br>";
        }
        exit();
 
    }

    public function bottomLastLayer($id) {
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $lvlmax = Calculation::where("area_id", $id)->max("level");
        $avg =  $this->ls->getAvg($id, $lvlmax );
        if (!$avg) {
             return redirect("/")->with('error', 'Nie znaleziono średniej ');
        }

        $calculations = Calculation::where("area_id", $id)->where("level", $lvlmax)->where("obtainedresult" , "<", $avg)->get();
        foreach ($calculations AS $c) {
            $lvl = $this->ls->getLvlinAvg($id, $c->obtainedresult);
            if ($lvl) {
                Calculation::where("id", $c->id)->update(["level" => $lvl]);
            }
        }
        $this->ls->calcarea($id);
        return redirect("/")->with('success', 'Zmieniono ostatni level');
    }
 
    public function onecalculation($id, GenetixDataGenerator $gtx) {
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
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data);
                $ids[] = $c->id;
            }
            $res = $gtx->calcPopulation($population0, $headPoints);
            unset($population0);
            foreach ($res AS $r) {
               Calculation::where("id", $ids[$r['id']])->update(["result2" => $r['sum'] / $maxPoints]);
            }  
            $calculations = Calculation::where("area_id", $id)->whereNull("result2")->take(200)->get();   
        }

        return redirect("/")->with('success', 'Przeliczono punkty na result2');

    }

    public function showselectigcalculations($id) {
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }

        $calco = Calculation::selectRaw('calculation, level, count(*) AS count ')->where("area_id", $id)->groupBy('calculation', 'level')->orderBy("level", "ASC")->orderBy("calculation", "DESC")->get()->toArray(); 
        $res = [];
        $levl = [];
        foreach ($calco AS $c) {
            $res[$c['level']][] = $c;
            if (isset($levl[$c['level']])) {
                $levl[$c['level']] += $c['count'];
            } else {
                $levl[$c['level']] = $c['count'];
            }
        }
 
        return view("showselectigcalculations", ['calco' => $res, "area" => $area, "levl" => $levl ]);

    }

}
