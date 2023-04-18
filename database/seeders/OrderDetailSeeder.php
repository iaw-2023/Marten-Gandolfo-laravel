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
                'product_ID' => '2',
                'units' => '1',
                'subtotal' => '2999.99'
            ],
            [
                'order_ID' => '1',
                'product_ID' => '5',
                'units' => '1',
                'subtotal' => '3999.99'
            ],
            [
                'order_ID' => '1',
                'product_ID' => '7',
                'units' => '1',
                'subtotal' => '4999.99'
            ],
            [
                'order_ID' => '2',
                'product_ID' => '16',
                'units' => '1',
                'subtotal' => '2999.99'
            ],
            [
                'order_ID' => '3',
                'product_ID' => '3',
                'units' => '1',
                'subtotal' => '1999.99'
            ],
            [
                'order_ID' => '3',
                'product_ID' => '5',
                'units' => '2',
                'subtotal' => '5999.99'
            ],
            [
                'order_ID' => '3',
                'product_ID' => '9',
                'units' => '2',
                'subtotal' => '5000'
            ],
            [
                'order_ID' => '3',
                'product_ID' => '12',
                'units' => '1',
                'subtotal' => '3000'
            ],
            [
                'order_ID' => '3',
                'product_ID' => '13',
                'units' => '1',
                'subtotal' => '2999.99'
            ],
            [
                'order_ID' => '3',
                'product_ID' => '15',
                'units' => '1',
                'subtotal' => '1999.99'
            ],
            [
                'order_ID' => '3',
                'product_ID' => '19',
                'units' => '2',
                'subtotal' => '500'
            ],
            [
                'order_ID' => '3',
                'product_ID' => '21',
                'units' => '2',
                'subtotal' => '7000'
            ],
            [
                'order_ID' => '3',
                'product_ID' => '24',
                'units' => '1',
                'subtotal' => '15000'
            ],
            [
                'order_ID' => '3',
                'product_ID' => '29',
                'units' => '1',
                'subtotal' => '499.99'
            ],
            [
                'order_ID' => '4',
                'product_ID' => '11',
                'units' => '2',
                'subtotal' => '5000'
            ]
        ]);
    }
}
