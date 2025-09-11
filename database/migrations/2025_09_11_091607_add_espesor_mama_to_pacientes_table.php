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
            $table->integer('CCDespesor')->nullable();
            $table->integer('MLDespesor')->nullable();
            $table->integer('CCIespesor')->nullable();
            $table->integer('MLIespesor')->nullable();
            $table->boolean('lado_derecho')->default(false);
            $table->boolean('lado_izquierdo')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pacientes', function (Blueprint $table) {
            $table->dropColumn(['CCDespesor', 'MLDespesor', 'CCIespesor', 'MLIespesor', 'lado_derecho', 'lado_izquierdo']);
        });
    }
};
