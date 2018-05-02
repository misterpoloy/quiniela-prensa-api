<?php

namespace App\Http\Controllers;

use App\Http\Utility\Utility;
use App\Structure;
use Illuminate\Http\Request;
use Exception;

class StructureController extends Controller
{
    public function index() {
        return response()->json(
            Structure::get()
        );
    }

    public function get(Structure $structure) {

        return response()->json(
            $structure::first()
        );
    }

    public function create(Request $request) {

        try {

            return response()->json(Structure::create($request->all()));

        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function update(Request $request, Structure $structure) {

        try {
            $structure = Utility::setPropertiesToUpdate($request, $structure, [
                'NOMBRE'
            ]);
            $structure->save();

            return response()->json($structure);


        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function destroy(Structure $structure) {
        try {

            if($structure->delete()) {
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
