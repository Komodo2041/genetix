<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\MainController;

use App\Services\GenetixDataGenerator;
use App\Services\CrossingData;
use App\Services\MutationData;
use App\Services\BigMutatorData;

use App\Services\PowerBigMutator;
use App\Services\Generation0Helper;
use App\Models\Area;

class onecalculation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:onecalculation {method : Opis metody} {nrpop : Opis NrPop}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(GenetixDataGenerator $gtx, CrossingData $cross, MutationData $mutation, BigMutatorData $bigmutation, PowerBigMutator $pbm, Generation0Helper $gen0)
    {

        $m = $this->argument('method');
        $pop = $this->argument('nrpop');
        $id = 0;

        $sett = Area::where("cronmatrix", 1)->pluck("area_id")->toArray();
        if (count($sett)) {
            $id = $sett[rand(0, count($sett) - 1)];
            echo "Wybrano Area " . $id . "\n";
        } else {
            echo "Brak ID ";
            exit();
        }

        $main = new MainController();
        $main->setParamPopAndRandomDoing($m, $pop);

        $main->calcareamoretimes($id, 1, $gtx, $cross, $mutation, $bigmutation, $pbm, $gen0);
    }
}
