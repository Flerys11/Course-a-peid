<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chrono extends Model
{
    use HasFactory;

    public $table = 'chrono_courruer';
    public $timestamps = false;
    protected $fillable = [
        'idetape',
        'nom',
        'duree',
        'iduser'
    ];

    public function etape(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Etape::class, 'idetape');
    }
}
