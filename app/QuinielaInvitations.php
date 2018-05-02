<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuinielaInvitations extends Model
{
    protected $table = 'QUINIELA_INVITACIONES';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $fillable = [
        'USUARIO',
        'QUINIELA',
        'ESTATUS',
    ];
    protected $dates = [
        'FECHA_DE_CREACION'
    ];
}
