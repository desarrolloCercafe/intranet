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
        $this->call(FormularioCebaSeeder::class);
        $this->call(FormularioMortalidadPreceboCeba::class);
        $this->call(FormularioPreceboSeeder::class);
        $this->call(FormularioDestetosSemanaSeeder::class);
        $this->call(FormularioDesteteFinalizacionSeeder::class);
    }
}
