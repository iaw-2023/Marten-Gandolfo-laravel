<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('clients')->insert([
            [
                'email' => 'matias@gmail.com',
                'password' => bcrypt('1234')
            ],
            [
                'email' => 'juan@gmail.com',
                'password' => bcrypt('1234')
            ]
        ]);
    }
}
