<?php

namespace App\Http\Controllers;

use App\Http\Utility\Utility;
use App\QuinielaType;
use Illuminate\Http\Request;
use Exception;

class QuinielaTypeController extends Controller
{
    public function index() {
        return response()->json(
            QuinielaType::et()
        );
    }

    public function get(QuinielaType $quinielaType) {

        return response()->json(
            $quinielaType::first()
        );
    }

    public function create(Request $request) {

        try {

            return response()->json(QuinielaType::create($request->all()));

        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function update(Request $request, QuinielaType $quinielaType) {

        try {
            $quinielaType = Utility::setPropertiesToUpdate($request, $quinielaType, [
                'NOMBRE'
            ]);
            $quinielaType->save();

            return response()->json($quinielaType);


        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function destroy(QuinielaType $quinielaType) {
        try {

            if($quinielaType->delete()) {
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
