<?php

namespace App\Http\Controllers;

use App\Http\Utility\Utility;
use App\QuinielaPredications;
use Illuminate\Http\Request;
use Exception;

class QuinielaPredicationsController extends Controller
{
    public function index() {
        return response()->json(
            QuinielaPredications::
            join("PAISES as player1","QUINIELA_PREDICCIONES.JUEGO_1","=","player1.ID")
                ->join("PAISES as player2","QUINIELA_PREDICCIONES.JUEGO_2","=","player2.ID")
                ->join("JUEGO","QUINIELA_PREDICCIONES.JUEGO","=","JUEGO.ID")
                ->join("QUINIELAS","QUINIELA_PREDICCIONES.JUEGO","=","QUINIELAS.ID")
                ->get()
        );
    }

    public function getPredictionsByUser($user) {
        return response()->json(
            QuinielaPredications::
            join("PAISES as player1","QUINIELA_PREDICCIONES.JUEGO_1","=","player1.ID")
                ->join("PAISES as player2","QUINIELA_PREDICCIONES.JUEGO_2","=","player2.ID")
                ->join("JUEGO","QUINIELA_PREDICCIONES.JUEGO","=","JUEGO.ID")
                ->join("QUINIELAS","QUINIELA_PREDICCIONES.JUEGO","=","QUINIELAS.ID")
                ->where("QUINIELA_PREDICCIONES.USUARIO", $user->ID)
                ->get()
        );
    }

    public function get(QuinielaPredications $quinielaPredications) {

        return response()->json(
            $quinielaPredications::
            join("PAISES as player1","QUINIELA_PREDICCIONES.JUEGO_1","=","player1.ID")
                ->join("PAISES as player2","QUINIELA_PREDICCIONES.JUEGO_2","=","player2.ID")
                ->join("JUEGO","QUINIELA_PREDICCIONES.JUEGO","=","JUEGO.ID")
                ->join("QUINIELAS","QUINIELA_PREDICCIONES.JUEGO","=","QUINIELAS.ID")
                ->get()
                ->first()
        );
    }

    public function create(Request $request) {

        try {
            $quinielas = [];
            foreach ($request->all() as $predction) {
                array_push($quinielas, QuinielaPredications::create($predction));
            }

            return response()->json($quinielas);

        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function update(Request $request, QuinielaPredications $quinielaPredications) {

        try {


            $quinielaPredications = Utility::setPropertiesToUpdate($request, $quinielaPredications, [
                'JUEGO',
                'QUINIELA',
                'USUARIO',
                'GOL_1',
                'GOL_2',
                'JUEGO_1',
                'JUEGO_2'
            ]);
            $quinielaPredications->save();

            return response()->json($quinielaPredications);


        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function destroy(QuinielaPredications $quinielaPredications) {
        try {

            if($quinielaPredications->delete()) {
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
