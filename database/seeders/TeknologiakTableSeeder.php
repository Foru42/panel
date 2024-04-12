<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeknologiakTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('teknologiak')->truncate(); // Elimina todos los registros de la tabla antes de insertar nuevos

        $teknologiak = [
            ['izena' => 'PHP', 'desk' => 'Php datu basearen konexiak egiteko'],
            ['izena' => 'JavaScript', 'desk' => 'JS Frontenda egiteko, botoien kontrolak...'],
            ['izena' => 'Blade.php', 'desk' => 'Laraveleko View-ak egiteko'],
            ['izena' => 'Python', 'desk' => 'Lenguaje de programación utilizado en diversos campos como desarrollo web, análisis de datos y machine learning'],
            ['izena' => 'React', 'desk' => 'Biblioteca de JavaScript utilizada para construir interfaces de usuario interactivas'],
            ['izena' => 'Django', 'desk' => 'Framework de desarrollo web de alto nivel en Python, que fomenta el desarrollo rápido y limpio'],
            // Agrega más datos según sea necesario
        ];

        foreach ($teknologiak as $teknologia) {

            DB::table('teknologiak')->insert($teknologia);
        }
    }
}
