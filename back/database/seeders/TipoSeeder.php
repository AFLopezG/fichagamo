<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('tipos')->insert([
            //['nombre'=>'VENTANILLA UNICA','abreviatura'=>'VU','color'=>'#1F7087'],
            ['nombre'=>'PUBLICO GENERAL','codigo'=>'G','orden'=>'2', 'icono'=>'person','icono2'=>''],
            ['nombre'=>'PREFERENCIAL','codigo'=>'P','orden'=>'1','icono'=>'elderly','icono2'=>'pregnant_woman'],
        ]);
    }
}
