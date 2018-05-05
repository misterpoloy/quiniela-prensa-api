<?php

namespace App\Http\Controllers;

use App\Game;
use App\Quiniela;
use App\QuinielaPredications;
use App\QuinielaUsers;
use App\Users;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;

class QuinielaController extends Controller
{
    public function getStats($quiniela) {
        $places = [];
        $users = QuinielaUsers::where("QUINIELA", $quiniela->ID)
            ->get();
        if ($users != null) {

            $winner_and_score = env('GANADOR_MARCADOR');
            $winner_points = env('GANADOR');
            $lost_country = env('ELIMINATORIA_PAIS_PERDEDOR');
            $winner_country = env('ELIMINATORIA_PAIS_GANADOR');
            $champion = env('CAMPEON');

            foreach ($users as $user) {

                $points = 0;

                //Obtener mis resultados
                $groups_results = QuinielaPredications::
                where("QUINIELA", $quiniela->ID)
                    ->join("JUEGOS", "QUINIELA_PREDICCIONES.ID", "=", "JUEGOS.ID")
                    ->where("ESTADO", 1)
                    ->get();

                if ($groups_results != null) {
                    foreach ($groups_results as $result) {

                        //Obtener juego
                        $game = Game::where("ID", $result->JUEGO)
                            ->get();

                        $score = false;
                        $draw = false;
                        $winner = false;
                        $is_lost_country = false;
                        $is_winner_country = false;
                        $is_champion = false;

                        $winner_player = null;
                        if ($game->GOLES_1 > $game->GOLES_2) {
                            $winner_player = $game->JUGADOR_1;
                        } else if ($game->GOLES_2 -> $game->GOLES_1) {
                            $winner_player = $game->JUGADOR_2;
                        } else if ($game->GOLES_1 == $game->GOLES_2) {
                            $draw = true;
                        }


                        if ($result->ESTRUCTURA == 1) {

                            $score = $game->GOLES_1 == $result->GOL_1 &&
                                $game->GOLES_2 == $result->GOL_2;
                            $winner = $this->getWinner($result, $winner_player, $draw);

                        } else {
                            if ($result->JUEGO_1 == $game->JUGADOR_1
                             && $result->JUEGO_2 == $game->JUGADOR_2) {
                                $score = $game->GOLES_1 == $result->GOL_1 &&
                                    $game->GOLES_2 == $result->GOL_2;
                                $winner = $this->getWinner($result, $winner_player, $draw);
                            } else {

                                if ($result->JUEGO_1 == $game->JUGADOR_1) {
                                    if ($game->GOLES_1 > $game->GOLES_2) {
                                        $is_winner_country = true;
                                    } else {
                                        $lost_country = true;
                                    }
                                } else if ($result->JUEGO_1 == $game->JUGADOR_2) {
                                    if ($game->GOLES_2 > $game->GOLES_1) {
                                        $is_winner_country = true;
                                    } else {
                                        $lost_country = true;
                                    }
                                } else if ($result->JUEGO_2 == $game->JUGADOR_1) {
                                    if ($game->GOLES_1 > $game->GOLES_2) {
                                        $is_winner_country = true;
                                    } else {
                                        $lost_country = true;
                                    }
                                } else if ($result->JUEGO_2 == $game->JUGADOR_2) {
                                    if ($game->GOLES_2 > $game->GOLES_1) {
                                        $is_winner_country = true;
                                    } else {
                                        $lost_country = true;
                                    }
                                }

                                if ($result->ESTRUCTURA == 6) {

                                    $is_champion = $this->getWinner($result, $winner_player, $draw);

                                }

                            }
                        }

                        if ($score && $winner) {
                            $points += $winner_and_score;
                        } else if ($winner) {
                            $points += $winner_points;
                        }

                        if ($is_champion) {
                            $points += $champion;
                        } else if ($is_winner_country) {
                            $points += $winner_country;
                        }  else if ($is_lost_country) {
                            $points += $lost_country;
                        }


                    }
                }

                array_push($places, [
                    'USUARIO' => $user->ID,
                    'NOMBRE' => $user->NOMBRE,
                    'PUNTOS'=> $points
                ]);

            }

        }

        uasort($places, function($item1, $item2){
            return $item1->PUNTOS < $item2->PUNTOS;
        });

        return response()->json(
            $places
        );
    }

