<?php

namespace App\Console\Commands;

use App\Services\GenetixDataGenerator;
use App\Services\CrossingData;
use App\Services\MutationData;
use App\Services\Generation0Helper;

use App\Http\Controllers\Gen0Controller;

use Illuminate\Console\Command;

class calcGen0XYZ extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:calc-gen0-x-y-z {aid} {nr}';

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
        $nr = $this->argument('nr');
        echo "Wlaczono " . $aid . " XYZ - \n";
        $calc = new Gen0Controller();
        for ($i = 0; $i < $nr; $i++) {
            echo $i . "\n";
            $calc->calc3DimGen0($aid, $gen0, $cross, $mutation,  $gtx);
        }
    }
}
