<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finalsetape extends Model
{
    use HasFactory;
    public $table = 'finalsetape';
    public $timestamps = false;
    protected $primaryKey = 'idcourse';
    protected $fillable = [
        'idcourse',
        'depart',
        'arrivee'
    ];
}
