<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coureur extends Model
{
    use HasFactory;
    public $table = 'coureur';
    public $timestamps = false;
    public $primaryKey = 'id';
    public $keyType = 'string';
    protected $fillable = [
        'id',
        'nom',
        'numero',
        'idgenre',
        'iduser',
        'datanaissance'
    ];

    public static function getId()
    {
        return DB::select("select coureur_id()")[0]->coureur_id;
    }
}
