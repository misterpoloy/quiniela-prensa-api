<?php

namespace App\Http\Controllers;

use App\Http\Utility\Utility;
use App\Countries;
use Illuminate\Http\Request;
use Exception;

class CountriesController extends Controller
{
    public function index() {
        return response()->json(
            Countries::get()
        );
    }

    public function get(Countries $countries) {

        return response()->json(
            $countries::first()
        );
    }

    public function create(Request $request) {

        try {

            return response()->json(Countries::create($request->all()));

        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function update(Request $request, Countries $countries) {

        try {
            $countries = Utility::setPropertiesToUpdate($request, $countries, [
                'NOMBRE'
            ]);
            $countries->save();

            return response()->json($countries);


        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function destroy(Countries $countries) {
        try {

            if($countries->delete()) {
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
