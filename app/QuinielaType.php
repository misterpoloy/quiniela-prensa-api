<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuinielaType extends Model
{
    protected $table = 'QUINIELA_TIPOS';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $fillable = [
        'NOMBRE'
    ];
}
