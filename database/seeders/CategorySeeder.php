<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Teclado'],          // 1
            ['name' => 'Mouse'],            // 2
            ['name' => 'Monitor'],          // 3
            ['name' => 'Gabinete'],         // 4
            ['name' => 'Procesador'],       // 5
            ['name' => 'Placa de video'],   // 6
            ['name' => 'Memoria RAM'],      // 7
            ['name' => 'Memoria ROM'],      // 8
            ['name' => 'Motherboard'],      // 9
            ['name' => 'Fuente']            // 10
        ]);
    }
}
