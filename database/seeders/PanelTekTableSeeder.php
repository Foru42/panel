<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PanelTekTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('panel_tek')->delete();

        DB::table('panel_tek')->insert([
            'panel_id' => 1, // ID del panel al que pertenece
            'tek_id' => 1, // ID de la tecnología asociada
            'tek_bertsioa' => 1,
        ]);

        DB::table('panel_tek')->insert([
            'panel_id' => 2, // ID del panel al que pertenece
            'tek_id' => 1, // ID de la tecnología asociada
            'tek_bertsioa' => 3, 
        ]);

        DB::table('panel_tek')->insert([
            'panel_id' => 3, // ID del panel al que pertenece
            'tek_id' => 3, // ID de la tecnología asociada
            'tek_bertsioa' => 3, 
        ]);
        DB::table('panel_tek')->insert([
            'panel_id' => 4,
            'tek_id' => 3,
            'tek_bertsioa' => 4,
        ]);
        
        DB::table('panel_tek')->insert([
            'panel_id' => 5,
            'tek_id' => 5,
            'tek_bertsioa' => 4,
        ]);
        DB::table('panel_tek')->insert([
            'panel_id' => 6,
            'tek_id' => 4,
            'tek_bertsioa' => 6,
        ]);

        DB::table('panel_tek')->insert([
            'panel_id' => 5,
            'tek_id' => 2,
            'tek_bertsioa' => 3,
        ]);



        DB::table('panel_tek')->insert([
            'panel_id' => 1, // ID del panel al que pertenece
            'tek_id' => 4, // ID de la tecnología asociada
            'tek_bertsioa' => 2,
        ]);

        DB::table('panel_tek')->insert([
            'panel_id' => 1, // ID del panel al que pertenece
            'tek_id' => 2, // ID de la tecnología asociada
            'tek_bertsioa' => 5, 
        ]);

        DB::table('panel_tek')->insert([
            'panel_id' => 1, // ID del panel al que pertenece
            'tek_id' => 6, // ID de la tecnología asociada
            'tek_bertsioa' => 2, 
        ]);
        DB::table('panel_tek')->insert([
            'panel_id' => 1, // ID del panel al que pertenece
            'tek_id' => 3, // ID de la tecnología asociada
            'tek_bertsioa' => 4, 
        ]);
        DB::table('panel_tek')->insert([
            'panel_id' => 1, // ID del panel al que pertenece
            'tek_id' => 1, // ID de la tecnología asociada
            'tek_bertsioa' => 6, 
        ]);
        DB::table('panel_tek')->insert([
            'panel_id' => 2, // ID del panel al que pertenece
            'tek_id' => 6, // ID de la tecnología asociada
            'tek_bertsioa' => 6, 
        ]);
        DB::table('panel_tek')->insert([
            'panel_id' => 3,
            'tek_id' => 5,
            'tek_bertsioa' => 1,
        ]);
        
        DB::table('panel_tek')->insert([
            'panel_id' => 4,
            'tek_id' => 5,
            'tek_bertsioa' => 4,
        ]);
        DB::table('panel_tek')->insert([
            'panel_id' => 6,
            'tek_id' => 3,
            'tek_bertsioa' => 6,
        ]);

        DB::table('panel_tek')->insert([
            'panel_id' => 5,
            'tek_id' => 4,
            'tek_bertsioa' => 5,
        ]);
    }
}
