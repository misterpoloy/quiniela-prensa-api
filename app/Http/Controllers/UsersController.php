<?php

namespace App\Http\Controllers;

use App\Http\Utility\Utility;
use App\Quiniela;
use App\QuinielaInvitations;
use App\QuinielaUsers;
use App\Users;
use Illuminate\Http\Request;
use Exception;

class UsersController extends Controller
{
    public function index() {
        return response()->json(
            Users::get()
        );
    }

    public function get(Users $user) {

        return response()->json(
            $user
        );
    }

    public function getMyQuinelas(Users $user) {
        return response()->json(
            Quiniela::where("CREADO_POR", $user->ID)
                ->get()
        );
    }

    public function getQuinelas(Users $user) {
        //$user = $user::first();
        return QuinielaUsers::select("QUINIELAS.ID", "QUINIELAS.NOMBRE", "TIPO_DE_QUINIELA", "DESCRIPCION", "CREADO_POR",
            "CODIGO_COMPARTIR", "GANADOR", "QUINIELAS.FECHA_DE_CREACION", "QUINIELA_USUARIOS.USUARIO")
            ->where("QUINIELA_USUARIOS.USUARIO", $user->ID)
            ->join("QUINIELAS","QUINIELA_USUARIOS.QUINIELA","=","QUINIELAS.ID")
            ->get();
    }

    public function getMyInvitedQuinelas(Users $user) {
        //$user = $user::first();
        return QuinielaInvitations::select("QUINIELAS.ID", "QUINIELAS.NOMBRE", "TIPO_DE_QUINIELA", "DESCRIPCION", "CREADO_POR",
            "CODIGO_COMPARTIR", "GANADOR", "QUINIELAS.FECHA_DE_CREACION", "QUINIELA_INVITACIONES.USUARIO")
            ->join("QUINIELAS","QUINIELA_INVITACIONES.QUINIELA","=","QUINIELAS.ID")
            ->where("QUINIELA_INVITACIONES.USUARIO", $user->ID)
            ->where("QUINIELA_INVITACIONES.ESTATUS", 1)
            ->get();
    }

    public function create(Request $request) {

        try {

            return response()->json(Users::create($request->all()));

        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function update(Request $request, Users $user) {

        try {
            $user = Utility::setPropertiesToUpdate($request, $user, [
                'NOMBRE',
                'CORREO'
            ]);
            $user->save();

            return response()->json($user);


        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function destroy(Users $users) {
        try {

            if($users->delete()) {
                return response()->json([
                    'status' => true
                ]);
            }

            return response()->json([
                'status' => false
            ]);

        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
