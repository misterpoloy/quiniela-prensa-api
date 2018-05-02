<?php
/**
 * Created by PhpStorm.
 * User: josepharriaza
 * Date: 21/04/18
 * Time: 9:15 PM
 */

namespace App;


class Administrator
{
    protected $table = 'ADMINISTRADORES';
    protected $primaryKey = 'ID';
    protected $fillable = [
        'NOMBRE',
        'CORREO',
        'PASSWORD'
    ];
    public $timestamps = false;
}