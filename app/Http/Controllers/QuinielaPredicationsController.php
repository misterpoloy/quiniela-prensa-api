<?php

namespace App\Http\Controllers;

use App\Http\Utility\Utility;
use App\QuinielaPredications;
use Illuminate\Http\Request;
use Exception;
use App\Users;
use App\Structure;
use App\Ubicacione;
use App\Paise;
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
                ->join("JUEGOS","QUINIELA_PREDICCIONES.JUEGO","=","JUEGOS.ID")
                ->join("QUINIELAS","QUINIELA_PREDICCIONES.JUEGO","=","QUINIELAS.ID")
                ->where("QUINIELA_PREDICCIONES.USUARIO", $user->ID)
                ->get()
        );
    }

     public function getPredictionsByUserQuiniela($userID, $quinielaID) { 

        $data =     QuinielaPredications:: 
                    join("PAISES as player1","QUINIELA_PREDICCIONES.JUEGO_1","=","player1.ID")
                        ->join("PAISES as player2","QUINIELA_PREDICCIONES.JUEGO_2","=","player2.ID")
                        ->join("JUEGOS","QUINIELA_PREDICCIONES.JUEGO","=","JUEGOS.ID")                       
                        ->where("QUINIELA_PREDICCIONES.USUARIO", $userID)
                        ->where("QUINIELA_PREDICCIONES.QUINIELA", $quinielaID)
                        ->get();    
       
        foreach ($data as $item) {

           $JUEGO_id = $item['JUEGO'];
           $structure_name = Structure::find($item['ESTRUCTURA'])->NOMBRE;
           $ubicacione = Ubicacione::find($item['UBICACION']);
           $JUGADOR_1 = Paise::find($item['JUGADOR_1']);
           $JUGADOR_2 = Paise::find($item['JUGADOR_2']);
           $JUEGO_1 = Paise::find($item['JUEGO_1']);
           $JUEGO_2 = Paise::find($item['JUEGO_2']);
           unset( $item['JUEGO'] );

           $item['JUEGO'] = array(
                'ID' =>  $JUEGO_id,
                'ESTRUCTURA' => array('ID' => $item['ESTRUCTURA'], 'NOMBRE' =>$structure_name ),
                'FECHA' => $item['FECHA'],
                'UBICACION' => array('ID' => $ubicacione->ID, 'NOMBRE' => $ubicacione->NOMBRE, 'CIUIDAD' => $ubicacione->CIUIDAD ),
                'JUEGADOR_1 ' => array("ID" => $JUGADOR_1->ID, 'NOMBRE' => $JUGADOR_1->NOMBRE, 'ISO' => $JUGADOR_1->ISO),
                'JUEGADOR_2 ' => array("ID" => $JUGADOR_2->ID, 'NOMBRE' => $JUGADOR_2->NOMBRE, 'ISO' => $JUGADOR_2->ISO),
                'GOLES_1' => $item['GOLES_1'],
                'GOLES_2' => $item['GOLES_2'],
                'OPCIONES_DE_SELECCION' => $item['OPCIONES_DE_SELECCION']
           );

           $item['JUEGO_1'] = array("ID" => $JUEGO_1->ID, 'NOMBRE' => $JUEGO_1->NOMBRE, 'ISO' => $JUEGO_1->ISO);
           $item['JUEGO_2'] = array("ID" => $JUEGO_2->ID, 'NOMBRE' => $JUEGO_2->NOMBRE, 'ISO' => $JUEGO_2->ISO);
          
           unset($item['FECHA']); unset($item['ESTRUCTURA']); unset($item['UBICACION']); unset($item['JUGADOR_1']);
           unset($item['JUGADOR_2']); unset($item['GOLES_1']); unset($item['GOLES_2']); unset($item['OPCIONES_DE_SELECCION']);
           unset($item['ISO']);
                  
        }
       
        return response()->json($data);
    }


    public function get(QuinielaPredications $quinielaPredications) {

        return response()->json(
            $quinielaPredications::
            join("PAISES as player1","QUINIELA_PREDICCIONES.JUEGO_1","=","player1.ID")
                ->join("PAISES as player2","QUINIELA_PREDICCIONES.JUEGO_2","=","player2.ID")
                ->join("JUEGOS","QUINIELA_PREDICCIONES.JUEGO","=","JUEGOS.ID")
                ->join("QUINIELAS","QUINIELA_PREDICCIONES.JUEGO","=","QUINIELAS.ID")
                ->get()
                ->first()
        );
    }

    public function create(Request $request) {   
        
       
        try {

            $prediction = $request->games;
         
            foreach ($prediction as $item) {
               QuinielaPredications::create($item);
               
            }
            return response()->json($prediction);


        } catch (Exception $e) {
            return response()->json($e->getMessage());
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
