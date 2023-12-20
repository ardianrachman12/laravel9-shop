<?php

namespace Database\Seeders;

use App\Models\Subcategory;
use Illuminate\Database\Seeder;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sub1 = [
            [
                'category_id' => 1,
                'nama' => 'subcategory1',
                'deskripsi' => 'subcategory1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'nama' => 'subcategory2',
                'deskripsi' => 'subcategory2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'nama' => 'subcategory3',
                'deskripsi' => 'subcategory3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Subcategory::insert($sub1);
    }
}
