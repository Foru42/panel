<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SistemaOperativoTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('sistema_operativo')->truncate(); // Elimina todos los registros de la tabla antes de insertar nuevos

        $sistemasOperativos = [
            ['izena' => 'Ubuntu 18', 'desk' => 'Laravel montado en esta version'],
            ['izena' => 'Docker', 'desk' => 'Para desarrollo y despliegue'],
            ['izena' => 'Debian', 'desk' => 'Para la parte del servidor'],
            ['izena' => 'Windows 10', 'desk' => 'Sistema operativo comúnmente utilizado por los usuarios finales'],
            ['izena' => 'CentOS 7', 'desk' => 'Sistema operativo Linux utilizado en servidores'],
            ['izena' => 'Android', 'desk' => 'Sistema operativo móvil utilizado en dispositivos como smartphones y tablets'],
            // Agrega más datos según sea necesario
        ];

        foreach ($sistemasOperativos as $sistema) {
            // Añade las fechas de creación y actualización

            DB::table('sistema_operativo')->insert($sistema);
        }
    }
}
