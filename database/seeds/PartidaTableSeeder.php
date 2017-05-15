<?php

use Illuminate\Database\Seeder;

class PartidaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Partida::class, 20)->create();
    }
}
