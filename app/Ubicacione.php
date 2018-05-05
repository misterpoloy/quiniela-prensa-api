<?php
/**
 * Created by PhpStorm.
 * User: Hanif
 * Date: 5/6/2018
 * Time: 12:42 AM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ubicacione extends  Model
{
    protected $table = 'ubicaciones';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $fillable = [
        'NOMBRE',
        'CIUIDAD'
    ];
}