<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Services\GenetixDataGenerator;
use App\Services\CrossingData;
use App\Services\MutationData;
use App\Services\Generation0Helper;

use App\Http\Controllers\CalcController;

class calcGen0 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:calc-gen0 {aid} {tryb}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(GenetixDataGenerator $gtx, CrossingData $cross, MutationData $mutation,  Generation0Helper $gen0)
    {
       $tryb = $this->argument('tryb');
       $aid = $this->argument('aid');
       echo "Wlaczono ".$aid." tryb - ".$tryb."\n";
       $calc = new CalcController();

       if ($tryb == 8 || $tryb == 9 || $tryb == 10) {
          if ($tryb == 8) {
             $tryb = 5;
          }
          if ($tryb == 9) {
             $tryb = 6;
          }
          if ($tryb == 10) {
             $tryb = 7;
          }                    
          $calc->manyrepeat = 1;
          $calc->maxPopulation = 10;
          for ($i = 0; $i < 50; $i++) {
            echo $i."\n";
            $calc->calcGeneration0($aid, $tryb, $gen0, $cross, $mutation,  $gtx);
          }
       } else {
          $calc->calcGeneration0($aid, $tryb, $gen0, $cross, $mutation,  $gtx);
       }
 
       
        

    }
}
