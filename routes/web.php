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


$router->group(['prefix' => 'api/v1'], function ($router) {

    $router->get('people/{id}', 'PeopleController@show');

    $router->get('people', 'PeopleController@showAll');

    $router->post('people', 'PeopleController@create');

    $router->put('people/{id}', 'PeopleController@update');

    $router->delete('people/{id}', 'PeopleController@delete');
});