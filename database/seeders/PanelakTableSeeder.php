<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PanelakTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('panelak')->delete();

        DB::table('panelak')->insert([
            'izena' => 'Konquis App',
            'desk' => 'El Konkistadoreko telefono aplikazioa',
            'irudi' => 'img/conquis.jpg',
            'So_id' => '1',
             
        ]);

        DB::table('panelak')->insert([
            'izena' => 'Vaya Semanita',
            'desk' => 'Telebista programaren aplikazioa',
            'irudi' => 'img/vayaSemanita.jpg',
            'So_id' => '2',
        ]); 
        
        DB::table('panelak')->insert([
            'izena' => 'Goazen',
            'desk' => 'Goazen programaren aplikazioa',
            'irudi' => 'img/goazen80.jpg',
            'So_id' => '3',
        ]);

        DB::table('panelak')->insert([
            'izena' => 'Teleberri',
            'desk' => 'EITB-eko albiste programa',
            'irudi' => 'img/teleberri.jpg',
            'So_id' => '4',

        ]);
        
        DB::table('panelak')->insert([
            'izena' => 'Bideoak',
            'desk' => 'EITB-eko bideoen plataforma',
            'irudi' => 'img/bideoak.jpg',
            'So_id' => '5',

        ]);
        
        DB::table('panelak')->insert([
            'izena' => 'EiTB a la Carta',
            'desk' => 'EITB-eko on-demand plataforma',
            'irudi' => 'img/eitbalaCarta.jpg',
            'So_id' => '2',

        ]);
    }
}
