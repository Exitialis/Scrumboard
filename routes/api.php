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
    $router->group(['middleware' => 'auth'], function (\Illuminate\Routing\Router $router) {
        $router->get('me', 'Auth\AuthController@user')->name('auth.me');
        $router->get('logout', 'Auth\AuthController@logout')->name('auth.logout');
    });
});



Route::group(['middleware' => 'auth:api'], function (\Illuminate\Routing\Router $router) {
    $router->group(['prefix' => 'task'], function (\Illuminate\Routing\Router $router) {
        $router->put('{task}', 'TasksController@update')->name('tasks.update')->middleware('can:update,task');
        $router->post('/', 'TasksController@create')->name('tasks.create');
    });
    $router->group(['prefix' => 'sprint'], function (\Illuminate\Routing\Router $router) {
        $router->put('{sprint}', 'SprintsController@update')->name('sprints.update')->middleware('can:update,sprint');
        $router->post('/', 'SprintsController@create')->name('sprints.create');
    });
});
