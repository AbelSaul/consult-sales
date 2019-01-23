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

Route::get('connections', 'ConnectionController@index');
Route::get('products', 'ProductController@index')->middleware('changedb');
Route::get('sellers', 'SellerController@index');
Route::get('clients', 'ClientController@index');
Route::post('proforma/create', 'ProformaController@create');
Route::post('login', 'SessionController@login');
