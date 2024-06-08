<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportEtape extends Model
{
    use HasFactory;

    public $table = 'import_etape';
    public $timestamps = false;
    protected $fillable = [
        'etape',
        'longueur',
        'nb_courreur',
        'rang',
        'depart'
    ];
}
