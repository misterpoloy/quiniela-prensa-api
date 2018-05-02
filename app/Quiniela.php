<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiniela extends Model
{
    protected $table = "QUINIELAS";
    public $primaryKey = 'ID';
    public $timestamps = false;
    protected $fillable = [
        "NOMBRE",
        "TIPO_DE_QUINIELA",
        "DESCRIPCION",
        "CREADO_POR",
        "CODIGO_COMPARTIR",
        "GANADOR"
    ];
    protected $dates = [
        "FECHA_DE_CREACION",
    ];

    public function creator()
    {
        return $this->hasOne('App\Users','id','created_by');
    }

    public function winner()
    {
        return $this->hasOne('App\Users','id','winner');
    }
}
