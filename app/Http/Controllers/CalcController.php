<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\GenetixDataGenerator;

use App\Models\Calculation;
use App\Models\Area;

class CalcController extends Controller
{

    public $nrMaxPopulation = 120;

    public function __construct() {  
        $this->main = new MainController();
    }

    public function list($id, Request $request ) {

        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }

        $calculations = Calculation::wherenotnull("info" )->where("info", "!=", "")->where("area_id", $id)->orderBy("id", "desc")->get();

        return view("calcres", ['area' => $area, 'calco' => $calculations]);
    }

    public function showprocess($id) {

        $calc = Calculation::find($id);
        if (!$calc) {
            return redirect("/")->with('error', 'Nie znaleziono podanego obliczenia');
        }
        $area = Area::find($calc->area_id);
        $res = json_decode($calc['info'], true);
 
        return view("progresscalc", ['area' => $area, 'res' => $res, 'calc' => $calc ]);
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
        return redirect("/calculations/".$area->id)->with('success', 'Szukano takich samych obliczeń. Znaleziono '.count($used)." takich samych obliczeń "); 
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

        return redirect("/calculations/".$area->id)->with('success', 'Przeliczono punkty na result2');

    }

    public function bottomLastLayer($id) {
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $lvlmax = Calculation::where("area_id", $id)->max("level");
        $avg =  $this->main->ls->getAvg($id, $lvlmax );
        if (!$avg) {
             return redirect("/")->with('error', 'Nie znaleziono średniej ');
        }

        $calculations = Calculation::where("area_id", $id)->where("level", $lvlmax)->where("obtainedresult" , "<", $avg)->get();
        foreach ($calculations AS $c) {
            $lvl = $this->main->ls->getLvlinAvg($id, $c->obtainedresult);
            if ($lvl) {
                Calculation::where("id", $c->id)->update(["level" => $lvl]);
            }
        }
        $this->main->ls->calcarea($id);
        return redirect("/calculations/".$area->id)->with('success', 'Zmieniono ostatni level');
    }    

    public function usedmethods($id) {
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $calco = Calculation::selectRaw('COUNT(id) AS count,  level, MAX(obtainedresult) as max, AVG(obtainedresult) as avg, typecalc')->where("area_id", $id)
        ->groupBy( 'level', 'typecalc')->orderBy("level", "asc")->orderBy("avg", "desc")->get()->toArray();
 
        return view("showselectedpopulation", ['calco' => $calco, "names" => $this->main->populationName, "area" => $area ]);

    }

    public function deleteSameCalc($id) {
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $same = Calculation::select('same')->where("area_id", $id)->whereNotNull('same')->distinct()->get();
        foreach ($same AS $s) {
            $first = Calculation::where("area_id", $id)->where("same", $s->same)->first();
            Calculation::where("area_id", $id)->where("same", $s->same)->where("id", "!=", $first->id)->delete();
        }
        Calculation::where("area_id", $id)->update(["same" => NULL]);
        return redirect("/calculations/".$area->id)->with('success', 'Usunięto takie same wyniki');
    }
 

}
