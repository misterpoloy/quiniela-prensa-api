<?php
namespace App\Http\Utility;

use Illuminate\Http\Request;

class Utility
{
    public static function setPropertiesToUpdate(Request $request, $object, $fieldList)
    {
        foreach ($fieldList as $field)
        {
            if(!is_null($request->input($field)) && trim($request->input($field)) != ''){
                $object->{$field} = trim($request->input($field));
            }
        }
        return $object;
    }
}