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
                'order_date' => '01/03/2023',
                'order_time' => '12:00',
                'price' => '51999.97'
            ],
            [
                'client_ID' => '1',
                'order_date' => '02/03/2023',
                'order_time' => '13:00',
                'price' => '99999.99'
            ],
            [
                'client_ID' => '2',
                'order_date' => '03/03/2023',
                'order_time' => '14:00',
                'price' => '282999.88'
            ],
            [
                'client_ID' => '2',
                'order_date' => '04/03/2023',
                'order_time' => '15:00',
                'price' => '159999.98'
            ]
        ]);
    }
}
