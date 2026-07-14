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
        Schema::table('pomcalcarea', function (Blueprint $table) {
            $table->integer("calc2_id")->nullable();
            $table->foreign("calc2_id")->references("id")->on("calculation");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pomcalcarea', function (Blueprint $table) {
            $table->dropColumn("calc2_id");
        });
    }
};
