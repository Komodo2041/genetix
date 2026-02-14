<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diamondcalc extends Model
{
    public $table = "diamondcalc";
    public $fillable = ["diamond_id", "calc_id", "result" ];
}
