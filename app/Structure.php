<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Structure extends Model
{
    protected $table = 'ESCTRUCTURAS';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $fillable = [
        'NOMBRE'
    ];
}