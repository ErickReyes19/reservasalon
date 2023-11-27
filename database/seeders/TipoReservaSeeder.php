<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoReservaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Insertar registros en la tabla tipo_reserva
        DB::table('tipo_reserva')->insert([
            ['nombre' => 'salon'],
            ['nombre' => 'externa'],
        ]);
    }
}
