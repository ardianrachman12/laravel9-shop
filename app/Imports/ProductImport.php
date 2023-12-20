<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
    private $startRow = 2;

    public function model(array $row)
    {
        return new Product([
            'subcategory_id' => $row['subcategory_id'],
            'nama' => $row['nama'],
            'sku' => $this->generateRandomSku(),
            'deskripsi' => $row['deskripsi'],
            'gambar' => $this->generateRandomImageName(), // Menggunakan metode baru untuk nama gambar
            'harga' => $row['harga'],
            'berat' => 10.0,
            'stok' => $row['stok'],
        ]);
    }

    private function generateRandomSku(): string
    {
        // Generate random 6-digit number
        return str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
    }

    private function generateRandomImageName(): string
    {
        // Generate random 9-digit number
        $randomNumber = str_pad(mt_rand(1, 999999999), 9, '0', STR_PAD_LEFT);

        // Combine with ".png"
        return $randomNumber . '.png';
    }

    public function startRow(): int
    {
        return $this->startRow;
    }
}
