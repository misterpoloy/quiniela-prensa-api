<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountriesGroups extends Model
{
    protected $table = 'PAISES_GRUPOS';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $fillable = [
        'PAIS',
        'GRUPO'
    ];
}
