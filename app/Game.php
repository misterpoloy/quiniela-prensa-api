<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table = "JUEGOS";
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $fillable = [
        'ESTRUCTURA',
        'UBICACION',
        'JUGADOR_1',
        'JUGADOR_2',
        'GOLES_1',
        'GOLES_2',
        'OPCIONES_DE_SELECCION',
        'ESTADO'
    ];

    protected $dates = [
        'FECHA'
    ];

    public function player1()
    {
        return $this->hasOne('App\Countries','ID','JUGADOR_1');
    }

    public function player2()
    {
        return $this->hasOne('App\Countries','ID','JUGADOR_2');
    }

    public function struct()
    {
        return $this->hasOne('App\Structure','ID','ESTRUCTURA');
    }

    public function locate()
    {
        return $this->hasOne('App\Location','ID','UBICACION');
    }

}
