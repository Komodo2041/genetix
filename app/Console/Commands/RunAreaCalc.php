<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\MainController;

use App\Services\GenetixDataGenerator;
use App\Services\CrossingData;
use App\Services\MutationData; 
use App\Services\BigMutatorData;
use App\Services\PowerBigMutator;

use App\Models\CronSett;

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
    public function handle(GenetixDataGenerator $gtx, CrossingData $cross, MutationData $mutation, BigMutatorData $bigmutation, PowerBigMutator $pbm)
    {
        
        $trybe = $this->argument('tryb');
        
        $sett = CronSett::where("tryb", $trybe)->pluck("area_id")->toArray();
        if (count($sett)) {
           $id = $sett[rand(0, count($sett) - 1)];
           echo "Wybrano Area ".$id;
        } else {
           echo "Brak Area Dla tego Trybu ".$trybe;
           exit();    
        }
 
        $main = new MainController();
        $main->calcareamoretimes($id, $trybe, $gtx, $cross, $mutation, $bigmutation, $pbm);
    }
}
