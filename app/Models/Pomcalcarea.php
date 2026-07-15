<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pomcalcarea extends Model
{
    public $table = "pomcalcarea";
    public $fillable = ["area_id", "calc_id", "result", "change", "max", "calc2_id", "r2", "m"];
}
