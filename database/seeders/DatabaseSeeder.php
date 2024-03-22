<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\TeknologiakTableSeeder;
use Database\Seeders\PanelakTableSeeder;
use Database\Seeders\SistemaOperativoTableSeeder;
use Database\Seeders\TeknologiaBertsioaTableSeeder;
use Database\Seeders\PanelTekTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(LoginTableSeeder::class);
        $this->call(TeknologiakTableSeeder::class);
        $this->call(SistemaOperativoTableSeeder::class);
        $this->call(PanelakTableSeeder::class);
        $this->call(TeknologiaBertsioaTableSeeder::class);
        $this->call(PanelTekTableSeeder::class);
    }
}
