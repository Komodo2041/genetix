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

class calcPattern extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:calc-pattern {aid}';

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
        $rivers = Area::where("river", $aid)->where("hide", 0)->whereNotNull("pattern")->get()->pluck("id")->toArray();
        $count = count($rivers);
        if ($count == 0) {
            echo "Brak River";
            exit();
        }


        $main = new MainController();
        $main->testRadomSelecting = 107;
        for ($i = 0; $i < 6; $i++) {
            echo $i . "\n";
            $id = $rivers[rand(0, count($rivers) - 1)];
            $main->calcareamoretimes($id, 0, $gtx, $cross, $mutation, $bigmutation, $pbm, $gen0);
        }
    }
}
