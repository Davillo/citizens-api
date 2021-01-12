<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| API ROUTES
|-------------------------------------------------------------------------
|
*/

$router->group(['prefix' => '/citizens'], function () use ($router) {
    $router->get('/', 'CitizenController@index');
    $router->post('/', 'CitizenController@store');
    $router->get('/{id:[0-9]+}', 'CitizenController@show');
    $router->put('/{id:[0-9]+}', 'CitizenController@update');
    $router->delete('/{id:[0-9]+}', 'CitizenController@destroy');
});
