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
        $table->integer('CCDkv')->nullable();   // Campo entero para Kv
        $table->integer('CCDmas')->nullable();  // Campo entero para mAs
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pacientes', function (Blueprint $table) {
        $table->dropColumn(['kv', 'mas']);
    });
    }
};
