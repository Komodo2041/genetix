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
        Schema::create('calculation', function (Blueprint $table) {
            $table->id();
            $table->integer("area_id");
            $table->string("result");
            $table->text("data");
            $table->timestamps();

            $table->foreign("area_id")->references("id")->on("area");

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calculation');
    }
};
