<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    public $table = "area";
    public $fillable = ["name", "data"];

    public function calculations() {
        return $this->hasMany("App\Models\Calculation", "area_id")->orderBy("level");
    } 

}
