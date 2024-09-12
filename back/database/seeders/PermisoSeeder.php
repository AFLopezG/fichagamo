<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('permisos')->insert([
            ["nombre"=>"GESTION USUARIOS"],
            ["nombre"=>"ATENCION CAJA"],
        ]);
    }
}
