<?php

namespace App\Imports;


use App\Http\Controllers\ImportController;
use App\Models\ImportEtape;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class IEtape implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new ImportEtape([
            'etape' => $row['etape'],
            'longueur' => str_replace(',', '.',$row['longueur']),
            'nb_courreur' => $row['nb_coureur'],
            'rang' => $row['rang'],
            'depart' => $row['date_depart'] . ' ' . $row['heure_depart'],
        ]);
    }
}
