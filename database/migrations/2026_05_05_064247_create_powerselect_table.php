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
        Schema::create('powerselect', function (Blueprint $table) {
            $table->id();
            $table->integer("area_id");
            $table->integer("lvl");
            $table->double("avg");
            $table->double("max");
            $table->integer("more");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('powerselect');
    }
};
