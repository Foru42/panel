<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SistemaOperativoTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('sistema_operativo')->delete();

        DB::table('sistema_operativo')->insert([
            'izena' => 'Ubuntu 18',
            'desk' => 'Laravel montado en esta version',
        ]);

        DB::table('sistema_operativo')->insert([
            'izena' => 'Docker',
            'desk' => 'Para desarrollo y despliegue',
        ]);

        DB::table('sistema_operativo')->insert([
            'izena' => 'Debian',
            'desk' => 'Para la parte del servidor',
        ]);

        DB::table('sistema_operativo')->insert([
            'izena' => 'Windows 10',
            'desk' => 'Sistema operativo comúnmente utilizado por los usuarios finales',
        ]);
        
        DB::table('sistema_operativo')->insert([
            'izena' => 'CentOS 7',
            'desk' => 'Sistema operativo Linux utilizado en servidores',
        ]);
        
        DB::table('sistema_operativo')->insert([
            'izena' => 'Android',
            'desk' => 'Sistema operativo móvil utilizado en dispositivos como smartphones y tablets',
        ]);
        
    }
}
