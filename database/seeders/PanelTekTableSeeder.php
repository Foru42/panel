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
            [
                'panel_id' => 7,
                'tek_id' => 1,
                'tek_bertsioa' => 2,
            ],
            [
                'panel_id' => 8,
                'tek_id' => 2,
                'tek_bertsioa' => 1,
            ],
            [
                'panel_id' => 9,
                'tek_id' => 3,
                'tek_bertsioa' => 2,
            ],
            [
                'panel_id' => 10,
                'tek_id' => 5,
                'tek_bertsioa' => 3,
            ],
        ];

        // Añade las fechas de creación y actualización

        DB::table('panel_tek')->insert($panelTeks);

    }
}
