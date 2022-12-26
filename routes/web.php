<?php
Auth::routes();
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
Route::get('/test', 'HomeController@test');

$router->group(['middleware' => ['auth']], function($router) {

    Route::get('admin/', 'HomeController@index');

    Route::prefix('admin/events')->group(function (){
        Route::get('/', 'EventController@index');
        Route::get('/add', 'EventController@add');
        Route::post('/add', 'EventController@save');
        Route::get('/edit/{id}', 'EventController@edit');
       
        Route::post('/edit', 'EventController@update');
        Route::get('/delete/{id}', 'EventController@delete');
    });

    Route::prefix('admin/news')->group(function (){
        Route::get('/', 'NewsController@index');
        Route::get('/add', 'NewsController@add');
        Route::post('/add', 'NewsController@save');
        Route::get('/edit/{id}', 'NewsController@edit');
        Route::post('/edit', 'NewsController@update');
        Route::get('/delete/{id}', 'NewsController@delete');
    });

    Route::prefix('admin/employees')->group(function (){
        Route::get('/', 'UserController@index');
        Route::get('/add', 'UserController@add');
        Route::post('/add', 'UserController@save');
        Route::get('/edit/{id}', 'UserController@edit');
        Route::post('/edit', 'UserController@update');
        Route::get('/delete/{id}', 'UserController@delete');
    });

    Route::prefix('admin/set_time')->group(function (){
        Route::get('/', 'TimeRoleController@index');
        Route::get('/add', 'TimeRoleController@add');
        Route::post('/add', 'TimeRoleController@save');
        Route::post('/add_to_loc', 'TimeRoleController@add_loc');
        Route::post('/del_to_loc', 'TimeRoleController@del_loc');
        Route::get('/role_change', 'TimeRoleController@filter');
        Route::get('/user_change', 'TimeRoleController@change_user');
        Route::get('/user_changed', 'TimeRoleController@changed_user');
        Route::get('/show', 'TimeRoleController@show');
        Route::get('/edit/{id}', 'TimeRoleController@edit');
        Route::post('/edit', 'TimeRoleController@update');
        Route::get('/delete/{id}', 'TimeRoleController@delete');
    });

    Route::prefix('admin/freetime')->group(function (){
        Route::get('/', 'FreetimeController@index');
        Route::get('/add', 'FreetimeController@add');
        Route::post('/add', 'FreetimeController@save');
        Route::get('/edit/{id}', 'FreetimeController@edit');
        Route::get('/show', 'FreetimeController@show');
        Route::post('/edit', 'FreetimeController@update');
        Route::get('/delete/{id}', 'FreetimeController@delete');
    });

    Route::prefix('admin/checktime')->group(function (){
        Route::get('/', 'ChecktimeController@index');
        Route::get('/add', 'ChecktimeController@add');
        Route::post('/add', 'ChecktimeController@save');
        Route::get('/user_change', 'ChecktimeController@filter');
        Route::get('/check/{id}', 'ChecktimeController@check');
        Route::get('/detail', 'ChecktimeController@detail');
        Route::get('/edit/{id}', 'ChecktimeController@edit');
        Route::post('/edit', 'ChecktimeController@update');
        Route::get('/delete/{id}', 'ChecktimeController@delete');
    });
});

$router->group(['middleware' => ['role_id']], function($router) {
    Route::get('admin/home', 'HomeController@index2');
});