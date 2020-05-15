<?php

use Illuminate\Support\Facades\Route;

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

// Datatables
Route::post('/datatables', array('as' => 'datatables', 'uses' => 'DataTablesController@data'));

// User
$route = 'users';
$controller = 'UserController';
Route::group(array('prefix' => $route), function () use ($route, $controller) {
    Route::get('deleted', array('as' => $route.'.deleted', 'uses' => 'CRUDController@getRestore'));
	Route::post('restore', array('as' => $route.'.restore', 'uses' => 'CRUDController@postRestore'));
	Route::get('/', array('as' => $route, 'uses' => 'CRUDController@index'));
	Route::delete('delete', array('as' => $route.'.delete', 'uses' => 'CRUDController@destroy'));
	Route::get('create', array('as' => $route.'.create', 'uses' => 'CRUDController@create'));
	Route::post('create', array('as' => $route.'.store', 'uses' => $controller.'@store'));
	Route::get('{id}/edit', array('as' => $route.'.edit', 'uses' => 'CRUDController@edit'));
	Route::put('{id}/edit', array('as' => $route.'.update', 'uses' => $controller.'@update'));
	Route::get('{slug}', array('as' => $route.'.show', 'uses' => 'CRUDController@show'));
});

// User
$route = 'buys';
$controller = 'BuyController';
Route::group(array('prefix' => $route), function () use ($route, $controller) {
 //    Route::get('deleted', array('as' => $route.'.deleted', 'uses' => 'CRUDController@getRestore'));
	// Route::post('restore', array('as' => $route.'.restore', 'uses' => 'CRUDController@postRestore'));
	// Route::get('/', array('as' => $route, 'uses' => 'CRUDController@index'));
	// Route::delete('delete', array('as' => $route.'.delete', 'uses' => 'CRUDController@destroy'));
	Route::get('create', array('as' => $route.'.create', 'uses' => $controller.'@create'));
	Route::post('create', array('as' => $route.'.store', 'uses' => $controller.'@store'));
	// Route::get('{id}/edit', array('as' => $route.'.edit', 'uses' => 'CRUDController@edit'));
	// Route::put('{id}/edit', array('as' => $route.'.update', 'uses' => $controller.'@update'));
	// Route::get('{slug}', array('as' => $route.'.show', 'uses' => 'CRUDController@show'));
});
