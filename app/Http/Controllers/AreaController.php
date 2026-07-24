<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Calculation;
use App\Services\MeerDataGenerator;
use App\Http\Controllers\MainController;

class AreaController extends Controller
{

    private $main = null;

    public function __construct()
    {
        $this->main = new MainController();
    }

    public function list(Request $request, MeerDataGenerator $mdg)
    {

        $area = Area::with("calculations")->where("hide", 0)->get();

        $calco = Calculation::selectRaw('COUNT(id) AS count, area_id, level, MAX(obtainedresult) as max, AVG(obtainedresult) as avg')->groupBy('area_id', 'level')->orderBy("level")->get()->toArray();

        $areasMax = Calculation::selectRaw("area_id, Count(id) AS count  ")->where("obtainedresult", 1)->groupBy("area_id")->get()->pluck("count", "area_id")->toArray();

        $calcoData = [];
        foreach ($calco as $c) {
            $calcoData[$c["area_id"]][] = $c;
        }

        $save =  $request->input('save');
        if ($save) {
            $action = $request->input('action');
            switch ($action) {
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

        return view("main", ['area' => $area, 'calco' => $calcoData, "nrTimes" => $this->main->nrTimes, "areasMax" => $areasMax]);
    }


    public function hide($id)
    {
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $area->hide = 1;
        $area->save();
        Area::where("river", $id)->update(["hide" => 1]);
        return redirect("/")->with('success', 'Ukryto obszar');
    }


    public function changeFlex($id, $tr)
    {
        Area::where("id", $id)->update(["flex" => $tr]);
        return redirect("/")->with('success', 'Włączono Flex dla: ' . $id . " VAL: " . $tr);
    }

    public function turnOffJoiner($id)
    {
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $area->joinerjoiner = 0;
        $area->save();
        return redirect("/")->with('success', 'Wyłączono JoinerJoiner');
    }

    public function turnOnJoiner($id)
    {
        $area = Area::find($id);
        if (!$area) {
            return redirect("/")->with('error', 'Nie znaleziono podanego area');
        }
        $area->joinerjoiner = 1;
        $area->save();
        return redirect("/")->with('success', 'Włączono JoinerJoiner');
    }
}
