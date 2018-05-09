<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['prefix' => 'api'], function($router)
{

    $router->post('auth', 'UserTokensController@auth');
    //$router->get('auth', 'UserTokensController@auth');

    $router->group(['middleware' => 'cors'], function($router) {
        $router->post('login', 'AdministratorTokensControllers@login');
        $router->options('login', function (){});

        $router->group(['middleware' => 'authUser'], function($router) {

            $router->group(['prefix' => '/configuration'], function($router) {
                $router->get('/{configuration}','ConfigurationController@get');
                $router->options('/{configuration}', function (){});
                $router->get('/{name}/name','ConfigurationController@getByName');
                $router->options('/{name}/name', function (){});
                $router->post('','ConfigurationController@create');
                $router->options('', function (){});
                $router->patch('/{configuration}','ConfigurationController@update');

            });

            $router->group(['prefix' => '/administrator'], function($router) {

                $router->get('','AdministratorController@index');
                $router->get('/{administrator}','AdministratorController@get');
                $router->post('','AdministratorController@create');
                $router->patch('/{administrator}','AdministratorController@update');
                $router->delete('/{administrator}','AdministratorController@destroy');

                $router->options('', function (){});
                $router->options('/{administrator}', function (){});
            });


            $router->group(['prefix' => '/quinela'], function($router) {

                $router->get('','QuinielaController@index');
                $router->get('/{quiniela}','QuinielaController@get');
                $router->get('/{quiniela}/stats','QuinielaController@getStats');
                $router->get('/quiniela_type/{quiniela_type}','QuinielaController@getByQuinielaType');
                $router->post('','QuinielaController@create');
                $router->patch('/{quiniela}','QuinielaController@update');
                $router->delete('/{quiniela}','QuinielaController@destroy');

                $router->options('', function (){});
                $router->options('/{quiniela}', function (){});
                $router->options('/{quiniela}/stats', function (){});
                $router->options('/quiniela_type/{quiniela_type}', function (){});

            });

            $router->group(['prefix' => '/game'], function($router) {
                
                $router->get('','GameController@index');
                $router->get('/estructura/{ESTRUCTURA}','GameController@getByEstructura');
                $router->get('/{game}','GameController@get');
                $router->get('/update/refresh','GameController@notify');
                $router->post('','GameController@create');
                $router->patch('/all','GameController@updateAll');
                $router->patch('/{game}','GameController@update');
                $router->delete('/{game}','GameController@destroy');
                $router->options('', function (){});
                $router->options('/{game}', function (){});
                $router->options('/all', function (){});
                $router->options('/update/refresh', function (){});
                $router->options('/estructura/{ESTRUCTURA}',function (){});

            });

            $router->group(['prefix' => '/quinela_prediction'], function($router) {

                $router->get('','QuinielaPredicationsController@index');
                $router->get('/{quiniela_predication}','QuinielaPredicationsController@get');
                $router->get('/user/{user}','QuinielaPredicationsController@getPredictionsByUser');
                $router->post('','QuinielaPredicationsController@create');
                $router->get('/quiniela/{quinielaID}/user/{userID}', 'QuinielaPredicationsController@getPredictionsByUserQuiniela');
                $router->patch('/{quiniela_predication}','QuinielaPredicationsController@update');
                $router->delete('/{quiniela_predication}','QuinielaPredicationsController@destroy');

                $router->options('', function (){});
                $router->options('/{quiniela_predication}', function (){});
                $router->options('/user/{user}', function (){});

            });

            $router->group(['prefix' => '/quinela_award'], function($router) {

                $router->get('','QuinielaAwardController@index');
                $router->get('/{quiniela_award}','QuinielaAwardController@get');
                $router->post('','QuinielaAwardController@create');
                $router->patch('/{quiniela_award}','QuinielaAwardController@update');
                $router->delete('/{quiniela_award}','QuinielaAwardController@destroy');

                $router->options('', function (){});
                $router->options('/{quiniela_award}', function (){});

            });

            $router->group(['prefix' => '/quinela_invitation'], function($router) {

                $router->get('','QuinielaInvitationsController@index');
                $router->get('/{quiniela_invitation}','QuinielaInvitationsController@get');
                $router->get('/{user}/status/{status}','QuinielaInvitationsController@getQuinielasByState');
                $router->get('/quiniela/{quinielaID}/status/{status}','QuinielaInvitationsController@getQuinielasByquinielaID');
                $router->get('/{invitationID}/accept', 'InvitationController@acceptInvitation');
                $router->get('/{invitationID}/refuse', 'InvitationController@refuseInvitation');
                $router->post('','QuinielaInvitationsController@create');
                $router->post('/invite/byEmail','QuinielaInvitationsController@invite');
                $router->patch('/{quiniela_invitation}','QuinielaInvitationsController@update');
                $router->delete('/{quiniela_invitation}','QuinielaInvitationsController@destroy');

                $router->options('', function (){});
                $router->options('/{quiniela_invitation}', function (){});
                $router->options('/{user}/status/{status}', function (){});
                $router->options('/invite/byEmail', function (){});
                $router->options('/quiniela/{quinielaID}/status/{status}', function (){});
                $router->options('/{invitationID}/accept', function (){});
                $router->options('/{invitationID}/refuse', function (){});

            });

            $router->group(['prefix' => '/location'], function($router) {

                $router->get('','LocationsController@index');
                $router->get('/{location}','LocationsController@get');
                $router->post('','LocationsController@create');
                $router->patch('/{location}','LocationsController@update');
                $router->delete('/{location}','LocationsController@destroy');

                $router->options('', function (){});
                $router->options('/{location}', function (){});

            });

            $router->group(['prefix' => '/user'], function($router) {

                $router->get('','UsersController@index');
                $router->get('/{user}','UsersController@get');
                $router->post('','UsersController@create');
                $router->patch('/{user}','UsersController@update');
                $router->delete('/{user}','UsersController@destroy');

                $router->get('/{user}/quinela','UsersController@getMyQuinelas');
                $router->get('/{user}/quinela/belongs','UsersController@getQuinelas');
                $router->get('/{user}/quinela/invited','UsersController@getMyInvitedQuinelas');

                $router->options('', function (){});
                $router->options('/{user}', function (){});
                $router->options('/{user}/quinela', function (){});
                $router->options('/{user}/quinela/belongs', function (){});
                $router->options('/{user}/quinela/invited', function (){});
            });

            $router->group(['prefix' => '/countries_groups'], function($router) {

                $router->get('','CountriesGroupsController@index');
                $router->get('/{countries_groups}','CountriesGroupsController@get');
                $router->get('/{code}/code','CountriesGroupsController@getByCode');
                $router->post('','CountriesGroupsController@create');
                $router->patch('/{countries_groups}','CountriesGroupsController@update');
                $router->delete('/{countries_groups}','CountriesGroupsController@destroy');

                $router->options('', function (){});
                $router->options('/{countries_groups}', function (){});
                $router->options('/{code}/code', function (){});
            });

            $router->group(['prefix' => '/quinela_user'], function($router) {

                $router->get('','QuinielaUsersController@index');
                $router->get('/{quiniela_user}','QuinielaUsersController@get');
                $router->post('','QuinielaUsersController@create');
                $router->patch('/{quiniela_user}','QuinielaUsersController@update');
                $router->delete('/{quiniela_user}','QuinielaUsersController@destroy');

                $router->options('', function (){});
                $router->options('/{quiniela_user}', function (){});

            });

            $router->group(['prefix' => '/quinela_type'], function($router) {

                $router->get('','QuinielaTypeController@index');
                $router->get('/{quiniela_type}','QuinielaTypeController@get');
                $router->post('','QuinielaTypeController@create');
                $router->patch('/{quiniela_type}','QuinielaTypeController@update');
                $router->delete('/{quiniela_type}','QuinielaTypeController@destroy');

                $router->options('', function (){});
                $router->options('/{quiniela_type}', function (){});

            });

            $router->group(['prefix' => '/countries'], function($router) {

                $router->get('','CountriesController@index');
                $router->get('/{countries}','CountriesController@get');
                $router->post('','CountriesController@create');
                $router->patch('/{countries}','CountriesController@update');
                $router->delete('/{countries}','CountriesController@destroy');

                $router->options('', function (){});
                $router->options('/{countries}', function (){});

            });

            $router->group(['prefix' => '/structure'], function($router) {

                $router->get('','StructureController@index');
                $router->get('/{structure}','StructureController@get');
                $router->post('','StructureController@create');
                $router->patch('/{structure}','StructureController@update');
                $router->delete('/{structure}','StructureController@destroy');

                $router->options('', function (){});
                $router->options('/{structure}', function (){});

            });

            $router->group(['prefix' => '/groups'], function($router) {

                $router->get('','GroupsController@index');
                $router->get('/{groups}','GroupsController@get');
                $router->post('','GroupsController@create');
                $router->patch('/{groups}','GroupsController@update');
                $router->delete('/{groups}','GroupsController@destroy');

                $router->options('', function (){});
                $router->options('/{groups}', function (){});

            });

        });

    });

    /*$app->options('pagelist', function (){});
    $app->options('permissions/{type}', function (){});
    $app->options('countryList', function (){});*/

});
