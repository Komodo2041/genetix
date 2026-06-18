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

class TamaCalc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:tama-calc {aid} {nr=6}';

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
        $aid = $this->argument('aid');
        $nr = $this->argument('nr');

        $main = new MainController();
        $main->testRadomSelecting = 108;
        $main->nrTimes = 1;

        $area = Area::find($aid);
        if ($area->tama == 0) {
            echo "Nie wybrano tamy";
            exit();
        }

        for ($i = 0; $i < $nr; $i++) {
            echo "\n" . $i . "\n";
            $main->calcareamoretimes($aid, 4, $gtx, $cross, $mutation, $bigmutation, $pbm, $gen0);
        }
    }
}
