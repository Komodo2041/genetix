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
        Schema::create('crossmatrix', function (Blueprint $table) {
            $table->id();

        
            $table->integer("area_id"); 
            $table->string("name");

            $table->double("bad_result");
            $table->double("middle_result");
            $table->double("best_result");
            $table->boolean("hide")->default(0);
            $table->double("max");

            $table->timestamps();
            $table->foreign("area_id")->references("id")->on("area");
 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crossmatrix');
    }
};
