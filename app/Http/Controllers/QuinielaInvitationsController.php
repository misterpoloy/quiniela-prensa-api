<?php

namespace App\Http\Controllers;

use App\Configuration;
use App\Http\Utility\Utility;
use App\Quiniela;
use App\QuinielaInvitations;
use App\Users;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Mail;

class QuinielaInvitationsController extends Controller
{
    public function index() {
        return response()->json(
            QuinielaInvitations::
                select("QUINIELA_INVITACIONES.ID as quinela_invitation_ID", "USUARIO", "QUINIELAS", "ESTATUS",
                "QUINIELAS.name as quinela_name", "CORREO", "TIPO_DE_QUINIELA", "DESCRIPCION", "CREADO_POR",
                    "USUARIOS.NOMBRE as user_name", "CODIGO_COMPARTIR", "GANADOR")
                ->join("USUARIOS","QUINIELA_INVITACIONES.USUARIO","=","USUARIOS.ID")
                ->join("QUINIELAS","QUINIELA_INVITACIONES.QUINIELA","=","QUINIELAS.ID")
                ->get()
        );
    }

    public function getQuinielasByState($user, $status) {
        return response()->json(
            QuinielaInvitations::
            select("QUINIELA_INVITACIONES.ID as quinela_invitation_ID", "USUARIO", "QUINIELAS", "ESTATUS",
                "QUINIELAS.name as quinela_name", "CORREO", "TIPO_DE_QUINIELA", "DESCRIPCION", "CREADO_POR",
                "USUARIOS.NOMBRE as user_name", "CODIGO_COMPARTIR", "GANADOR")
                ->join("USUARIOS","QUINIELA_INVITACIONES.USUARIO","=","USUARIOS.ID")
                ->join("QUINIELAS","QUINIELA_INVITACIONES.QUINIELA","=","QUINIELAS.ID")
                ->where("QUINIELA_INVITACIONES.USUARIO", $user->ID)
                ->where("QUINIELA_INVITACIONES.STATUS", $status)
                ->get()
        );
    }

    public function get(QuinielaInvitations $quinielaInvitations) {

        return response()->json(
            $quinielaInvitations::
            select("QUINIELA_INVITACIONES.ID as quinela_invitation_ID", "USUARIO", "QUINIELAS", "ESTATUS",
                "QUINIELAS.name as quinela_name", "CORREO", "TIPO_DE_QUINIELA", "DESCRIPCION", "CREADO_POR",
                "USUARIOS.NOMBRE as user_name", "CODIGO_COMPARTIR", "GANADOR")
                ->join("USUARIOS","QUINIELA_INVITACIONES.USUARIO","=","USUARIOS.ID")
                ->join("QUINIELAS","QUINIELA_INVITACIONES.QUINIELA","=","QUINIELAS.ID")
                ->first()
        );
    }

    public function invite(Request $request) {
        try {
            $user = Users::where("CORREO", $request->email)->first();
            if ($user === null) {
                $user = new Users();
                $user->CORREO = $request->email;
                $user->save();
            }

            $invitation = new QuinielaInvitations();
            $invitation->QUINIELA = $request->quinela_id;
            $invitation->USUARIO = $user->ID;
            $invitation->FECHA_DE_CREACION = date('Y-m-d');
            $invitation->ESTATUS = 1;
            $invitation->save();

            $message = Configuration::where("NOMBRE", "HTML_INVITACION")
                ->first();

            Mail::raw($message, function($msg) use ($user) {
                $msg->subject("Invitación a Quinela");
                $msg->to([$user->correo]);
                $msg->from([env("MAIL_USERNAME")]);
            });

            return response()->json($invitation);

        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function create(Request $request) {

        try {

            return response()->json(QuinielaInvitations::create($request->all()));

        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function update(Request $request, QuinielaInvitations $quinielaInvitations) {

        try {


            $quinielaInvitations = Utility::setPropertiesToUpdate($request, $quinielaInvitations, [
                'USUARIO',
                'QUINIELA',
                'ESTATUS',
            ]);
            $quinielaInvitations->save();

            return response()->json($quinielaInvitations);


        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function destroy(QuinielaInvitations $quinielaInvitations) {
        try {

            if($quinielaInvitations->delete()) {
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
