<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calculation extends Model
{
    public $table = "calculation";
    public $fillable = ["area_id", "result", "data", "level", "obtainedresult", "usedmod"];

    public function area() {
          return $this->belongsTo("App\Models\Area", 'area_id');
    }

}
