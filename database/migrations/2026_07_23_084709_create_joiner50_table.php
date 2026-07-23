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
        Schema::create('joiner50', function (Blueprint $table) {
            $table->id();
            $table->integer("area_id");
            $table->integer("max");
            $table->integer("tryb");
            $table->double("res");
            $table->integer("same");
            $table->integer("samejoin");
            $table->integer("mindist");
            $table->integer("maxdist");
            $table->integer("firstdist");
            $table->double("param2");
            $table->double("param3");
            $table->timestamps();

            $table->foreign("area_id")->references("id")->on("area");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('joiner50');
    }
};
