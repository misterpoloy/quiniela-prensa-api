<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuinielaAward extends Model
{
    protected $table = "QUINIELA_PREMIOS";
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'QUINIELA',
        'PUESTO',
        'PREMIO',
        'DESCRIPCION'
    ];
}