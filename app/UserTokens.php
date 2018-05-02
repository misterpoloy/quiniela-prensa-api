<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTokens extends Model
{
    protected $table = 'USUARIOS_TOKENS';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $fillable = [
        'USER',
        'TOKEN'
    ];
}