<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\MainController;

use App\Services\GenetixDataGenerator;
use App\Services\CrossingData;
use App\Services\MutationData; 
use App\Services\BigMutatorData;

class onecalculation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:onecalculation {method : Selecting} {nrpop: NrPop}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(GenetixDataGenerator $gtx, CrossingData $cross, MutationData $mutation, BigMutatorData $bigmutation)
    {
        $id = 16;
        $m = $this->argument('method');
        $pop = $this->argument('nrpop');
 
        $main = new MainController();
        $main->setParamPopAndRandomDoing($m, $pop);
     
        $main->calcareamoretimes($id, 1, $gtx, $cross, $mutation, $bigmutation);
    }
}
