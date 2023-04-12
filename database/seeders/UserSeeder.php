<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Matias',
                'username' => 'mati',
                'email' => 'matias@gmail.com',
                'password' => bcrypt('1234')
            ],
            [
                'name' => 'Juan',
                'username' => 'juan',
                'email' => 'juan@gmail.com',
                'password' => bcrypt('4321')
            ]
        ]);
    }
}
