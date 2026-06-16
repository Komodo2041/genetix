<?php

namespace App\Console\Commands;

use App\Services\GenetixDataGenerator;
use App\Services\CrossingData;
use App\Services\MutationData;
use App\Services\Generation0Helper;

use App\Http\Controllers\CalcController2;

use Illuminate\Console\Command;

class calcGen0Ciag extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:calc-gen0_ciag {aid} {dim=0}';

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

        $aid = $this->argument('aid');
        $dim = $this->argument('dim');
        echo "Wlaczono " . $aid . " Dim - " . $dim . "\n";
        $calc = new CalcController2();
        $calc->calcAltGen0($aid, $dim, $gen0, $cross, $mutation,  $gtx);
    }
}
