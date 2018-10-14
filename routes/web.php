<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['jwt.auth','api-header']], function () {

    // all routes to protected resources are registered here
    Route::get('users/list', function(){
        $users = App\User::all();

        $response = ['success'=>true, 'data'=>$users];
        return response()->json($response, 201);
    });
});

Route::group(['middleware' => 'api-header'], function () {

    // The registration and login requests doesn't come with tokens
    // as users at that point have not been authenticated yet
    // Therefore the jwtMiddleware will be exclusive of them
    Route::post('user/login', 'UserController@login');
    Route::post('user/register', 'UserController@register');
});
