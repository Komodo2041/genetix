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
        Schema::create('clones', function (Blueprint $table) {
            $table->id();
            $table->integer("calc_id");
            $table->integer("area_id");
            $table->double("oldresult");
            $table->double("result");
            $table->timestamps();

           $table->foreign("area_id")->references("id")->on("area");
           $table->foreign("calc_id")->references("id")->on("calculation");

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clones');
    }
};
