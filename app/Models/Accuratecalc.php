<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accuratecalc extends Model
{
    public $table = "accuratecalc";
    public $fillable = ["area_id", "calc_id", "avg", "min", "max", "avgdiff", "actres"];
 
    public function area() {
        return $this->belongsTo("App\Models\Area", 'area_id');
    }

    public function calculation() {
        return $this->belongsTo("App\Models\Calculation", 'calc_id');
    }
    
}
