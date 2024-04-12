<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PanelTekTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('panel_tek')->truncate(); // Elimina todos los registros de la tabla antes de insertar nuevos

        $panelTeks = [
            [
                'panel_id' => 1,
                'tek_id' => 1,
                'tek_bertsioa' => 1,
            ],
            [
                'panel_id' => 2,
                'tek_id' => 1,
                'tek_bertsioa' => 3,
            ],
            [
                'panel_id' => 3,
                'tek_id' => 3,
                'tek_bertsioa' => 3,
            ],
            [
                'panel_id' => 4,
                'tek_id' => 3,
                'tek_bertsioa' => 4,
            ],
            [
                'panel_id' => 5,
                'tek_id' => 5,
                'tek_bertsioa' => 4,
            ],
            [
                'panel_id' => 6,
                'tek_id' => 4,
                'tek_bertsioa' => 6,
            ],
            [
                'panel_id' => 5,
                'tek_id' => 2,
                'tek_bertsioa' => 3,
            ],
            // Agrega más datos según sea necesario
        ];

        foreach ($panelTeks as $panelTek) {
            // Añade las fechas de creación y actualización
            $panelTek['created_at'] = now();
            $panelTek['updated_at'] = now();

            DB::table('panel_tek')->insert($panelTek);
        }
    }
}
