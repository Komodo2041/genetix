<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clones extends Model
{
    public $table = "clones";
    public $fillable = ["calc_id", "area_id", "oldresult", "result", "change" ];
}
