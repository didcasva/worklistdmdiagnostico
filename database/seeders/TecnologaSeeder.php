<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class TecnologaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tecnologa')->insert([
            ['CodigoRM' => 68953, 'NumDocumento' => 1085323235, 'NombreCompleto' => 'ANYELA BRISSETH MORALES QUIROZ'],
            ['CodigoRM' => 521670, 'NumDocumento' => 1121507834, 'NombreCompleto' => 'MONICA LORENA MUTUMBAJOY GOMEZ'],
            ['CodigoRM' => 521779, 'NumDocumento' => 1089031530, 'NombreCompleto' => 'ANA GABRIELA GOYES MORA'],
            ['CodigoRM' => 522668, 'NumDocumento' => 1088651988, 'NombreCompleto' => 'ELIANA MARICELA REINA CANCHALA'],
        ]);
    }
}
