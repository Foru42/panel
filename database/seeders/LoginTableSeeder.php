<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('usuarios')->delete();
        
        DB::table('usuarios')->insert([
            'username' => 'kepa',
            'password' => Hash::make('111'),
        ]);

        DB::table('usuarios')->insert([
            'username' => 'mikel',
            'password' => Hash::make('222'),

        ]);
        DB::table('usuarios')->insert([
            'username' => 'antxon',
            'password' => Hash::make('333'),

        ]);
    }
}
