<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'category_ID' => '1',
                'product_name' => 'producto1',
                'product_description' => 'producto1descripcion',
                'product_brand' => 'marca1',
                'product_price' => '3999.99',
                'product_official_site' => 'sitio1.com',
                'product_image' => 'imagen1.jpg'
            ],
            [
                'category_ID' => '1',
                'product_name' => 'producto2',
                'product_description' => 'producto2descripcion',
                'product_brand' => 'marca2',
                'product_price' => '4999.99',
                'product_official_site' => 'sitio2.com',
                'product_image' => 'imagen2.jpg'
            ],
            [
                'category_ID' => '2',
                'product_name' => 'producto3',
                'product_description' => 'producto3descripcion',
                'product_brand' => 'marca1',
                'product_price' => '5999.99',
                'product_official_site' => 'sitio1.com',
                'product_image' => 'imagen3.jpg'
            ],
            [
                'category_ID' => '3',
                'product_name' => 'producto4',
                'product_description' => 'producto4descripcion',
                'product_brand' => 'marca3',
                'product_price' => '6999.99',
                'product_official_site' => 'sitio3.com',
                'product_image' => 'imagen4.jpg'
            ],
            [
                'category_ID' => '2',
                'product_name' => 'producto5',
                'product_description' => 'producto5descripcion',
                'product_brand' => 'marca1',
                'product_price' => '7999.99',
                'product_official_site' => 'sitio1.com',
                'product_image' => 'imagen5.jpg'
            ]
        ]);
    }
}
