<?php

namespace App\Http\Controllers;

use App\Services\MeerDataGenerator;
use App\Services\GenetixDataGenerator;
use App\Services\CrossingData;
use App\Services\MutationData; 
use App\Services\BigMutatorData;
 
use App\Services\LevelStering;
  
use Illuminate\Http\Request;

use App\Models\Area; 
use App\Models\Calculation; 
use App\Models\Clones;
use App\Models\Diamond;
use App\Models\Diamondcalc;
use App\Models\Matrix;
use App\Models\Waga;

use App\Models\CrossMatrix;
 
 
 
class MainController extends Controller
{

    public function __construct() {
        $this->ls = new LevelStering();
    }

    public $startPopulation = 800;
    public $useBigMutator = 0;
    public $funcMutator = 0;

    public $maxNumberInCalculation = 5;

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
       18 => "Use Waga Bigg",
       19 => "Use Waga Mini",
       20 => "Use Waga Very Mini",
       21 => "Calculating mutation matrix", // X
       22 => "Paratrooper", // X
       23 => "Use Only Mutations",
       24 => "Use non used calculations",
       25 => "Calculating crossing matrix", // X
       26 => "Use blob 6 Random to first generation",
       27 => "Use blob 3 Random to first generation",
    ];


    private function getRandomDoing() {
         $randomDoing = -1;
         while (in_array($randomDoing, [-1, 21, 22, 25])) {
             $randomDoing = rand(0, 27);
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
 
        return view("main", ['area' => $area, 'calco' => $calcoData]);
    }
 
    public function calcarea_level($id, $lvl, Request $request, GenetixDataGenerator $gtx, CrossingData $cross, MutationData $mutation, BigMutatorData $bigmutation, $dId = null) {
        
        set_time_limit(12000);
        $useonlyMutation = 0;

        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $table = json_decode($area->data);
        $headPoints = $gtx->calcPoints(120, $table);
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
        $randomDoing = 27;
        } else {
            $randomDoing = rand(30, 37);  
          //  $randomDoing = 33;
            $diamonds = ["diamond_id" => $dId];
        }

        $clones = ["area_id" => $id];
        $usedcalc = [];  

        $minimumCalc = $this->ls->getminimum($id, $lvl - 1);
    
        $individual = 10;
        $lvl = $lvl - 1;
        if ($lvl == 0) {
            
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
            $individual = 2;
                
        } elseif ($randomDoing == 3) {
         
            $calculations = $this->getCalculationLevel($id, $lvl, 50, 0);  
            $population0 = [];
            $number = rand(3, 10);
            $mostdifferent = $this->getmostdifferent($calculations, $number);  
            foreach ($mostdifferent AS $c) {
                $population0[] = json_decode($c->data);
                $usedcalc[] = $c->id;
            }
            $individual = count($population0);            
        } elseif ($randomDoing == 4) {
            $calculations = $this->getCalculationLevel($id, $lvl, 50, 0);
            $usedpercent = rand(70,99);
     
            $stiffPattern = $gtx->getStiffPattern($calculations, $usedpercent, 10);
 
            $population0 = $gtx->getStableGeneration(10, $this->startPopulation, $stiffPattern[0], $stiffPattern[1]);
 
        } elseif ($randomDoing == 5) { 
        
            $calculations = $this->getCalculationLevel($id, $lvl, 50, 0, 1);
            $usedpercent = rand(70,99);
     
            $stiffPattern = $gtx->getStiffPattern($calculations, $usedpercent, 10);
 
            $population0 = $gtx->getStableGeneration(10, $this->startPopulation, $stiffPattern[0], $stiffPattern[1]);

        } elseif ($randomDoing == 6) { // 10% change

            $change = 100;
            $calculations = $this->getCalculationLevel($id, $lvl, 5, 0);
            $tempplate = $gtx->getStiilPatern(10, $change);
 
            $population0 = $gtx->getPopulationFromStillTemplate(10, $this->startPopulation,  $tempplate, $calculations[0], $change);
             

        }  elseif ($randomDoing == 7) {  // clone

            $calculations = $this->getCalculationLevel($id, $lvl, 50, 0, 1);
            $area = json_decode($calculations[0]->data);
            $change = rand(1, 20);
            $res = $gtx->clonePattern($area, 1, $change);
            $population0 = [$area, $res[0]];
            $individual = count($population0);  

            $clones["calc_id"] = $calculations[0]->id;
            $clones["oldresult"] = $calculations[0]->obtainedresult;
            $clones["change"] = $change;

        }  elseif ($randomDoing == 8) { // multiple clone

            $calculations = $this->getCalculationLevel($id, $lvl, 50, 0);
            $area = json_decode($calculations[0]->data);
            $change = rand(1, 20);
            $size = rand(6, 12);
            $res = $gtx->clonePattern($area, $size, $change);
            $population0 = $res;
            $individual = count($population0);
            
            $clones["calc_id"] = $calculations[0]->id;
            $clones["oldresult"] = $calculations[0]->obtainedresult;
            $clones["change"] = $change;     

        } elseif ($randomDoing == 9) { // xz xy yz change

            $change = 100;
            $calculations = $this->getCalculationLevel($id, $lvl, 5, 0);
            $tempplate = $gtx->getStiilPaternXYZ(10);
 
            $population0 = $gtx->getPopulationFromStillTemplate(10, $this->startPopulation,  $tempplate, $calculations[0], $change);
 
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
            $area = json_decode($calculations[0]->data);
            $usedcalc[] = $calculations[0]->id;
            $population0 = $bigmutation->bigLayerMutation($this->startPopulation, 10, $area);

           $this->useBigMutator = 1;

        } elseif ($randomDoing == 12) {

            $calculations = $this->getCalculationLevel($id, $lvl, 10);  
            $population0 = [];
            foreach ($calculations AS $c) {
                $usedcalc[] = $c->id;
                $population0[] = json_decode($c->data);
            }
            $this->useBigMutator = 1;

        } elseif ($randomDoing == 13) {

            $calculations = $this->getCalculationLevel($id, $lvl, 10);  
            $population0 = [];
            foreach ($calculations AS $c) {
                $usedcalc[] = $c->id;
                $population0[] = json_decode($c->data);
            }
            $this->useBigMutator = 2;

        } elseif ($randomDoing == 14) {

            $calculations = $this->getCalculationLevel($id, $lvl, 10);  
            $population0 = [];
            foreach ($calculations AS $c) {
                $usedcalc[] = $c->id;
                $population0[] = json_decode($c->data);
            }
            $this->useBigMutator = 3;
            $this->funcMutator = $bigmutation->getIdFunc("bigLayerMutationCircle");
 
        } elseif ($randomDoing == 15) { // Join Rivers

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
            $individual = count($population0);
  
          
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
            $individual = count($population0);
  
            
        }  elseif ($randomDoing == 17 || $randomDoing == 18 || $randomDoing == 19 || $randomDoing == 20) {
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

            $individual = count($population0);  
            
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
 
            $population0 = $cross->goThrough($population0, "blob6random");
            
            $individual = count($population0);  
        } elseif ($randomDoing == 27) {

            $calculations = Calculation::where("area_id", $id)->orderBy("level", "DESC")->inRandomOrder()->take($this->startPopulation)->get();  
            $population0 = [];
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data);
            }
            $population0 = $cross->goThrough($population0, "blob3random");
            $individual = count($population0);  
        }



         /*** DIAMOND * **/
        elseif ($randomDoing == 30) {  // diamond - clone

            $calculations = $this->getDiamond($dId);
            $area = json_decode($calculations->data);
            $change = rand(1, 10);
            $res = $gtx->clonePattern($area, 1, $change);
            $population0 = [$area, $res[0]];
            $individual = count($population0);  

            $clones["calc_id"] = $calculations->id;
            $clones["oldresult"] = $calculations->obtainedresult;
            $clones["change"] = $change;
        } elseif ($randomDoing == 31) { // multiple clone

            $calculations = $this->getDiamond($dId);
            $area = json_decode($calculations->data);
            $change = rand(1, 10);
            $size = 10;
            $res = $gtx->clonePattern($area, $this->startPopulation, $change);
            $population0 = $res;
            $individual = count($population0);
            
            $clones["calc_id"] = $calculations->id;
            $clones["oldresult"] = $calculations->obtainedresult;
            $clones["change"] = $change;     
        }  elseif ($randomDoing == 32) {  

            $calculations = $this->getDiamondCalculations($dId);           
            $population0 = [];  
            foreach ($calculations AS $c) {
                $population0[] = json_decode($c->data);
            }
            $individual = count($population0);
   
        } elseif ($randomDoing == 33) { 
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

        } elseif ($randomDoing == 34) { 
            $calculations = $this->getDiamond($dId);
            $area = json_decode($calculations->data);
            $population0 = [];
            $population0[] = $area;
            $cr = ["generation"];
 
            $res = $mutation->addmutation($population0, $cr);
            $res = $mutation->addmutation($res[0], $res[1]);
            $res = $mutation->addmutation($res[0], $res[1]);
            $population0 = $res[0];

        } elseif ($randomDoing == 35) {
            
            $calculations = $this->getDiamond($dId);
            $area = json_decode($calculations->data);
            $this->useBigMutator = 1;
            $bigmethod = $bigmutation->getRandomMethod();
            $population0 = $bigmutation->$bigmethod($this->startPopulation, 10, $area);
 
        } elseif ($randomDoing == 36) {
            
            $calculations = $this->getDiamond($dId);
            $area = json_decode($calculations->data);
            $this->useBigMutator = 2;
            $bigmethod = $bigmutation->getRandomMethod();
            $population0 = $bigmutation->$bigmethod($this->startPopulation, 10, $area);

        } elseif ($randomDoing == 37) {
            
            $calculations = $this->getDiamond($dId);
            $area = json_decode($calculations->data);
            $this->useBigMutator = 3;
            $bigmethod = $bigmutation->getRandomMethod();
            $this->funcMutator = $bigmutation->getIdFunc($bigmethod);
            $population0 = $bigmutation->$bigmethod($this->startPopulation, 10, $area);

        }   

        if (count($population0) == 0) {
            return redirect("/")->with('error', "Pojawił się brak populacji dla random : ".$randomDoing);
        }

        if ($usedcalc) {
            Calculation::whereIn('id', $usedcalc)->increment('calculation');
        }
 
        $power = $gtx->getPower($population0);
        $res = $gtx->calcPopulation($population0, $headPoints);
        unset($population0);
 
        $maxQ = $res[0]['sum'];
        $oldQ = $res[0]['sum'];
        $maxQ2 = $res[1]['sum'];
        $oldQ2 = $res[1]['sum'];

        $repeatQ = 0;
        $maxPoints = $gtx->getmaxPoints(120);
        $nrPop = 0;
        $maxPop = 120;
 
        $usedmodify = [];
        $t3 = microtime(true);
          // HEAD LOOP

        while ($repeatQ < 40 && $nrPop < $maxPop && $maxQ < $maxPoints) {
            $selectedIndividuals = $gtx->getindyvidual($res, $individual);
        
            $individual = 10;
            $gtx->choosemodify($res, 10, $usedmodify);

            if ($this->useBigMutator > 0  && $nrPop % 2 == 1  ) {

                $pop_result = $bigmutation->createNewPopulation($selectedIndividuals, $this->useBigMutator, $this->funcMutator);

            } elseif ($useonlyMutation == 0) {
                $pop_result = $cross->createNewPopulation($selectedIndividuals);
                $newpopulaton = $gtx->usepower($pop_result[0], $power);
                $pop_result = $mutation->addmutation($newpopulaton, $pop_result[1]);
            } elseif ($useonlyMutation == 1) {
                
                $mutation->setNumerMutation($this->startPopulation);
                $pop_result = $mutation->addmutation($selectedIndividuals, []);
 
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
            $power = $gtx->getPowerfromarea($res);
            $oldQ = $maxQ;
            $oldQ2 = $maxQ2;
            $nrPop++;             
        }
        $t4 = microtime(true);
        arsort($usedmodify); 
       
       
        $result2 = $maxQ / $maxPoints; 
        if ($result2  > $minimumCalc) {
            $name = "Wynik w pokoleniu ".$nrPop." Wynik: ". $result2 ." Czas generacji ".($t4 - $t3)." s";
            $cred = Calculation::create(["result" => $name, "data" => json_encode($res[0]['area']), "area_id" => $id, "level" => $lvl + 1, "obtainedresult" => $result2,
            "usedmod" => json_encode($usedmodify), "typecalc" => $randomDoing, "population" => $nrPop ]);

            if ($randomDoing == 7 || $randomDoing == 8 || $randomDoing == 30 || $randomDoing == 31 ) {
                $clones["result"] = $result2;
            
                Clones::create($clones);
            } 
            if ( in_array($randomDoing, [30, 31, 32, 33, 34, 35, 36, 37])) {
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
                $calco = Calculation::create(["result" => "Spadocorniarz z ".($lvl + 1)." na level ".$lvlReso[0], "data" => json_encode($res[0]['area']), "area_id" => $id, "level" => $lvlReso[0],
                 "obtainedresult" => $result2, "typecalc" => 22 ]);
                $this->ls->saveCalco($calco->id, $lvlReso[1]); 
            }
            // TEST
            print_r($lvlReso); exit();
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


    public function samecalculations() {
        set_time_limit(600);
        
        $calculations = Calculation::where("same", null)->orderBy("id", "asc")->get();
        $used = [];
       
        foreach ($calculations AS $c) {
            if (in_array($c->id, $used)) {
                continue;                    
            }            
            $samecalculations = Calculation::where("data", $c->data)->where("id", "!=", $c->id)->get();
             
            if ($samecalculations->count() > 0) {
                foreach ($samecalculations AS $same) {
                    $used[] = $same->id;
                }
                Calculation::where("data", $c->data)->update(["same" => $c->id]);
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
        $headPoints = $gtx->calcPoints(120, $table);
        $bestResult = Calculation::where("area_id", $id)->orderBy("obtainedresult", "DESC")->take(1)->get();
 
        if (!$bestResult) {
            return redirect("/")->with('error', 'Brak obliczeń dla podanego area');
        }

        $mresults = [];
        foreach ($mutations AS $key => $method) {
            $population0 = [];
            $result = [0, 0];
          
            $cr = ["generation"];
            $population0[] = json_decode($bestResult[0]->data);
     
            $res = $mutation->addmutation($population0, $cr, $method);   
            $population0 = $res[0];
            $res = $gtx->calcPopulation($population0, $headPoints, $res[1]);
 
            $sum = 0;
            $all = 0;
            $same = 0;
            $max = 0;

            $oldMaxResult = 0;
            $maxPoints = $gtx->getmaxPoints(120);

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
                    if ($oldMaxResult * 1.000001 < $calc['sum']) {
                           
                       
                        Calculation::create(["result" => "Wynik dzięki mutacji ".$method , "data" => json_encode($calc['area']), "area_id" => $id, 
                        "level" => $bestResult[0]->level, "obtainedresult" => $calc['sum'] / $maxPoints,  "typecalc" => 21  ]);                      
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

    public function showMatrix($id ) {
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $matrix = Matrix::where("area_id", $id)->where("hide", 0)->orderBy("result", "DESC")->get();
        return view("showmatrix", ['matrix' => $matrix, 'area' => $area]);
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
        $headPoints = $gtx->calcPoints(120, $table);
  
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
        $headPoints = $gtx->calcPoints(120, $table);
        $bestResult = Calculation::where("area_id", $id)->orderBy("obtainedresult", "DESC")->take(10)->get();
 
        $lvlmax = Calculation::where("area_id", $id)->max("level");

        if (!$bestResult || count($bestResult) < 10) {
            return redirect("/")->with('error', 'Brak obliczeń dla podanego area');
        }
        $population0 = [];
        foreach ( $bestResult AS $c) {
            $population0[] = json_decode($c->data);
        }
       
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
        $maxPoints = $gtx->getmaxPoints(120);
        $mresults = [];
        foreach ($crossings AS $cr) {
            $pop_result = $cross->createNewPopulation($population0, $cr);
            $all = count($pop_result[0]);
            $res = $gtx->calcPopulation($pop_result[0], $headPoints);
            $record = [0, 0, 0];
            $mmax = 0;
            foreach ($res AS $row) {
                if ($row['sum'] < $min) {
                   $record[0]++;
                } elseif ($row['sum'] < $max) {
                   $record[1]++;
                } else {
                   $record[2]++;
                }
                if ($row['sum'] >= $mmax) {
                    $mmax = $row['sum'];
                }

                if ($max * 1.000001 < $row['sum']) {
                        Calculation::create(["result" => "Wynik dzięki krzyżowaniu ".$cr, "data" => json_encode($row['area']), "area_id" => $id, 
                        "level" => $lvlmax, "obtainedresult" => $row['sum'] / $maxPoints,  "typecalc" => 25  ]);                      
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
 

    public function showCrossMatrix($id ) {
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $matrix = CrossMatrix::where("area_id", $id)->where("hide", 0)->orderBy("max", "DESC")->get();
        return view("showcrossmatrix", ['matrix' => $matrix, 'area' => $area]);
    }    

    public function setmatrixcross($id, $val) {
        Area::where("id", $id)->update(["matrixcross" => $val]);
        return redirect("/")->with('success', 'Włączono inny tryb matrycy krzyżowań dla: '.$id." VAL: ".$val);         
    }


}
