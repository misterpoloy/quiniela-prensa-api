<?php
/**
 * Created by PhpStorm.
 * User: josepharriaza
 * Date: 21/04/18
 * Time: 10:08 PM
 */

namespace App\Http\Controllers;


use App\Configuration;
use Illuminate\Http\Request;
use Exception;
use App\Http\Utility\Utility;

class ConfigurationController
{

    public function get(Configuration $configuration) {

        return response()->json(
            $configuration::first()
        );
    }

    public function getByName($name) {

        return response()->json(
            Configuration::where('NOMBRE', $name)
                ->first()
        );
    }

    public function create(Request $request) {

        try {

            return response()->json(Configuration::create($request->all()));

        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function update(Request $request, Configuration $configuration) {

        try {


            $configuration = Utility::setPropertiesToUpdate($request, $configuration, [
                'NOMBRE',
                'VALOR',
            ]);
            $configuration->save();

            return response()->json($configuration);


        } catch (Exception $e) {
            return response()->json($e);
        }
    }

}