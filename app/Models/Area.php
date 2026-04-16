<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    public $table = "area";
    public $fillable = ["name", "data", "hide", "river", "matrixcross"];

    public function calculations() {
        return $this->hasMany("App\Models\Calculation", "area_id")->orderBy("level");
    }

    public function diamonds() {
        return $this->hasMany("App\Models\Diamond", "area_id");
    }

    public function levelsavg() {
        return $this->hasMany("App\Models\LevelAvg", "area_id");
    }

    public function mutationmatrix() {
        return $this->hasMany("App\Models\Matrix", "area_id");
    }       

}
