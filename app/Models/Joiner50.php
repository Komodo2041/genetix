<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Joiner50 extends Model
{
    public $table = "joiner50";
    public $fillable = ["area_id", "max", "tryb", "res", "same", "samejoin", "mindist", "maxdist", "firstdist", "param2", "param3", "better"];

    public function area()
    {
        return $this->belongsTo("App\Models\Area", 'area_id');
    }
}
