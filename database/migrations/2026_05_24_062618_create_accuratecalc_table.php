<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('accuratecalc', function (Blueprint $table) {
            $table->id();
            $table->integer("area_id");
            $table->integer("calc_id");
            $table->double("avg");
            $table->double("min");
            $table->double("max");
            $table->double("avgdiff");
            $table->double("actres");

            $table->foreign("calc_id")->references("id")->on("calculation");
            $table->foreign("area_id")->references("id")->on("area");
            $table->timestamps();
        });
    }

 
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accuratecalc');
    }
};
