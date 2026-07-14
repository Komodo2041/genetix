<?php

namespace App\Console\Commands;

use App\Services\GenetixDataGenerator;
use Illuminate\Console\Command;

use App\Http\Controllers\CalcController2;

class BigCrossing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:big-crossing {aid} {tryb} {nr}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(GenetixDataGenerator $gtx)
    {
        $tryb = $this->argument('tryb');
        $aid = $this->argument('aid');
        $nr = $this->argument('nr');
        echo "Wlaczono Big Crossing " . $aid . " tryb - " . $tryb . "\n";
        $calc = new CalcController2();

        for ($i = 0; $i < $nr; $i++) {
            echo $i . "\n";
            if ($tryb == 0) {
                $calc->bigcrossingtwocalc($aid, $gtx);
            } else {
                $calc->crossingOneLevel($aid, $gtx);
            }
        }
    }
}
