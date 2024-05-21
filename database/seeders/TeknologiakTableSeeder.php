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
            ['izena' => 'Blade.php', 'desk' => 'Laraveleko View ak egiteko'],
            ['izena' => 'Python', 'desk' => 'Hainbat eremutan erabiltzen den programazio-lengoaia, hala nola web-garapenean, datuen analisian eta machine learningean.'],
            ['izena' => 'React', 'desk' => 'JavaScripten liburutegia, erabiltzaile-interfaze interaktiboak eraikitzeko erabiltzen dena'],
            ['izena' => 'Django', 'desk' => 'Goi mailako web-garapeneko framework-a Python-en, garapen azkarra eta garbia sustatzen duena'],

        ];

        foreach ($teknologiak as $teknologia) {

            DB::table('teknologiak')->insert($teknologia);
        }
    }
}
