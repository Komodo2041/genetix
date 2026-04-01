<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matrix extends Model
{
    public $table = "matrix";
    public $fillable = ["area_id", "key", "name", "result", "calc"];

    public function area() {
        return $this->belongsTo("App\Models\Area", 'area_id');
    }
}
