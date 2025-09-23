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
        Schema::table('pacientes', function (Blueprint $table) {
            $table->float('CCDdosis')->nullable();
            $table->float('MLDdosis')->nullable();
            $table->float('CCIdosis')->nullable();
            $table->float('MLIdosis')->nullable();
            $table->float('total_dosis')->nullable(); // Nueva columna para la dosis total
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pacientes', function (Blueprint $table) {
            $table->dropColumn(['CCDdosis', 'MLDdosis', 'CCIdosis', 'MLIdosis']);
        });
    }
};
