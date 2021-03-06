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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group([
    'prefix' => 'api/clients',
    'namespace' => '\App\Http\Controllers'
], function() use($router){
    $router->get('/', 'ClientsController@index');
    $router->get('/{id}', 'ClientsController@show');
    $router->post('/', 'ClientsController@store');
    $router->put('/{id}', 'ClientsController@update');
    $router->delete('/{id}', 'ClientsController@destroy');
});

$router->group([
    'prefix' => 'api/clients/{client}/addresses',
    'namespace' => '\App\Http\Controllers'
], function() use($router){
    $router->get('/', 'AddressesController@index');
    $router->get('/{id}', 'AddressesController@show');
    $router->post('/', 'AddressesController@store');
    $router->put('/{id}', 'AddressesController@update');
    $router->delete('/{id}', 'AddressesController@destroy');
});