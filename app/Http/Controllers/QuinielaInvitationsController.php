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
            $user = Users::where("email", $request->email)->first();
            if ($user === null) {
                $user = new Users();
                $user->email = $request->email;
                $user->save();
            }

            $invitation = new QuinielaInvitations();
            $invitation->quinela = $request->quinela_id;
            $invitation->user = $user->id;
            $invitation->created_date = date('Y-m-d');
            $invitation->status = 1;
            $invitation->save();

            $message = Configuration::where("NAME", "HTML_INVITACION")
                ->first();

            Mail::raw($message, function($msg) use ($user) {
                $msg->subject("Invitación a Quinela");
                $msg->to([$user->email]);
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
