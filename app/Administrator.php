<?php
/**
 * Created by PhpStorm.
 * User: josepharriaza
 * Date: 21/04/18
 * Time: 9:15 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
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