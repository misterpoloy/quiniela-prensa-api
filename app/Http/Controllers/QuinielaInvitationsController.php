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
use App\Mail\UserInfo;
class QuinielaInvitationsController extends Controller
{
    public function index() {
        return response()->json(
            QuinielaInvitations::
                select("QUINIELA_INVITACIONES.ID as quinela_invitation_ID", "USUARIO", "QUINIELA", "ESTATUS",
                "QUINIELAS.name as quinela_name", "CORREO", "TIPO_DE_QUINIELA", "DESCRIPCION", "CREADO_POR",
                    "USUARIOS.NOMBRE as user_name", "CODIGO_COMPARTIR", "GANADOR")
                ->join("USUARIOS","QUINIELA_INVITACIONES.USUARIO","=","USUARIOS.ID")
                ->join("QUINIELAS","QUINIELA_INVITACIONES.QUINIELA","=","QUINIELAS.ID")
                ->get()
        );
    }

    public function getQuinielasByState($user, $status) {

        $data = QuinielaInvitations::           
                select("QUINIELA_INVITACIONES.ID as quinela_invitation_ID", "USUARIO", "QUINIELA", "ESTATUS",
                 "QUINIELAS.NOMBRE as quinela_name", "CORREO", "TIPO_DE_QUINIELA", "DESCRIPCION", "CREADO_POR",
                 "USUARIOS.NOMBRE as user_name", "CODIGO_COMPARTIR", "GANADOR")
                 ->join("USUARIOS","QUINIELA_INVITACIONES.USUARIO","=","USUARIOS.ID")
                 ->join("QUINIELAS","QUINIELA_INVITACIONES.QUINIELA","=","QUINIELAS.ID")
                 ->where("QUINIELA_INVITACIONES.USUARIO", $user->ID)               
                 ->where("QUINIELA_INVITACIONES.ESTATUS", $status)
                 ->get();

        $returnArray = array();

        foreach($data as $item) {

           unset($item['USUARIO']);
           $item['USUARIO'] = array('NOMBRE' => $item->user_name, 'CORREO' => $item->CORREO);
           unset($item['user_name']);
           unset($item['CORREO']);
           array_push($returnArray, $item);

        }

        return response()->json($returnArray);
       
    }

    public function getQuinielasByquinielaID($status, $quinielaID) {

        $data = QuinielaInvitations::           
                select("QUINIELA_INVITACIONES.ID as quinela_invitation_ID", "USUARIO", "QUINIELA", "ESTATUS",
                 "QUINIELAS.NOMBRE as quinela_name", "CORREO", "TIPO_DE_QUINIELA", "DESCRIPCION", "CREADO_POR",
                 "USUARIOS.NOMBRE as user_name", "CODIGO_COMPARTIR", "GANADOR")
                 ->join("USUARIOS","QUINIELA_INVITACIONES.USUARIO","=","USUARIOS.ID")
                 ->join("QUINIELAS","QUINIELA_INVITACIONES.QUINIELA","=","QUINIELAS.ID")
                 ->where("QUINIELA_INVITACIONES.QUINIELA", $quinielaID)               
                 ->where("QUINIELA_INVITACIONES.ESTATUS", $status)
                 ->get();

        $returnArray = array();

        foreach($data as $item) {

           unset($item['USUARIO']);
           $item['USUARIO'] = array('NOMBRE' => $item->user_name, 'CORREO' => $item->CORREO);
           unset($item['user_name']);
           unset($item['CORREO']);
           array_push($returnArray, $item);

        }

        return response()->json($returnArray);

        
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
			
			$invitation = QuinielaInvitations::where('USUARIO','=', $user->ID)
				                             ->where('QUINIELA', $request->quinela_id)->first();
			
			if ($invitation == null) {
				$invitation = new QuinielaInvitations();
				$invitation->QUINIELA = $request->quinela_id;
				$invitation->USUARIO = $user->ID;
				$invitation->FECHA_DE_CREACION = date('Y-m-d');
				$invitation->ESTATUS = 1;
				$invitation->save();

				$message = Configuration::where("NOMBRE", "HTML_INVITACION")->first();
				$quiniela = Quiniela::find($request->quinela_id);
				
				$data = array(
					'user' => $user['NOMBRE'],
					'quiniela' => $quiniela['NOMBRE']
				);     

				$emailSender = new UserInfo($data);//jp@calaps.com
				Mail::to($request->email)->send($emailSender); 
				return response()->json($invitation);
			} 			
			return response()->json([ 'message' => 'El usuario ya fue invitado' ]);
            

        } catch (Exception $e) {
            return response()->json([ 'status' => 'error', 'exception' => $e->getMessage()]);
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

            if ($quinielaInvitations->ESTATUS == 2) {
                $quiniela_user = new QuinielaUsers();
                $quiniela_user->QUINIELA = $quinielaInvitations->QUINIELA;
                $quiniela_user->USUARIO = $quinielaInvitations->USUARIO;
                $quiniela_user->save();
            }

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
