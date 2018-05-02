<?php
/**
 * Created by PhpStorm.
 * User: josepharriaza
 * Date: 21/04/18
 * Time: 10:07 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $table = 'CONFIGURACION';
    protected $primaryKey = 'ID';
    protected $fillable = [
        'NOMBRE',
        'VALOR'
    ];
    public $timestamps = false;
}