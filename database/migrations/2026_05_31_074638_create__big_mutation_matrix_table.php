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
        Schema::create('big_mutation_matrix', function (Blueprint $table) {
            $table->id();
            $table->integer("area_id");
            $table->integer("type");
            $table->integer("percent");
            $table->string("name");
            $table->double("max");
            $table->double("avg");
            $table->double("better");
            $table->boolean("hide")->default(0);
            $table->timestamps();

            $table->foreign("area_id")->references("id")->on("area");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('big_mutation_matrix');
    }
};
