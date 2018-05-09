<?php
/**
 * Created by PhpStorm.
 * User: josepharriaza
 * Date: 21/04/18
 * Time: 9:29 PM
 */

namespace App\Http\Controllers;

use App\Administrator;
use App\AdministratorTokens;
use Illuminate\Http\Request;


class AdministratorTokensControllers
{
    public function login(Request $request) {
        $email = $request->CORREO;
        $password = $request->PASSWORD;

        $admin = Administrator::where("CORREO", $email)
            ->where("PASSWORD", $password)
            ->first();

        if ($admin !== null) {
            $api_token = uniqid();
            $admin_token = new AdministratorTokens();
            $admin_token->ADMINISTRADOR = $admin->ID;
            $admin_token->TOKEN = $api_token;

            if ($admin_token->save()) {
                return response()->json([
                    'api_token' => $api_token,
                    'id' => $admin->ID
                ]);
            }
        }
        return response()->json([
            'status' => 'fail'
        ]);

    }
}