<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Points extends Model
{
    use HasFactory;
    public $table = 'points';
    public $timestamps = false;
    protected $fillable = [
        'rang',
        'point'
    ];
}
