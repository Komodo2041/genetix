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
        Schema::table('gen0', function (Blueprint $table) {
            $table->integer("tryb");
            $table->text("changes");
            $table->boolean("worked");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gen0', function (Blueprint $table) {
            $table->dropColumn("tryb");
            $table->dropColumn("changes");
            $table->dropColumn("worked");
        });
    }
};
