<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CronSett extends Model
{
    public $table = "cronsett";
    public $fillable = ["area_id", "tryb" ];
}
