<?php
/**
 * Created by PhpStorm.
 * User: Hanif
 * Date: 5/6/2018
 * Time: 1:04 AM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Paise extends Model
{
    protected $table = 'PAISES';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $fillable = [
        'NOMBRE',
        'ISO'
    ];
}