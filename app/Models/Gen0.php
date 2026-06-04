<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gen0 extends Model
{
    public $table = "gen0";
    public $fillable = [ "area_id", "result", "population", "data" ];
}
