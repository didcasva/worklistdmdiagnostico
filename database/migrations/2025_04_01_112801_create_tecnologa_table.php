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
        Schema::create('tecnologa', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('CodigoRM')->unique();
            $table->bigInteger('NumDocumento')->unique();
            $table->string('NombreCompleto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tecnologa');
    }
};
