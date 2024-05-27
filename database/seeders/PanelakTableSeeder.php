<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
                'so_id' => 1,
            ],
            [
                'izena' => 'Vaya Semanita',
                'desk' => 'Telebista programaren aplikazioa',
                'irudi' => 'img/vayaSemanita.jpg',
                'so_id' => 2,
            ],
            [
                'izena' => 'Goazen',
                'desk' => 'Goazen programaren aplikazioa',
                'irudi' => 'img/goazen80.jpg',
                'so_id' => 3,
            ],
            [
                'izena' => 'Teleberri',
                'desk' => 'EITB-eko albiste programa',
                'irudi' => 'img/teleberri.jpg',
                'so_id' => 4,
            ],
            [
                'izena' => 'Bideoak',
                'desk' => 'EITB-eko bideoen plataforma',
                'irudi' => 'img/bideoak.jpg',
                'so_id' => 5,
            ],
            [
                'izena' => 'EiTB a la Carta',
                'desk' => 'EITB-eko on-demand plataforma',
                'irudi' => 'img/eitbalaCarta.jpg',
                'so_id' => 2,
            ],
            [
                'izena' => 'Kantxa App',
                'desk' => 'Kantxa jokuen aplikazioa',
                'irudi' => 'img/kantxa.jpg',
                'so_id' => 3,
            ],
            [
                'izena' => 'Albisteak',
                'desk' => 'Albisteen plataforma',
                'irudi' => 'img/albisteak.jpg',
                'so_id' => 4,
            ],
            [
                'izena' => 'Musika',
                'desk' => 'Musika plataforma',
                'irudi' => 'img/musika.png',
                'so_id' => 5,
            ],
            [
                'izena' => 'Zinema',
                'desk' => 'Zinema aplikazioa',
                'irudi' => 'img/zinema.jpg',
                'so_id' => 1,
            ],
        ];

        DB::table('panelak')->insert($panelaks);
    }
}
