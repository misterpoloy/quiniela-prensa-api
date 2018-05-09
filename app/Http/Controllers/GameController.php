<?php

namespace App\Http\Controllers;

use App\Game;
use App\Http\Utility\Utility;
use App\Paise;
use App\Structure;
use App\Ubicacione;
use App\Users;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Mail;

class GameController extends Controller
{
    public function index() {
        return response()->json(
            Game::
                join("PAIS as player1","JUEGOS.JUGADOR_1","=","player1.ID")
                ->join("PAIS as player2","JUEGOS.JUGADOR_2","=","player2.ID")
                ->join("ESTRUCTURA","JUEGOS.ESTRUCTURA","=","ESTRUCTURA.id")
                ->join("UBICACIONES","JUEGOS.ESTRUCTURA","=","UBICACIONES.id")
                ->get()
        );
    }
    public function getByEstructura($id){
        $estructura= Structure::find($id);
        $games=Game::where('ESTRUCTURA',$estructura->ID)->get();
        foreach ($games as $game){
            $game->UBICACION=Ubicacione::find($game->UBICACION);
            $game->ESTRUCTURA=Structure::find($game->ESTRUCTURA);
            $game->JUGADOR_1=Paise::find($game->JUGADOR_1);
            $game->JUGADOR_2=Paise::find($game->JUGADOR_2);
        }
        return $games;
    }

    public function get(Game $game) {

        return response()->json(
            $game::
            join("PAIS as player1","JUEGOS.JUGADOR_1","=","player1.id")
                ->join("PAIS as player2","JUEGOS.JUGADOR_2","=","player2.id")
                ->join("ESTRUCTURA","JUEGOS.ESTRUCTURA","=","ESTRUCTURA.id")
                ->join("UBICACIONES","JUEGOS.ESTRUCTURA","=","UBICACIONES.id")
                ->get()
                ->first()
        );
    }


    public function create(Request $request) {

        try {
            $games = [];
            foreach ($request->all() as $game) {
                array_push($games, Game::create($game));
            }
            return response()->json($games);

        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function notify() {
        try {

            $users = Users::get();
            if ($users != null && sizeof($users) > 0) {
                foreach ($users as $user) {

                    $message = "Hola, \n\n Se han actualizado los resultados, entra y ve tu posición.";

                    Mail::raw($message, function($msg) use ($user) {
                        $msg->subject("Resultados actualizados");
                        $msg->to([$user->email]);
                        $msg->from([env("MAIL_USERNAME")]);
                    });

                }
            }

            return response()->json(true);

        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function update(Request $request, Game $game) {

        try {

            $game = Utility::setPropertiesToUpdate($request, $game, [
                'ESTRUCTURA',
                'UBICACION',
                'JUGADOR_1',
                'JUGADOR_2',
                'GOLES_1',
                'GOLES_2',
                'FECHA',
                'ESTADO'
            ]);
            $game->save();

            return response()->json($game);


        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function updateAll(Request $request) {

        try {

            $games = [];
            foreach ($request->all() as $game) {
                $game = Utility::setPropertiesToUpdate($request, $game, [
                    'ESTRUCTURA',
                    'UBICACION',
                    'JUGADOR_1',
                    'JUGADOR_2',
                    'GOLES_1',
                    'GOLES_2',
                    'FECHA',
                    'ESTADO'
                ]);
                $game->save();
                array_push($games, $game);
            }

            return response()->json($games);


        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function destroy(Game $game) {
        try {

            if($game->delete()) {
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
