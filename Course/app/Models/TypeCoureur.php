<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeCoureur extends Model
{
    use HasFactory;
    public $table = 'typecoureur';
    public $timestamps = false;
    protected $primaryKey = 'idcoureur';
    public $incrementing = false;
    protected $fillable = [
        'idcoureur',
        'idcategorie'
    ];
}
