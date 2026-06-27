<?php

namespace App\Console\Commands;

use App\Services\GenetixDataGenerator;
use App\Services\CrossingData;
use App\Services\MutationData;
use App\Services\Generation0Helper;

use App\Http\Controllers\Gen0Controller;

use Illuminate\Console\Command;

use App\Models\Gen0;

class CalcAdvGen0 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:calc-adv-gen0 {aid} {tryb=1} {nr=10}';

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
        $tryb = $this->argument('tryb');
        echo "Wlączono " . $aid . "  - ADV \n";
        $calc = new Gen0Controller();
        $results = null;
        if ($tryb == 1) {
            $results = Gen0::selectRaw("  count(id) AS count, prev AS id  ")->where("area_id", $aid)->whereIn("tryb", [23, 24])->groupBy("prev")
                ->havingRaw("SUM(CASE WHEN tryb = 23 THEN 1 ELSE 0 END) > 0")->havingRaw("SUM(CASE WHEN tryb = 24 THEN 1 ELSE 0 END) > 0")->get()->pluck("id")->toArray();
        } elseif ($tryb == 2) {
            $results = Gen0::selectRaw("  count(id) AS count, prev AS id  ")->where("area_id", $aid)->whereIn("tryb", [34, 35])->groupBy("prev")
                ->havingRaw("SUM(CASE WHEN tryb = 34 THEN 1 ELSE 0 END) > 0")->havingRaw("SUM(CASE WHEN tryb = 35 THEN 1 ELSE 0 END) > 0")->get()->pluck("id")->toArray();
        }

        if (count($results) == 0) {
            echo "Brak odp wylicze dla podanego Area";
            exit();
        }

        for ($i = 0; $i < $nr; $i++) {
            $gid = $results[rand(0, count($results) - 1)];
            echo $i . "-" . $gid . "\n";
            $calc->calcAdvGen0($gid, 0, $gen0, $cross, $mutation,  $gtx, $tryb);
        }
    }
}
