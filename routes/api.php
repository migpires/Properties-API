<?php

use Illuminate\Http\Request;

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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('/createuser', 'UserController@createUser');

Route::post('/login', 'UserController@login');


Route::group(['prefix' => 'properties'], function () {

    Route::get('/', 'PropertyController@getAllProperties');

    Route::get('/{user_id}', 'PropertyController@getPropertiesByID');

    Route::get('/{latitude}/{longitude}/{radius}/{unit?}', 'PropertyController@getPropertiesByRadius');

    Route::group(['middleware' => 'auth:api'], function () {

        Route::post('/update/{id}/{field}/{value}', 'PropertyController@updateProperty');

    });

});
