<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\MainController;

use App\Services\GenetixDataGenerator;
use App\Services\CrossingData;
use App\Services\MutationData; 
use App\Services\BigMutatorData;
 

class RunAreaCalc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-area-calc {tryb : Tryb} ';

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
        $trybe = $this->argument('tryb');
 
        $main = new MainController();
        $main->calcareamoretimes($id, $trybe, $gtx, $cross, $mutation, $bigmutation);
    }
}
