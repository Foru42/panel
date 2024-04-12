<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PanelakTableSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        DB::table('panelak')->truncate(); // Elimina todos los registros de la tabla antes de insertar nuevos

        $panelaks = [
            [
                'izena' => 'Konquis App',
                'desk' => 'El Konkistadoreko telefono aplikazioa',
                'irudi' => 'img/conquis.jpg',
                'So_id' => 1,
            ],
            [
                'izena' => 'Vaya Semanita',
                'desk' => 'Telebista programaren aplikazioa',
                'irudi' => 'img/vayaSemanita.jpg',
                'So_id' => 2,
            ],
            [
                'izena' => 'Goazen',
                'desk' => 'Goazen programaren aplikazioa',
                'irudi' => 'img/goazen80.jpg',
                'So_id' => 3,
            ],
            [
                'izena' => 'Teleberri',
                'desk' => 'EITB-eko albiste programa',
                'irudi' => 'img/teleberri.jpg',
                'So_id' => 4,
            ],
            [
                'izena' => 'Bideoak',
                'desk' => 'EITB-eko bideoen plataforma',
                'irudi' => 'img/bideoak.jpg',
                'So_id' => 5,
            ],
            [
                'izena' => 'EiTB a la Carta',
                'desk' => 'EITB-eko on-demand plataforma',
                'irudi' => 'img/eitbalaCarta.jpg',
                'So_id' => 2,
            ],
        ];

        foreach ($panelaks as $panelak) {
            $panelak['created_at'] = $now;
            $panelak['updated_at'] = $now;
            DB::table('panelak')->insert($panelak);
        }
    }
}
