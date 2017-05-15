<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(SolicitudesTableSeeder::class);
        $this->call(PartidaTableSeeder::class);
        $this->call(JuegoTableSeeder::class);
    }
}
