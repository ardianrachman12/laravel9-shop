<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cat1 = [
            [
                'nama' => 'category1',
                'deskripsi' => 'category1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'category2',
                'deskripsi' => 'category2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'category3',
                'deskripsi' => 'category3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Category::insert($cat1);
    }
}
