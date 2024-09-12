<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmpleadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('empleados')->insert([
            ['nombre'=>'VU','password'=>'VU','unit_id'=>1],
            ['nombre'=>'VE','password'=>'VE','unit_id'=>2],
            ['nombre'=>'IN','password'=>'IN','unit_id'=>3],
            ['nombre'=>'IC','password'=>'IC','unit_id'=>4],
            ['nombre'=>'EP','password'=>'EP','unit_id'=>5],
            ['nombre'=>'ME','password'=>'ME','unit_id'=>6]
        ]);
    }
}
