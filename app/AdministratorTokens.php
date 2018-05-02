<?php
/**
 * Created by PhpStorm.
 * User: josepharriaza
 * Date: 21/04/18
 * Time: 9:16 PM
 */

namespace App;


class AdministratorTokens
{
    protected $table = 'ADMINISTRADORES_TOKENS';
    protected $primaryKey = 'ID';
    protected $fillable = [
        'ADMINISTRADOR',
        'TOKEN'
    ];
    public $timestamps = false;
}