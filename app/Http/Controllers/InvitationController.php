<?php

namespace App\Http\Controllers;

use App\Configuration;
use App\Mail\SendInvitation;
use App\Http\Utility\Utility;
use App\Quiniela;
use App\QuinielaInvitations;
use App\Users;
use App\QuinielaUsers;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Mail;

class InvitationController extends Controller
{

   public function acceptInvitation($invitationID)
   {
        try {

            $invitation = QuinielaInvitations::find($invitationID);
            if ($invitation !== null) {              
                $invitation->ESTATUS = 2;
                $invitation->save();
            } else {
               return response()->json(['status' => 'error', 'message' => 'There is no invitation ID']);
            }

            $quiniela_user = new QuinielaUsers();
            $quiniela_user->QUINIELA = $invitation->QUINIELA;
            $quiniela_user->USUARIO = $invitation->USUARIO;
            $quiniela_user->save();

            return response()->json(['status' => 'success', 'invitation' => $invitation]);

        } catch (\Exception $e) {
            return response()->json([ 'status' => 'error', 'exception' => $e->getMessage()]);
        }

   }

   public function refuseInvitation($invitationID)
   {

      try {

            $invitation = QuinielaInvitations::find($invitationID);
            if ($invitation !== null) {              
                $invitation->ESTATUS = 3;
                $invitation->save();
            } else {
               return response()->json(['status' => 'error', 'message' => 'There is no invitation ID']);
            }

            return response()->json(['status' => 'success', 'invitation' => $invitation]);

        } catch (\Exception $e) {
            return response()->json([ 'status' => 'error', 'exception' => $e->getMessage()]);
        }
   }
}
