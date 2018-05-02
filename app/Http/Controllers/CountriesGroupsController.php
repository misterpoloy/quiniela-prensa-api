<?php

namespace App\Http\Controllers;

use App\Http\Utility\Utility;
use App\CountriesGroups;
use Illuminate\Http\Request;
use Exception;

class CountriesGroupsController extends Controller
{
    public function index() {
        return response()->json(
            CountriesGroups::
            join("PAIS","PAISES_GRUPOS.PAIS","=","PAIS.ID")
                ->join("GRUPO","PAISES_GRUPOS.GRUPO","=","GRUPO.ID")
                ->get()
        );
    }

    public function getByCode($code) {
        return response()->json(
            CountriesGroups::
            join("PAIS","PAISES_GRUPOS.PAIS","=","PAIS.ID")
                ->join("GRUPO","PAISES_GRUPOS.GRUPO","=","GRUPO.ID")
                ->where('GRUPOS.CODIGO', $code)
                ->get()
        );
    }

    public function get(CountriesGroups $countriesGroups) {

        return response()->json(
            $countriesGroups::
            join("PAIS","PAISES_GRUPOS.PAIS","=","PAIS.ID")
                ->join("GRUPO","PAISES_GRUPOS.GRUPO","=","GRUPO.ID")
                ->get()
        );
    }

    public function create(Request $request) {

        try {

            return response()->json(CountriesGroups::create($request->all()));

        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function update(Request $request, CountriesGroups $countriesGroups) {

        try {
            $countriesGroups = Utility::setPropertiesToUpdate($request, $countriesGroups, [
                'PAIS',
                'GRUPO'
            ]);
            $countriesGroups->save();

            return response()->json($countriesGroups);


        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function destroy(CountriesGroups $countriesGroups) {
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
