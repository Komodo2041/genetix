<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Waga extends Model
{
    public $table = "waga";
    public $fillable = ["area_id", "calculation_id", "data"];

    public function area() {
        return $this->belongsTo("App\Models\Area", 'area_id');
    }

}
