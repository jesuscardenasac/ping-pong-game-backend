<?php

use Illuminate\Database\Seeder;

class JuegoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Juego::class, 10)->create();
    }
}
