<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelAvg extends Model
{
    public $table = "levelavg";
    public $fillable = ["area_id", "level", "avg"];

    public function area() {
        return $this->belongsTo("App\Models\Area", 'area_id');
    }

}
