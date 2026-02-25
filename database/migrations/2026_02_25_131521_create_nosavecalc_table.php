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
        Schema::create('nosavecalc', function (Blueprint $table) {
            $table->id();
            $table->integer("area_id");
            $table->integer("level");
            $table->double("result");
            $table->double("avginlevel");
            $table->integer("type");
            $table->timestamps();

            $table->foreign("area_id")->references("id")->on("area");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nosavecalc');
    }
};
