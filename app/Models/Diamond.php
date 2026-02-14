<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diamond extends Model
{
    public $table = "diamond";
    public $fillable = ["calc_id", "area_id" ];
}
