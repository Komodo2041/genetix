<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PowerSelect extends Model
{
    public $table = "powerselect";

    public $fillable = ["area_id", "lvl", "avg", "max", "more", "selectId"];

    public function area() {
          return $this->belongsTo("App\Models\Area", 'area_id');
    }

}
