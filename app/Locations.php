<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
    protected $table = 'UBICACIONES';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $fillable = [
        'NOMBRE',
        'CIUDAD',
    ];
}
