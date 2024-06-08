<?php

namespace App\Imports;

use App\Models\Points;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class IPoints implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Points([
            'rang' => $row['classement'],
            'point' => $row['points']
        ]);
    }
}
