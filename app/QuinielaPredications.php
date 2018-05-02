<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuinielaPredications extends Model
{
    protected $table = "QUINIELA_PREDICCIONES";
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $fillable = [
        'JUEGO',
        'QUINIELA',
        'USUARIO',
        'GOL_1',
        'GOL_2',
        'JUEGO_1',
        'JUEGO_2'
    ];
}
