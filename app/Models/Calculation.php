<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calculation extends Model
{
    public $table = "calculation";
    public $fillable = [
        "area_id",
        "result",
        "data",
        "level",
        "obtainedresult",
        "usedmod",
        "same",
        "nrcalc",
        "typecalc",
        "population",
        "calculation",
        "info",
        "progress",
        "start",
        "progcalc",
        "result2",
        "mule",
        "typecalc2",
        "pomcalc"
    ];

    public function area()
    {
        return $this->belongsTo("App\Models\Area", 'area_id');
    }

    public function compare()
    {
        return $this->hasOne(CompareCalc::class, "calc_id");
    }
}
