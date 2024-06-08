<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoPenalite extends Model
{
    use HasFactory;

    public $table = 'histo_penalite';
    public $timestamps = false;
    protected $fillable = [
        'iduser',
        'idetape',
        'penalite'
    ];
}
