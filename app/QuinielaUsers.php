<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuinielaUsers extends Model
{
    protected $table = 'QUINIELA_USUARIOS';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $fillable = [
        'QUINIELA',
        'USUARIO'
    ];
}