<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('usuarios')->truncate(); // Elimina todos los registros antes de insertar nuevos

        $usuarios = [
            [
                'username' => 'kepa',
                'password' => Hash::make('111'),
                'Gmail' => 'Seeder@gmail.com',
            ],
            [
                'username' => 'mikel',
                'password' => Hash::make('222'),
                'Gmail' => 'Seeder@gmail.com',
            ],
            [
                'username' => 'antxon',
                'password' => Hash::make('333'),
                'Gmail' => 'Seeder@gmail.com',
            ],
        ];

        foreach ($usuarios as $usuario) {
            DB::table('usuarios')->insert($usuario);
        }
    }
}
