<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('units')->insert([
            //['nombre'=>'VENTANILLA UNICA','abreviatura'=>'VU','color'=>'#1F7087'],
            ['nombre'=>'CAJAS','abreviatura'=>'CAJAS','color'=>'#1F7087','imagen'=>'7.jpg','estado'=>'ACTIVO'],
            ['nombre'=>'VALORES','abreviatura'=>'VALORES','color'=>'#1F7087','imagen'=>'8.jpg','estado'=>'ACTIVO'],
            ['nombre'=>'VEHICULOS','abreviatura'=>'VEHICULOS','color'=>'#952175','estado'=>'INACTIVO','imagen'=>'2.jpg'],
            ['nombre'=>'INMUEBLES','abreviatura'=>'INMUEBLES','color'=>'#1F7087','estado'=>'INACTIVO','imagen'=>'3.jpg'],
            ['nombre'=>'INDUSTRIA COMERCIO','abreviatura'=>'IND COM','color'=>'#952175','estado'=>'INACTIVO','imagen'=>'4.jpg'],
            ['nombre'=>'ESPEC. PUBLICOS','abreviatura'=>'ESP','color'=>'#1F7087','estado'=>'INACTIVO','imagen'=>'5.jpg'],
            ['nombre'=>'MERCADOS','abreviatura'=>'MERC','color'=>'#952175','estado'=>'INACTIVO','imagen'=>'6.jpg'],
        ]);
    }
}
