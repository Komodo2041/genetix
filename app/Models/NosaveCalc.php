<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NosaveCalc extends Model
{
    public $table = "nosavecalc";
    public $fillable = ["area_id", "level", "result", "avginlevel", "type", "calc_id"];

    public function area() {
        return $this->belongsTo("App\Models\Area", 'area_id');
    }


}
