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

Route::post('login', 'SessionController@login');
Route::get('connections', 'ConnectionController@index');
Route::get('validate_ruc', 'ConnectionController@validateRuc');
Route::get('products', 'ProductController@index')->middleware('verify');
Route::get('search-products', 'ProductController@search')->middleware('verify');
Route::get('sellers', 'SellerController@index')->middleware('verify');
Route::get('seller_user', 'SellerController@findSeller')->middleware('verify');
Route::get('users', 'SellerController@users')->middleware('verify');

Route::get('clients', 'ClientController@index')->middleware('verify');
Route::get('find_people', 'ClientController@findPeople')->middleware('verify');
Route::post('client/create', 'ClientController@create')->middleware('verify');
Route::get('/clients-list', 'ClientController@list')->name('clientes-list')->middleware('verify');

//PROFORMAS
Route::get('conditions', 'ProformaController@conditions')->middleware('verify');
Route::get('search-proformas', 'ProformaController@search')->middleware('verify');
Route::get('total-proformas', 'ProformaController@getTotalProformas')->middleware('verify');
Route::post('proforma/create', 'ProformaController@create')->middleware('verify');
Route::post('proforma/update', 'ProformaController@update')->middleware('verify');
