<?php

namespace App\Http\Controllers;
 
use App\Services\GenetixDataGenerator;
use App\Services\CrossingData;
use App\Services\MutationData; 
use App\Services\BigMutatorData;
use App\Services\PowerBigMutator;

use App\Services\LevelStering;
use App\Services\MatrixHelper;
use App\Services\PopulationName;  
  
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
 
use App\Http\Controllers\DiamondController;

// COMAND :
// 0 - ostatni, 1 - 4 najlepsze lvl, 2 - next level, 3 -> wszystkie levele
// php artisan app:run-area-calc 0
// php artisan app:run-area-calc 1
// php artisan app:run-area-calc 2
// php artisan app:run-area-calc 3
// php artisan app:run-area-calc 4 
// php artisan app:run-area-calc 5
 
// php artisan app:onecalculation 82 240

class MainController extends Controller
{

    private $randomDoingTrybe = 0;

    public function __construct() {
        $this->ls = new LevelStering();
        $this->helperMatrix = new MatrixHelper();
        $pn = new PopulationName($this->randomDoingTrybe);
        $this->populationName = $pn->populationName;
        $this->pn = $pn;
    }
 
    private $debugInfo = 0;
 
    public $nrMaxPopulation = 120;

    public $startPopulation = 800;
    public $useBigMutator = 0;
    public $funcMutator = 0;

    public $usePowerMutator = 0;

    public $maxNumberInCalculation = 5;

    public $addpopulation = 0;
    public $additionalPopulationSize = 20;

    /*********** SETTING MAIN */
    public $Numhalstep = 2; // 2
    private $maxPopulation = 60;
    public $nrTimes = 8;
 
    
    private $selectUsingPowerNoBestData = 1;
 
    
    /***********TESTING RANDOM SELECTING ************/
    private $testRadomSelecting = 0;

    private $usingPower = 0;
 
    public function calcarea_level($id, $lvl,  GenetixDataGenerator $gtx, CrossingData $cross, MutationData $mutation, BigMutatorData $bigmutation, PowerBigMutator $powermutation, $dId = null) {
        
        set_time_limit(40000);
        // MORE MEMORY
       // ini_set('memory_limit', '250M');

        $halfStep = $this->helperMatrix->getSteps($this->maxPopulation, $this->Numhalstep);
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
            $randomDoing = $this->pn->getRandomDoing();
            if ($this->testRadomSelecting != 0) {
                $randomDoing = $this->testRadomSelecting;
            } 
 
        } else {
            $nrDiamond = count($this->pn->diamondCrossing);
            $randomDoing = $this->pn->diamondCrossing[rand(0, $nrDiamond - 1 )];         
            $diamonds = ["diamond_id" => $dId];
        }

        $clones = ["area_id" => $id];
        $usedcalc = [];  

        $minimumCalc = $this->ls->getminimum($id, $lvl - 1);
        $minimumCalc2 = $this->ls->getminimum($id, $lvl - 1, 1);
 
        $individual = 10;
        $lvl = $lvl - 1;
        $additionalPopulation = [];
        $population0 = [];

