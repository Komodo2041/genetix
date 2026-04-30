<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PowerMatrix extends Model
{
    public $table = "powermatrix";
    public $fillable = ["size", "data"];
}
