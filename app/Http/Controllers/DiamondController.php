<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Area; 
use App\Models\Calculation;
use App\Models\Diamond;
use App\Models\Diamondcalc;

class DiamondController extends Controller
{

       public $startPopulation = 800;

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

    public function stereDiaomond($randomDoing, $mutation, $bigmutation) {
 
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
            $bigmethod = $bigmutation->getRandomMethod();
            $population0 = $bigmutation->$bigmethod($this->startPopulation, 10, $area);
 
        } elseif ($randomDoing == 136) {
            
            $calculations = $this->getDiamond($dId);
            $area = json_decode($calculations->data);
            $bigmethod = $bigmutation->getRandomMethod();
            $population0 = $bigmutation->$bigmethod($this->startPopulation, 10, $area);

        }  

        return [$population0, $clones];

    }

}
