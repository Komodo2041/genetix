<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Http\Controllers\CheckingCrossAndMutation;
use App\Services\GenetixDataGenerator;
use App\Services\CrossingData;

class random50MultipleCalcAllTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:random50-multiple-calc-all-time {aid} {nr}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(GenetixDataGenerator $gtx, CrossingData $cross)
    {
        $nr = $this->argument('nr');
        $aid = $this->argument('aid');

        $calc = new CheckingCrossAndMutation();

        for ($i = 0; $i < $nr; $i++) {
            echo $i . "\n";
            $calc->showrandom50Multiple($aid, $cross, $gtx);
        }
    }
}
