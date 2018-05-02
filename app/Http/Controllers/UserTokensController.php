<?php

namespace App\Http\Controllers;

use App\Users;
use App\UserTokens;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Exception;

class UserTokensController extends Controller
{
    public function auth(Request $request) {

        $api_token = $request->api_token;
        $url = env('PRENSA_URL') . $api_token . ".json";

        $client = new Client();
        $res = $client->get($url, []);
        $body = $res->getBody();
        $body = json_decode($body);
        if ($res->getStatusCode() === 200) {
            if ($body->status === 'success') {
                $user = Users::where("CORREO", $body->data->mail)->first();

                if ($user === null) {
                    $user = new Users();
                    $user->CORREO = $body->data->mail;
                    $user->NOMBRE = $body->data->primer_nombre . ' ' . $body->data->primer_apellido;
                    $user->save();
                } else if(trim($user->NOMBRE) == '') {
                    $user->NOMBRE = $body->data->primer_nombre . ' ' . $body->data->primer_apellido;
                    $user->save();
                }

                if ($user !== null) {
                    $is_valid = true;
                    $user_token = UserTokens::where("token", $api_token)->first();
                    if ($user_token === null) {
                        $user_token = new UserTokens();
                        $user_token->user = $user->ID;
                        $user_token->token = $api_token;
                        $is_valid = $user_token->save();
                    } else {
                        $user_token->token = $api_token;
                        $is_valid = $user_token->save();
                    }
                    if ($is_valid) {
                        return redirect(env('REACT_URL') . '?token=' . $api_token . '&id=' . $user->ID);
                    }
                }
            }
        }
        return response()->json([
           'status' => 'fail'
        ]);

    }
}