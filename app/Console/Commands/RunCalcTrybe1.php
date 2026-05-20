<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\MainController;

use App\Services\GenetixDataGenerator;
use App\Services\CrossingData;
use App\Services\MutationData; 
use App\Services\BigMutatorData;


class RunCalcTrybe1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-calc-trybe1';

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
        $trybe = 1;
        $main = new MainController();
        $main->calcareamoretimes($id, $trybe, $gtx, $cross, $mutation, $bigmutation);
    }
}
