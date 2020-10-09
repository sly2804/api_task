<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

	$router->get('/api/task','TaskController@read_all');
	$router->get('/api/task/{id}','TaskController@read');
	$router->post('/api/task/',['uses' =>'TaskController@create']);
	$router->put('/api/task/{id}','TaskController@modify');
	$router->delete('/api/task/{id}','TaskController@delete');