    private function getWinner($result, $winner_player, $draw) {
        $winner = false;
        if ($result->GOL_1 > $result->GOL_2) {
            $winner = $result->JUGADOR_1 == $winner_player;
        } else if ($result->GOL_2 -> $result->GOL_1) {
            $winner = $result->JUGADOR_2 == $winner_player;
        } else if ($result->GOL_1 == $result->GOL_2) {
            $winner = $draw;
        }
        return $winner;
    }

    public function index() {
        return response()->json(
            Quiniela::
            select("QUINIELAS.ID", "QUINIELAS.NOMBRE", "TIPO_DE_QUINIELA", "DESCRIPCION",
                "CREADO_POR", "FECHA_DE_CREACION", "CODIGO_COMPARTIR", "GANADOR", "u1.NOMBRE as Creador",
                "u1.CORREO as CreadorCorreo", "u2.NOMBRE as NombreGanador", "u1.CORREO as GandorCorreo")
                ->join("USUARIOS as u1","QUINIELAS.CREADO_POR","=","u1.ID")
                ->leftJoin("USUARIOS as u2", function($join) {
                    $join->on("QUINIELAS.GANADOR","=","u2.ID");
                })
                ->get()
        );
    }

    public function getByQuinielaType($quiniela_type) {
        return response()->json(
            Quiniela::
            select("QUINIELAS.ID", "QUINIELAS.NOMBRE", "TIPO_DE_QUINIELA", "DESCRIPCION",
                "CREADO_POR", "FECHA_DE_CREACION", "CODIGO_COMPARTIR", "GANADOR", "u1.NOMBRE as Creador",
                "u1.CORREO as CreadorCorreo", "u2.NOMBRE as NombreGanador", "u1.CORREO as GandorCorreo")
                ->join("USUARIOS as u1","QUINIELAS.CREADO_POR","=","u1.ID")
                ->leftJoin("USUARIOS as u2", function($join) {
                    $join->on("QUINIELAS.GANADOR","=","u2.ID");
                })
                ->where("QUINIELAS.TIPO_DE_QUINIELA", $quiniela_type)
                ->get()
        );
    }

    public function get(Quiniela $quiniela) {

        return response()->json(
            $quiniela::
            select("QUINIELAS.ID", "QUINIELAS.NOMBRE", "TIPO_DE_QUINIELA", "DESCRIPCION",
                "CREADO_POR", "FECHA_DE_CREACION", "CODIGO_COMPARTIR", "GANADOR", "u1.NOMBRE as Creador",
                "u1.CORREO as CreadorCorreo", "u2.NOMBRE as NombreGanador", "u1.CORREO as GandorCorreo")
                ->join("USUARIOS as u1","QUINIELAS.CREADO_POR","=","u1.ID")
                ->leftJoin("USUARIOS as u2", function($join) {
                    $join->on("QUINIELAS.GANADOR","=","u2.ID");
                })
                ->where("QUINIELAS.ID", "=", $quiniela->ID)
                ->first()
        );
    }

    public function create(Request $request) {

        try {
            $quiniela=Quiniela::create($request->all());
            $quiniela['quiniela_usuarios']=QuinielaUsers::create(['QUINIELA'=>$quiniela->ID,'USUARIO'=>$quiniela->CREADO_POR]);
            $quiniela->CREADO_POR=Users::find($quiniela->CREADO_POR);
            return response()->json($quiniela);

        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function update(Request $request, Quiniela $quiniela) {

        try {


            $quiniela = Utility::setPropertiesToUpdate($request, $quiniela, [
                'NOMBRE',
                'TIPO_DE_QUINIELA',
                'DESCRIPCION',
                'FECHA_DE_CREACION',
                'CODIGO_COMPARTIR',
                'GANADOR'
            ]);
            $quiniela->save();

            return response()->json($quiniela);


        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function destroy(Quiniela $quiniela) {
        try {

            if($quiniela->delete()) {
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
