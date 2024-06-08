<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportResultat extends Model
{
    use HasFactory;

    public $table = 'import_resultat';
    public $timestamps = false;
    protected $fillable = [
        'etape_rang',
        'numero_dossard',
        'nom',
        'genre',
        'datenaissance',
        'equipe',
        'arrivee'
    ];
}
