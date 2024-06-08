<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etape extends Model
{
    use HasFactory;
    public $table = 'etape';
    public $timestamps = false;
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'nom',
        'longeur',
        'nb_coureur',
        'rang'
    ];

    public function classement(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Classement::class, 'idetape');
    }


    public function chrono(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Chrono::class, 'idetape');
    }
}
