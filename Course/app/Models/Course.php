<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    public $table =  'course';
    public $timestamps = false;
    protected $fillable = [
        'idetape',
        'idcoureur',
        'etat'
    ];

    public function coureur()
    {
        return $this->belongsTo(Coureur::class, 'idcoureur');
    }
}