        if ($lvl <= 0 ) {
            
            $population0 = $gtx->getFirstGeneration(10, 1, $this->startPopulation);
            $randomDoing = 0;
    
        } elseif ($randomDoing == 0 || $lvl == 1) {
        
            $calculations = $this->getCalculationLevel($id, $lvl, 10);  
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data);
                $usedcalc[] = $c->id;
            }
            $randomDoing = -1;

        } elseif ($randomDoing == 1) {
          
            $calculations = $this->getCalculationLevel($id, $lvl, 5); 
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
            $mostdifferent = $this->helperMatrix->getmostdifferent($calculations, 2);  
            foreach ($mostdifferent AS $c) {
                $population0[] = json_decode($c->data);
                $usedcalc[] = $c->id;
            }
            
                
        } elseif ($randomDoing == 3) {
         
            $calculations = $this->getCalculationLevel($id, $lvl, 50, 0);
            $number = rand(3, 10);
            $mostdifferent = $this->helperMatrix->getmostdifferent($calculations, $number);  
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

        } elseif ( in_array($randomDoing, $this->pn->biglayerSelectingShort)) {

            $calculations = $this->getCalculationLevel($id, $lvl, 10);
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
  
            
        }  elseif ( in_array($randomDoing, $this->pn->wagaSelecting)) {
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
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data);
                $usedcalc[] = $c->id;
            }

        } elseif ($randomDoing == 26) {

            $calculations = Calculation::where("area_id", $id)->orderBy("level", "DESC")->inRandomOrder()->take($this->startPopulation)->get();
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data);
            }
            $power = $gtx->getPower($population0);
            $population0 = $cross->goThrough($population0, "blob6random");
            $population0 = $gtx->usepower($population0, $power);
 
        } elseif ($randomDoing == 27) {

            $calculations = Calculation::where("area_id", $id)->orderBy("level", "DESC")->inRandomOrder()->take($this->startPopulation)->get();
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data);
            }
            $power = $gtx->getPower($population0);
            $population0 = $cross->goThrough($population0, "blob3random");
            $population0 = $gtx->usepower($population0, $power);

        } elseif ($randomDoing == 28) {

            $calculations = $this->getCalculationLevel($id, $lvl, 10);
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
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data);
            }

            $power = $gtx->getPower($population0); 
            while (count($population0) > 80) {
                $population0 = $cross->goThrough($population0, "random50");
            } 
            $population0 = $gtx->usepower($population0, $power);


        } elseif ( in_array($randomDoing, $this->pn->selectUsingPower)) { 
        
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
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data);
                $usedcalc[] = $c->id;
            }


        } elseif ($randomDoing == 73) { 
        
            $calculations = $this->getCalculationLevel($id, $lvl, 10);
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data);
            }
            $power = $gtx->getPower($population0); 
            $population0 = $cross->createPopulationFromBloBFromLevel($population0, $this->startPopulation, 10, 1);
            $population0 = $gtx->usepower($population0, $power);

        }  elseif ($randomDoing == 74) { 
        
            $calculations = $this->getCalculationLevel($id, $lvl, 10);
            foreach ($calculations AS $c) {            
                $population0[] = json_decode($c->data);
            }
          
            $power = $gtx->getPower($population0); 
            $population0 = $cross->createPopulationFromBloBFromLevel($population0, $this->startPopulation, 10, 2);
            $population0 = $gtx->usepower($population0, $power);

        } elseif ($randomDoing == 75) { 
        
            $calculations = Calculation::where("area_id", $id)->where("level", "<=", $lvl)->orderBy("result2", "DESC")->orderBy("obtainedresult", "DESC")->take(200)->get();
            $calculations = $calculations->shuffle()->take(10);
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data);
            }
 
        } elseif ( in_array($randomDoing, $this->pn->avgdetailcalcSelecting)) {

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
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data);
                $usedcalc[] = $c->id;
            }
        
        } elseif ($randomDoing == 81) {

            $bestResult = Calculation::where("area_id", $id)->where("level", $lvl)->orderByRaw('RAND()')->first();
            $dataBest = json_decode($bestResult->data);
            $power = $gtx->getPower([$dataBest]);
            $pattern = $this->helperMatrix->getInversion($dataBest);
            $usepowerDetails = rand(1, 5);
            $population0 = $gtx->generatePopinPower($this->startPopulation, $pattern, $power, $usepowerDetails);

        } elseif ($randomDoing == 82) {

            $calculations = Calculation::where("area_id", $id)->where("level", "<=", $lvl)->whereIn("typecalc2", [81, 82])->orderBy('obtainedresult', "DESC")->take(20)->get();
            $calculations = $calculations->shuffle()->take(10);
            if (!$calculations) {
                $calculations = $this->getCalculationLevel($id, $lvl, 10);  
                $randomDoing = -1;
            }
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data);
                $usedcalc[] = $c->id;
            }        

        } elseif ($randomDoing == 83) {
 
            $calculations = $this->getCalculationLevel($id, $lvl, 2, 0, 1);
            $area2 = json_decode($calculations[0]->data);
            $power = $gtx->getPower([$area2]);
            $usedcalc[] = $calculations[0]->id;
            $population0 = $powermutation->powerBigLayerMutation100($this->startPopulation, 10, $area2);
            $population0 = $gtx->usepower($population0, $power);
            $this->usePowerMutator = 1;
 
        } elseif ( in_array($randomDoing, $this->pn->powerSelectingShort)) {

            $calculations = $this->getCalculationLevel($id, $lvl, 10);
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data);
            }
            if ($randomDoing == 84 || $randomDoing == 85 || $randomDoing == 86 || $randomDoing == 87 || $randomDoing == 88) {
               $this->usePowerMutator = 1;
            } elseif ($randomDoing == 89 || $randomDoing == 90 || $randomDoing == 91 || $randomDoing == 92 || $randomDoing == 93) {
               $this->usePowerMutator = 2;
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

        }  elseif ( in_array($randomDoing, $this->pn->diamondCrossing)) {

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
                
            } elseif ($this->usePowerMutator > 0  && $nrPop % 2 == 1  ) {

                $pop_result = $powermutation->createNewPopulation($selectedIndividuals, $this->usePowerMutator );
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
            $pgc = 0;
            if ($last > $first) {
                $pgc =  (1 - $result2) / ( ($last / $first) - 1);
            }
 
            $cred = Calculation::create(["result" => $name, "data" => json_encode($res[0]['area']), "area_id" => $id, "level" => $lvl + 1, "obtainedresult" => $result2,
            "usedmod" => json_encode($usedmodify), "typecalc" => $randomDoing, "population" => $nrPop, "info" => json_encode($info), "progress" => $last / $first, "start" => $first / $maxPoints,
            "progcalc" => $pgc]);

            if ($randomDoing == 7 || $randomDoing == 8 || $randomDoing == 130 || $randomDoing == 131 ) {
                $clones["result"] = $result2;
            
                Clones::create($clones);
            } 
            if ( in_array($randomDoing, $this->pn->diamondCrossing)) {
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
                
                $diff = $this->helperMatrix->checkedSameResultsinLine($usedcalculations, $res[$i]['area']);
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
                $pgc = 0;
                if ($last > $first) {
                    $pgc =  (1 - $result2) / ( ($last / $first) - 1);
                }
                $calco = Calculation::create(["result" => "Spadocorniarz z ".($lvl + 1)." na level ".$lvlReso[0]." (".$randomDoing.") ", "data" => json_encode($res[0]['area']), 
                "area_id" => $id, "level" => $lvlReso[0], "obtainedresult" => $result2, "typecalc" => 22, "population" => $nrPop, "start" => $first / $maxPoints, "result2" => $result2,
                  "progress" => $last / $first, "progcalc" => $pgc, "info" => json_encode($info), "typecalc2" => $randomDoing]);
                $this->ls->saveCalco($calco->id, $lvlReso[1]); 
            }
  
            return redirect("/")->with('error', "Zapisano słabe obliczenie w bazie danych ");
        }
 
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
 
    public function getCalculationMaxBest($id, $number) {
        return  Calculation::where("area_id", $id)->orderByDesc("obtainedresult" )->limit(max(0, $number))->get();
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
 
    /*
       TRYBE
       0 - max level
       1 - 3 ostatnie levele
       2 - level++
       3 - wszystkie levele
       4 - pierwszy level
    */
    public function calcareamoretimes($id, $trybe, GenetixDataGenerator $gtx, CrossingData $cross, MutationData $mutation, BigMutatorData $bigmutation, PowerBigMutator $pbm) {
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
                $lvlmin = $lvlmax - 4;
            } else { 
                $lvlmin = 1;
            }
            $random = 1;
        }

         if ($trybe == 4) {
            $lvlmax = 1;
         }
         if ($trybe == 5) {
            $lvlmax = 2;
         }

        for ($i = 0; $i < $this->nrTimes; $i++) {
            $lvl = $lvlmax;
            if ($random) {
                $lvl = rand($lvlmin, $lvlmax);
            }
            $this->calcarea_level($id, $lvl, $gtx, $cross, $mutation, $bigmutation, $pbm);
            $this->addpopulation = 0;
            $this->useBigMutator = 0;
            $this->usePowerMutator = 0;
        }
        echo "OK"; exit();
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
 
    private function debugInfo($res, $randomDoing) {
        echo $randomDoing."<br/>";
        foreach ($res AS $r) {
            echo $r['sum']."</br>";
        }
        exit();
 
    }
 
    public function setParamPopAndRandomDoing($m, $pop) {
        $this->maxPopulation = $pop;
        if (!$this->pn->checkRandomDoing($m)) {
           $m = 0;
        } 
        $this->testRadomSelecting = $m;
        $this->nrTimes = 1;
    }

    private function stereDiaomond($randomDoing, $mutation, $bigmutation) {
        $ds = new DiamondController();
        if ($randomDoing == 135) {
           $this->useBigMutator = 1;
        } elseif ($randomDoing == 136) {
           $this->useBigMutator = 2;
        }
        return $ds->stereDiaomond($randomDoing, $mutation, $bigmutation);

    }

}
