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
                'clien_ID' => '1',
                'order_date' => '01/03/2023',
                'order_time' => '12:00',
                'price' => '15999.99'
            ],
            [
                'clien_ID' => '1',
                'order_date' => '02/03/2023',
                'order_time' => '13:00',
                'price' => '16999.99'
            ],
            [
                'clien_ID' => '2',
                'order_date' => '03/03/2023',
                'order_time' => '14:00',
                'price' => '17999.99'
            ]
        ]);
    }
}
