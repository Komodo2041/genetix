<?php

namespace App\Console\Commands;

use App\Services\GenetixDataGenerator;
use App\Services\CrossingData;
use App\Services\MutationData;
use App\Services\Generation0Helper;

use App\Http\Controllers\CalcController2;

use Illuminate\Console\Command;

class upDownGenZ extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:up-down-gen-z {id}, {up=0}';

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
        $aid = $this->argument('id');
        $up = $this->argument('up');
        echo "Wlączono " . $aid . "  - UP OR DOWN \n";
        $calc = new CalcController2();

        $calc->calcUp50OneGen0($aid, $up, $gen0, $cross, $mutation,  $gtx);
    }
}
