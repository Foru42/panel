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
                'fav' => 'false',
            ],
            [
                'panel_id' => 2,
                'tek_id' => 1,
                'tek_bertsioa' => 3,
                'fav' => 'false',
            ],
            [
                'panel_id' => 3,
                'tek_id' => 3,
                'tek_bertsioa' => 3,
                'fav' => 'false',
            ],
            [
                'panel_id' => 4,
                'tek_id' => 3,
                'tek_bertsioa' => 4,
                'fav' => 'false',
            ],
            [
                'panel_id' => 5,
                'tek_id' => 5,
                'tek_bertsioa' => 4,
                'fav' => 'false',
            ],
            [
                'panel_id' => 6,
                'tek_id' => 4,
                'tek_bertsioa' => 6,
                'fav' => 'false',
            ],
            [
                'panel_id' => 5,
                'tek_id' => 2,
                'tek_bertsioa' => 3,
                'fav' => 'false',
            ],
            // Agrega más datos según sea necesario
        ];

        // Añade las fechas de creación y actualización

        DB::table('panel_tek')->insert($panelTeks);

    }
}
