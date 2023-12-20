<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product1 = [[
            'subcategory_id' => 1,
            'nama' => 'product1',
            'sku' => 'product1',
            'deskripsi' => 'product1',
            'gambar' => 'product1.png',
            'harga' => 1000,
            'stok'    => 10,
        ], [
            'subcategory_id' => 1,
            'nama' => 'product2',
            'sku' => 'product2',
            'deskripsi' => 'product2',
            'gambar' => 'product2.png',
            'harga' => 1000,
            'stok'    => 10,
        ]];
    }
}
