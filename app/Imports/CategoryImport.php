<?php

namespace App\Imports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CategoryImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    private $startRow = 2;

    public function model(array $row)
    {
        return new Category([
            'nama'          => $row['nama'],
            'deskripsi'      => $row['deskripsi'],
        ]);
    }

    public function startRow(): int
    {
        return $this->startRow;
    }
}
