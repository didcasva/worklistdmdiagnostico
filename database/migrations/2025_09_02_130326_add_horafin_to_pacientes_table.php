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
        $table->integer('numeroplacas')->nullable();   // Campo entero para numero de placas
        $table->string('observaciones')->nullable();  // Campo varcar para observaciones
        $table->time('horafin')->nullable();           // Campo time para hora fin
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pacientes', function (Blueprint $table) {
            $table->dropColumn(['numeroplacas', 'observaciones', 'horafin']);
        });
    }
};
