<?php

namespace App\Imports;


use App\Models\ImportEtape;
use App\Models\ImportResultat;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class IResultat implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new ImportResultat([
            'etape_rang' => $row['etape_rang'],
            'numero_dossard' => $row['numero_dossard'],
            'nom' => $row['nom'],
            'genre' => $row['genre'],
            'datenaissance' => $row['date_naissance'],
            'equipe' => $row['equipe'],
            'arrivee' => $row['arrivee']
        ]);
    }
}
