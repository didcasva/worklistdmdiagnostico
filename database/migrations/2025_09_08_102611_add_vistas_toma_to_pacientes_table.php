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
            $table->integer('CCIkv')->nullable();   // Campo entero para Kv CCI
            $table->integer('CCImas')->nullable();  // Campo entero para mAs CCI
            $table->integer('MLIkv')->nullable();   // Campo entero para Kv MLI
            $table->integer('MLImas')->nullable();  // Campo entero para mAs MLI
            $table->integer('MLDkv')->nullable();   // Campo entero para Kv MLD
            $table->integer('MLDmas')->nullable();  // Campo entero para mAs MMD
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pacientes', function (Blueprint $table) {
            $table->dropColumn(['CCIkv', 'CCImas', 'MLIkv', 'MLImas', 'MLDkv', 'MLDmas']);
        });
    }
};
