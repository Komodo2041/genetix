<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BigMutationMatrix extends Model
{
    public $table = "big_mutation_matrix";
    public $fillable = ["area_id", "name", "type", "percent", "max", "avg", "hide", "better"];

    public function area() {
        return $this->belongsTo("App\Models\Area", 'area_id');
    }
}
