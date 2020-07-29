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

Route::group(array('middleware' => 'guest'), function () {
	Route::get('/', array('as' => 'auth', 'uses' => 'AuthController@getLogin'));
	Route::post('/login', array('as' => 'auth.store', 'uses' => 'AuthController@postLogin'));
});

/*
 * Admin
 */
Route::group(array('middleware' => 'sentinelAuth'), function () {
	// Logout
	Route::get('/logout', array('as' => 'logout', 'uses' => 'AuthController@logout'));

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

	// Sale
	$route = 'sales';
	$controller = 'SaleController';
	Route::group(array('prefix' => $route), function () use ($route, $controller) {
		Route::get('finished/{slug}', array('as' => $route.'.show', 'uses' => $controller.'@show'));
	    Route::get('finished', array('as' => $route.'.finished', 'uses' => $controller.'@finished'));
	    Route::get('/', array('as' => $route, 'uses' => $controller.'@index'));
		Route::get('{slug_buy}', array('as' => $route.'.create', 'uses' => $controller.'@create'));
		Route::post('create', array('as' => $route.'.store', 'uses' => $controller.'@store'));
		Route::delete('delete', array('as' => $route.'.delete', 'uses' => $controller.'@destroy'));
	});

	// Canasta Rosa
	$route = 'canastarosa';
	$controller = 'CanastaRosaController';
	Route::group(array('prefix' => $route), function () use ($route, $controller) {
		Route::get('datepicker/{day}/{month}/{year}', array('as' => $route.'.getschedules', 'uses' => $controller.'@getSchedules'));
	    Route::get('/', array('as' => $route, 'uses' => $controller.'@create'));
	    Route::get('{slug_buy}', array('as' => $route.'.edit', 'uses' => $controller.'@edit'));
		Route::post('create', array('as' => $route.'.store', 'uses' => $controller.'@store'));
	});

	// Finance
	$route = 'finances';
	$controller = 'FinanceController';
	Route::group(array('prefix' => $route), function () use ($route, $controller) {
		Route::get('finished/{slug}', array('as' => $route.'.show', 'uses' => $controller.'@show'));
	    Route::get('finished', array('as' => $route.'.finished', 'uses' => $controller.'@finished'));
	    Route::get('/', array('as' => $route, 'uses' => $controller.'@index'));
		Route::get('{slug_buy}', array('as' => $route.'.create', 'uses' => $controller.'@create'));
		Route::post('create', array('as' => $route.'.store', 'uses' => $controller.'@store'));
		Route::patch('return', array('as' => $route.'.return', 'uses' => $controller.'@return'));
		Route::delete('delete', array('as' => $route.'.delete', 'uses' => 'CRUDController@destroy'));
	});

	// Building
	$route = 'buildings';
	$controller = 'BuildingController';
	Route::group(array('prefix' => $route), function () use ($route, $controller) {
		Route::get('finished/{slug}', array('as' => $route.'.show', 'uses' => $controller.'@show'));
	    Route::get('finished', array('as' => $route.'.finished', 'uses' => $controller.'@finished'));
	    Route::get('/', array('as' => $route, 'uses' => $controller.'@index'));
		Route::get('{slug_buy}', array('as' => $route.'.create', 'uses' => $controller.'@create'));
		Route::post('create', array('as' => $route.'.store', 'uses' => $controller.'@store'));
		Route::patch('return', array('as' => $route.'.return', 'uses' => $controller.'@return'));
		Route::delete('delete', array('as' => $route.'.delete', 'uses' => 'CRUDController@destroy'));
	});

	// Shipping
	$route = 'shippings';
	$controller = 'ShippingController';
	Route::group(array('prefix' => $route), function () use ($route, $controller) {
		Route::get('finished/{slug}', array('as' => $route.'.show', 'uses' => $controller.'@show'));
	    Route::get('finished', array('as' => $route.'.finished', 'uses' => $controller.'@finished'));
	    Route::get('/', array('as' => $route, 'uses' => $controller.'@index'));
		Route::get('{slug_buy}', array('as' => $route.'.create', 'uses' => $controller.'@create'));
		Route::post('create', array('as' => $route.'.store', 'uses' => $controller.'@store'));
		Route::patch('return', array('as' => $route.'.return', 'uses' => $controller.'@return'));
		Route::delete('delete', array('as' => $route.'.delete', 'uses' => 'CRUDController@destroy'));
	});

	// Delivery
	$route = 'deliveries';
	$controller = 'DeliveryController';
	Route::group(array('prefix' => $route), function () use ($route, $controller) {
		Route::get('finished/{slug}', array('as' => $route.'.show', 'uses' => $controller.'@show'));
	    Route::get('finished', array('as' => $route.'.finished', 'uses' => $controller.'@finished'));
	    Route::get('/', array('as' => $route, 'uses' => $controller.'@index'));
		Route::get('{slug_buy}', array('as' => $route.'.create', 'uses' => $controller.'@create'));
		Route::post('create', array('as' => $route.'.store', 'uses' => $controller.'@store'));
		Route::delete('delete', array('as' => $route.'.delete', 'uses' => 'CRUDController@destroy'));
	});

	// User
	$route = 'products';
	$controller = 'ProductController';
	Route::group(array('prefix' => $route), function () use ($route, $controller) {
	    Route::get('deleted', array('as' => $route.'.deleted', 'uses' => $controller.'@getRestore'));
		Route::post('restore', array('as' => $route.'.restore', 'uses' => $controller.'@postRestore'));
		Route::get('/', array('as' => $route, 'uses' => $controller.'@index'));
		Route::delete('delete', array('as' => $route.'.delete', 'uses' => $controller.'@destroy'));
		Route::get('create', array('as' => $route.'.create', 'uses' => $controller.'@create'));
		Route::post('create', array('as' => $route.'.store', 'uses' => $controller.'@store'));
		Route::get('{id}/edit', array('as' => $route.'.edit', 'uses' => $controller.'@edit'));
		Route::put('{id}/edit', array('as' => $route.'.update', 'uses' => $controller.'@update'));
		Route::get('{slug}', array('as' => $route.'.show', 'uses' => $controller.'@show'));
	});
});

// User
$route = 'buys';
$controller = 'BuyController';
Route::group(array('prefix' => $route), function () use ($route, $controller) {
	Route::get('datepicker/{day}/{month}/{year}', $controller.'@getSchedules');
	Route::get('create', array('as' => $route.'.create', 'uses' => $controller.'@create'));
	Route::post('create', array('as' => $route.'.store', 'uses' => $controller.'@store'));
});
