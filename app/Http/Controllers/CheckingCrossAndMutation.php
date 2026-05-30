<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\GenetixDataGenerator;
use App\Services\CrossingData;
use App\Services\MutationData; 
use App\Services\BigMutatorData;
use App\Services\PowerBigMutator;

use App\Models\Area; 
use App\Models\Calculation;
use App\Models\Matrix;
use App\Models\CrossMatrix;
use App\Models\PowerSelect;
 

use App\Http\Controllers\MainController;

class CheckingCrossAndMutation extends Controller
{


    private $saveCrosMutationMatrix = 1.000001;
    private $saveCalculationInCrossAndMuationMatrix = 0;
    private $main = null;

    private $powerCalc = 120;
    public $nrMaxPopulation = 120;


    public function __construct() {  
        $this->main = new MainController();
    }

    public function mutations(CrossingData $cross, MutationData $mutation, BigMutatorData $bigmutation, PowerBigMutator $powermutation) {

        $calculations = Calculation::wherenull("nrcalc" )->wherenotnull("usedmod")->take(10)->orderBy("id", "desc")->get();
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
        $powermutations = $powermutation->getAllMethod();
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
        
        return view("mutations", ['mutations' => $result, "all" => $all, 'cross' => $crossings, 'mutaions' => $mutations, 'bigmutations' => $bigmutations, 'powermutations' => $powermutations,
           "nc" => implode(", ", $nonusedcross ), "nm" => implode(", ", $nonusedmutations )   ]);

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

        return redirect("/showMatrix/".$area->id)->with('success', 'Obliczono matrycę mutacji dla area: '.$id); 

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

        return redirect("/showCrossMatrix/".$area->id)->with('success', 'Obliczono matrycę krzyżowań dla area: '.$id); 

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

    public function calcAllPowerSelect($id, GenetixDataGenerator $gtx, CrossingData $cross, MutationData $mutation, BigMutatorData $bigmutation, PowerBigMutator $powermutation) {
        set_time_limit(36000);
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $lvlmax = Calculation::where("area_id", $id)->max("level");

        $this->main->usingPower = 1;
        $this->main->randomDoingTrybe = 1;
        $this->main->selectUsingPowerNoBestData = 0;

        $maxPoints = $gtx->getmaxPoints($this->nrMaxPopulation);
        $maxPoints2 = $this->main->ls->getminimum($id, $lvlmax, 1);

        for ($i = 0; $i < $this->powerCalc; $i++) {
            $result = $this->main->calcarea_level($id, $lvlmax,  $gtx, $cross, $mutation, $bigmutation, $powermutation);
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
                    $je = json_encode($r['area']);
                    if (Calculation::where("area_id", $id)->where("data", $je)->count() == 0) {
                        Calculation::create(["result" => "Calculating powerMatrix", "data" => $je, "area_id" => $id, "level" => $lvlmax, 
                                "obtainedresult" => $r['sum'] / $maxPoints, "typecalc" => 63 ]);
                    }
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
         
        return redirect("/showPowerSelect/".$area->id)->with('success', " Obliczono wybór populacji przez użycie matrycy siły ");  


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
        return view("showpowerselect", ['calco' => $calco, 'area' => $area, "order" => $order, "desc" => $desc, "pname" => $this->main->populationName]);
    }

}
