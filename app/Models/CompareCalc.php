<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompareCalc extends Model
{

    public $table = "comparecalc";
    public $fillable = ["calc_id", "head", "islike", "change"];

    public function calc()
    {
        return $this->belongsTo("App\Models\Calculation", 'calc_id');
    }
}
