<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeknologiaBertsioaTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('teknologia_bertsioa')->delete();
        
        DB::table('teknologia_bertsioa')->insert([
            'teknologia_id' => '1', // Nombre de la tecnología
            'izena' => '2.3', // Versión de la tecnología
        ]);

        DB::table('teknologia_bertsioa')->insert([
            'teknologia_id' => '2', // Nombre de la tecnología
            'izena' => '1.5', // Versión de la tecnología
        ]);

        DB::table('teknologia_bertsioa')->insert([
            'teknologia_id' => '3', // Nombre de la tecnología
            'izena' => '3.0', // Versión de la tecnología
        ]);

        DB::table('teknologia_bertsioa')->insert([
            'teknologia_id' => '4',
            'izena' => '2.3',
        ]);
        
        DB::table('teknologia_bertsioa')->insert([
            'teknologia_id' => '5',
            'izena' => '1.5',
        ]);
        
        DB::table('teknologia_bertsioa')->insert([
            'teknologia_id' => '3',
            'izena' => '3.0',

        ]);
        
    }
}
