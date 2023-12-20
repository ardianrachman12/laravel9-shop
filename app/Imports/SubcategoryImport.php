<?php

namespace App\Imports;

use App\Models\Subcategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SubcategoryImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    private $startRow = 2;

    public function model(array $row)
    {
        return new Subcategory([
            'category_id' => $row['category_id'],
            'nama' => $row['nama'],
            'deskripsi' => $row['deskripsi'],
        ]);
    }

    public function startRow(): int
    {
        return $this->startRow;
    }
}
