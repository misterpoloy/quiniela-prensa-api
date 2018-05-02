<?php

namespace App\Http\Controllers;

use App\Http\Utility\Utility;
use App\Groups;
use Illuminate\Http\Request;
use Exception;

class GroupsController extends Controller
{
    public function index() {
        return response()->json(
            Groups::get()
        );
    }

    public function get(Groups $structure) {

        return response()->json(
            $structure::first()
        );
    }

    public function create(Request $request) {

        try {

            return response()->json(Groups::create($request->all()));

        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function update(Request $request, Groups $structure) {

        try {
            $structure = Utility::setPropertiesToUpdate($request, $structure, [
                'CODIGO'
            ]);
            $structure->save();

            return response()->json($structure);


        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function destroy(Groups $structure) {
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
