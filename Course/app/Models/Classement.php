<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classement extends Model
{
    use HasFactory;

    public $table = 'ensemble_detail_classement';
    public $timestamps = false;

    protected $fillable = [
        'idetape',
        'idcoureur',
        'difference_heure',
        'nom',
        'numero',
        'id_equipe'
    ];

    public function etape(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Etape::class, 'idetape');
    }

}
