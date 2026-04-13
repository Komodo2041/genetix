<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CrossMatrix extends Model
{
    public $table = "crossmatrix";
    public $fillable = ["area_id", "name", "bad_result", "middle_result", "best_result", "hide", "max"];

    public function area() {
        return $this->belongsTo("App\Models\Area", 'area_id');
    }
}
