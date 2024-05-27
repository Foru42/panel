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
            ['izena' => '2.3'],
            ['izena' => '1.5'],
            ['izena' => '3.0'],
            ['izena' => '2.3'],
            ['izena' => '5.9.1'],
            ['izena' => '4.0'],
            ['izena' => '1.0'],
            ['izena' => '2.1'],
            ['izena' => '3.5'],
            ['izena' => '4.2'],
        ];

        DB::table('teknologia_bertsioa')->insert($teknologiaBertsioa);
    }
}
