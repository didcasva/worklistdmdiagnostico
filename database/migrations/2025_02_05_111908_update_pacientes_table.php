<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('Pacientes', function (Blueprint $table) {
            $table->string('Cedula', 60)->nullable()->change();
            $table->string('Entidad', 100)->nullable()->change();
            $table->string('Nombre_Completo', 120)->nullable()->change();
            $table->string('Direccion', 120)->nullable()->change();
            $table->string('Tipo_Documento', 20)->nullable()->change();
            $table->string('Rh', 3)->nullable()->change();
            $table->string('Lugar', 100)->nullable();
        });
    }

    public function down()
    {
        Schema::table('Pacientes', function (Blueprint $table) {
            $table->string('Cedula', 50)->nullable(false)->change(); // Reemplaza con la longitud anterior si era diferente
            $table->string('Entidad', 50)->nullable(false)->change(); // Ajusta según el tamaño original
            $table->string('Nombre_Completo', 100)->nullable(false)->change(); // Ajusta según el tamaño original
            $table->string('Direccion', 100)->nullable(false)->change(); // Ajusta según el tamaño original
            $table->string('Tipo_Documento', 10)->nullable(false)->change(); // Ajusta según el tamaño original
            $table->string('Rh', 3)->nullable(false)->change(); // Ajusta según el tamaño original
            $table->dropColumn('Lugar');
        });
    }
};
