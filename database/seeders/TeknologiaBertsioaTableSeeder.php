<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeknologiaBertsioaTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('teknologia_bertsioa')->truncate(); // Elimina todos los registros de la tabla antes de insertar nuevos

        $teknologiaBertsioa = [
            ['teknologia_id' => '1', 'izena' => '2.3'],
            ['teknologia_id' => '2', 'izena' => '1.5'],
            ['teknologia_id' => '3', 'izena' => '3.0'],
            ['teknologia_id' => '4', 'izena' => '2.3'],
            ['teknologia_id' => '5', 'izena' => '5.9.1'],
            ['teknologia_id' => '3', 'izena' => '4.0'],
            // Agrega más datos según sea necesario
        ];

        foreach ($teknologiaBertsioa as $teknologia) {
            // Añade las fechas de creación y actualización
            $teknologia['created_at'] = now();
            $teknologia['updated_at'] = now();

            DB::table('teknologia_bertsioa')->insert($teknologia);
        }
    }
}
