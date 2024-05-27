<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SistemaOperativoTableSeeder extends Seeder
{
    public function run()
    {

        DB::table('sistema_operativo')->truncate(); // Elimina todos los registros de la tabla antes de insertar nuevos

        $sistemasOperativos = [
            ['izena' => 'Ubuntu 18', 'desk' => 'Laravel bertsio honetan muntatua'],
            ['izena' => 'Docker', 'desk' => 'Garatzeko eta hedatzeko'],
            ['izena' => 'Debian', 'desk' => 'Zerbitzariaren zatirako'],
            ['izena' => 'Windows 10', 'desk' => 'Azken erabiltzaileek erabili ohi duten sistema eragilea'],
            ['izena' => 'CentOS 7', 'desk' => 'Zerbitzarietan erabilitako Linux sistema eragilea'],
            ['izena' => 'Android', 'desk' => 'Smartphone eta tabletak bezalako gailuetan erabiltzen den sistema eragile mugikorra'],
            ['izena' => 'iOS', 'desk' => 'Apple-ren gailu mugikorretarako sistema eragilea'],
            ['izena' => 'macOS', 'desk' => 'Apple-ren ordenagailuetarako sistema eragilea'],
            ['izena' => 'Fedora', 'desk' => 'Red Hat-ek garatutako Linux banaketa'],
            ['izena' => 'Arch Linux', 'desk' => 'Minimalista eta erabiltzaile aurreratuei zuzendutako Linux banaketa'],
        ];

        DB::table('sistema_operativo')->insert($sistemasOperativos);
    }
}
