<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admin')->insert([
            [
                'username' => 'mati',
                'name' => 'Matias',
                'email' => 'matias@gmail.com',
                'password' => bcrypt('1234')
            ],
            [
                'username' => 'juan',
                'name' => 'Juan',
                'email' => 'juan@gmail.com',
                'password' => bcrypt('4321')
            ]
        ]);
    }
}
