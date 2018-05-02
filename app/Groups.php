<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    protected $table = 'GRUPOS';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $fillable = [
        'CODIGO'
    ];
}
