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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['prefix' => 'v1', 'namespace' => 'Api\V1'], function(){
    Route::post('/register', 'UserdController@register');
    Route::post('/login', 'UserdController@login');
    Route::get('/checktimes', 'CheckController@test');
});

//api/v1
Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'v1', 'namespace' => 'Api\V1'], function(){
    Route::apiResource('users', UserdController::class);

    Route::prefix('/check')->group(function (){
        Route::get('/', 'CheckController@index');
        Route::post('/add', 'CheckController@store');
        Route::get('/checktimes', 'CheckController@test');
        Route::get('/checkpolygon', 'CheckController@polygon');
        Route::get('/show/{id}', 'CheckController@show');
        Route::post('/edit', 'CheckController@update');
        Route::get('/delete/{id}', 'CheckController@delete');
    });
    Route::prefix('/news')->group(function (){
        Route::get('/', 'NewsController@index');
        Route::post('/add', 'NewsController@store');
        Route::get('/show/{id}', 'NewsController@show');
        Route::post('/edit', 'NewsController@update');
        Route::get('/delete/{id}', 'NewsController@delete');
    });
    Route::prefix('/event')->group(function (){
        Route::get('/', 'EventController@index');
        Route::post('/add', 'EventController@store');
        Route::get('/show/{id}', 'EventController@show');
        Route::get('/category', 'EventController@category');
        Route::post('/edit', 'EventController@update');
        Route::get('/delete/{id}', 'EventController@delete');
    });
    Route::prefix('/freetimes')->group(function (){
        Route::get('/', 'FreetimeController@index');
        Route::post('/add', 'FreetimeController@store');
        Route::get('/show/{id}', 'FreetimeController@show');
        Route::get('/category', 'FreetimeController@category');
        Route::post('/edit', 'FreetimeController@update');
        Route::get('/delete/{id}', 'FreetimeController@delete');
    });
});
