<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('users')->insert([
            ["cuenta"=>"ADM","caja"=>"","name"=>"Administrador","email"=>"admin@gamo.com",'password'=>Hash::make('admin123Admin')],
            ["cuenta"=>"CAJA1","caja"=>"CAJA1","name"=>"CAJERO 1","email"=>"c1@gamo.com",'password'=>Hash::make('C1')],
            ["cuenta"=>"CAJA2","caja"=>"CAJA2","name"=>"CAJERO 2","email"=>"c2@gamo.com",'password'=>Hash::make('C2')],
            ["cuenta"=>"CAJA3","caja"=>"CAJA3","name"=>"CAJERO 3","email"=>"c3@gamo.com",'password'=>Hash::make('C3')],
            ["cuenta"=>"CAJA4","caja"=>"CAJA4","name"=>"CAJERO 4","email"=>"c4@gamo.com",'password'=>Hash::make('C4')],
            ["cuenta"=>"CAJA5","caja"=>"CAJA5","name"=>"CAJERO 5","email"=>"c5@gamo.com",'password'=>Hash::make('C5')],
            ["cuenta"=>"CAJA6","caja"=>"CAJA6","name"=>"CAJERO 6","email"=>"c6@gamo.com",'password'=>Hash::make('C6')],
            ["cuenta"=>"CAJA7","caja"=>"CAJA7","name"=>"CAJERO 7","email"=>"c7@gamo.com",'password'=>Hash::make('C7')],
            ["cuenta"=>"CAJA8","caja"=>"CAJA8","name"=>"CAJERO 8","email"=>"c8@gamo.com",'password'=>Hash::make('C8')],
            ["cuenta"=>"CAJA9","caja"=>"CAJA9","name"=>"CAJERO 9","email"=>"c9@gamo.com",'password'=>Hash::make('C9')],
            /*["cuenta"=>"VE","caja"=>"CAJA2","name"=>"Vehiculos","email"=>"ve@gamo.com",'password'=>Hash::make('VE')],
            ["cuenta"=>"IN","caja"=>"CAJA3","name"=>"Inmuebles","email"=>"ie@gamo.com",'password'=>Hash::make('IN')],
            ["cuenta"=>"IC","caja"=>"CAJA4","name"=>"Industria Comercio","email"=>"ic@gamo.com",'password'=>Hash::make('IC')],
            ["cuenta"=>"EP","caja"=>"CAJA5","name"=>"Espectaculos Publicos","email"=>"ep@gamo.com",'password'=>Hash::make('EP')],
            ["cuenta"=>"ME","caja"=>"CAJA6","name"=>"Mercados","email"=>"me@gamo.com",'password'=>Hash::make('ME')],
            ["cuenta"=>"VA","caja"=>"CAJA7","name"=>"Valores","email"=>"va@gamo.com",'password'=>Hash::make('VA')],
            ["cuenta"=>"BA","caja"=>"CAJA8","name"=>"Cajas","email"=>"ca@gamo.com",'password'=>Hash::make('BA')],*/
        ]);
    }
}
