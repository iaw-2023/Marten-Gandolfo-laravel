<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('order_details')->insert([
            [
                'order_ID' => '1',
                'product_ID' => '1',
                'units' => '3'
            ],
            [
                'order_ID' => '1',
                'product_ID' => '2',
                'units' => '1'
            ],
            [
                'order_ID' => '1',
                'product_ID' => '3',
                'units' => '2'
            ],
            [
                'order_ID' => '2',
                'product_ID' => '4',
                'units' => '5'
            ],
            [
                'order_ID' => '2',
                'product_ID' => '5',
                'units' => '1'
            ],
            [
                'order_ID' => '3',
                'product_ID' => '1',
                'units' => '3'
            ],
        ]);
    }
}
