<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeknologiakTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('teknologiak')->delete();

        DB::table('teknologiak')->insert([
            'izena' => 'PHP',
            'desk' => 'Php datu basearen konexiak egiteko',
        ]);
      
        DB::table('teknologiak')->insert([
            'izena' => 'JavaScript',
            'desk' => 'JS Frontenda egiteko, botoien kontrolak...',
        ]);
      
        DB::table('teknologiak')->insert([
            'izena' => 'Blade.php',
            'desk' => 'Laraveleko View-ak egiteko',
        ]);
      
        DB::table('teknologiak')->insert([
            'izena' => 'Python',
            'desk' => 'Lenguaje de programación utilizado en diversos campos como desarrollo web, análisis de datos y machine learning',
        ]);
        
        DB::table('teknologiak')->insert([
            'izena' => 'React',
            'desk' => 'Biblioteca de JavaScript utilizada para construir interfaces de usuario interactivas',
        ]);
        
        DB::table('teknologiak')->insert([
            'izena' => 'Django',
            'desk' => 'Framework de desarrollo web de alto nivel en Python, que fomenta el desarrollo rápido y limpio',
        ]);
        
    }
}
