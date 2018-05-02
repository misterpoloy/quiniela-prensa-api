<?php
/**
 * Created by PhpStorm.
 * User: josepharriaza
 * Date: 21/04/18
 * Time: 9:23 PM
 */

namespace App\Http\Controllers;


use App\Administrator;
use Illuminate\Http\Request;
use Exception;
use App\Http\Utility\Utility;

class AdministratorController
{
    public function index() {
        return response()->json(
            Administrator::get()
        );
    }

    public function get(Administrator $administrator) {

        return response()->json(
            $administrator::first()
        );
    }

    public function create(Request $request) {

        try {

            return response()->json(Administrator::create($request->all()));

        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function update(Request $request, Administrator $administrator) {

        try {
            $administrator = Utility::setPropertiesToUpdate($request, $administrator, [
                'NOMBRE',
                'CORREO',
                'PASSWORD'
            ]);
            $administrator->save();

            return response()->json($administrator);


        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function destroy(Administrator $administrator) {
        try {

            if($administrator->delete()) {
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