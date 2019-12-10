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

$router->group(
    ['prefix' => 'cds'],
    function ($app) {
        $app->get('', 'MusicController@getCDs');
        $app->get('/{id}', 'MusicController@getCD');
        $app->post('', 'MusicController@createCd');
        $app->put('/{id}', 'MusicController@updateCd');
        $app->delete('/{id}', 'MusicController@deleteCd');
    }
);

