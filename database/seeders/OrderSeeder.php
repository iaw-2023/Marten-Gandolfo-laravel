<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('orders')->insert([
            [
                'client_ID' => '1',
                'order_date' => '01-03-2023 12:00:00'
            ],
            [
                'client_ID' => '1',
                'order_date' => '02-03-2023 13:00:00'
            ],
            [
                'client_ID' => '2',
                'order_date' => '03-03-2023 14:00:00'
            ],
            [
                'client_ID' => '2',
                'order_date' => '04-03-2023 15:00:00'
            ]
        ]);
    }
}
