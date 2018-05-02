<?php

namespace App\Http\Controllers;

use App\Http\Utility\Utility;
use App\Locations;
use Illuminate\Http\Request;
use Exception;

class LocationsController extends Controller
{
    public function index() {
        return response()->json(
            Locations::get()
        );
    }

    public function get(Locations $locations) {

        return response()->json(
            $locations::first()
        );
    }

    public function create(Request $request) {

        try {

            return response()->json(Locations::create($request->all()));

        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function update(Request $request, Locations $locations) {

        try {


            $locations = Utility::setPropertiesToUpdate($request, $locations, [
                'NOMBRE',
                'CIUDAD',
            ]);
            $locations->save();

            return response()->json($locations);


        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function destroy(Locations $locations) {
        try {

            if($locations->delete()) {
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
