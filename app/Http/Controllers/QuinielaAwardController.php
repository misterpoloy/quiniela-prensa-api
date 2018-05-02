<?php

namespace App\Http\Controllers;

use App\Http\Utility\Utility;
use App\QuinielaAward;
use Illuminate\Http\Request;
use Exception;

class QuinielaAwardController extends Controller
{
    public function index() {
        return response()->json(
            QuinielaAward::
            join("QUINIELAS","QUINIELA_PREMIOS.QUINIELA","=","QUINIELAS.ID")
                ->get()
        );
    }

    public function get(QuinielaAward $quinielaAward) {

        return response()->json(
            $quinielaAward::
            join("QUINIELAS","QUINIELA_PREMIOS.QUINIELA","=","QUINIELAS.ID")
                ->get()
                ->first()
        );
    }

    public function create(Request $request) {

        try {

            return response()->json(QuinielaAward::create($request->all()));

        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function update(Request $request, QuinielaAward $quinielaAward) {

        try {


            $quinielaAward = Utility::setPropertiesToUpdate($request, $quinielaAward, [
                'QUINIELA',
                'PUESTO',
                'PREMIO',
                'DESCRIPCION'
            ]);
            $quinielaAward->save();

            return response()->json($quinielaAward);


        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function destroy(QuinielaAward $quinielaAward) {
        try {

            if($quinielaAward->delete()) {
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
