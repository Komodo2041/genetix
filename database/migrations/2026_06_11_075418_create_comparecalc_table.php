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
        Schema::create('comparecalc', function (Blueprint $table) {
            $table->id();
            $table->integer("calc_id");
            $table->integer("head")->nullable();
            $table->integer("islike")->nullable();
            $table->integer("change")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comparecalc');
    }
};
