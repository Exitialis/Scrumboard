<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'], function (\Illuminate\Routing\Router $router) {
    $router->post('login', 'Auth\AuthController@login')->name('auth.login');
    $router->post('register', 'Auth\AuthController@register')->name('auth.register');
});

Route::group(['middleware' => 'auth:api'], function (\Illuminate\Routing\Router $router) {
    $router->group(['prefix' => 'task'], function (\Illuminate\Routing\Router $router) {
        $router->post('/', 'TasksController@create')->name('tasks.create');
    });
});
