<?php

namespace App\Http\Controllers;

use App\Http\Utility\Utility;
use App\QuinielaUsers;
use Illuminate\Http\Request;
use Exception;

class QuinielaUsersController extends Controller
{
    public function index() {
        return response()->json(
            QuinielaUsers::
            join("QUINIELAS","QUINIELA_USUARIOS.QUINIELA","=","QUINIELAS.ID")
                ->join("USUARIOS","QUINIELA_USUARIOS.USUARIO","=","USUARIOS.ID")
                ->get()
        );
    }

    public function get(QuinielaUsers $countriesGroups) {

        return response()->json(
            $countriesGroups::
            join("QUINIELAS","QUINIELA_USUARIOS.QUINIELA","=","QUINIELAS.ID")
                ->join("USUARIOS","QUINIELA_USUARIOS.USUARIO","=","USUARIOS.ID")
                ->get()
                ->first()
        );
    }

    public function create(Request $request) {

        try {

            return response()->json(QuinielaUsers::create($request->all()));

        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function update(Request $request, QuinielaUsers $countriesGroups) {

        try {
            $countriesGroups = Utility::setPropertiesToUpdate($request, $countriesGroups, [
                'QUINIELA',
                'USUARIO'
            ]);
            $countriesGroups->save();

            return response()->json($countriesGroups);


        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function destroy(QuinielaUsers $countriesGroups) {
        try {

            if($countriesGroups->delete()) {
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
