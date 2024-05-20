<?php

namespace Database\Seeders;

use Database\Seeders\PanelakTableSeeder;
use Database\Seeders\PanelTekTableSeeder;
use Database\Seeders\RolesTableSeeder;
use Database\Seeders\SistemaOperativoTableSeeder;
use Database\Seeders\TeknologiaBertsioaTableSeeder;
use Database\Seeders\TeknologiakTableSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(RolesTableSeeder::class);
        $this->call(LoginTableSeeder::class);
        $this->call(TeknologiakTableSeeder::class);
        $this->call(SistemaOperativoTableSeeder::class);
        $this->call(PanelakTableSeeder::class);
        $this->call(TeknologiaBertsioaTableSeeder::class);
        $this->call(PanelTekTableSeeder::class);

    }
}
