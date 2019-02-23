<?php

use Illuminate\Support\Facades\DB;

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

Route::view('/', 'home')->middleware('verify');
Route::get('/proformas', 'ProformaController@index')->name('proformas')->middleware('verify');
Route::get('/proformas/{id}', 'ProformaController@edit')->middleware('verify');

Route::get('/login', function() {
    return view('login', ['header' => 'none']);
})->middleware('redirect');

Route::get('/data', function() {
    $params = DB::table('parametros')->first();
    return $params->impuesto_nombre;
})->middleware('verify');

Route::get('/logout', function() {
    session()->forget('user');
    return redirect('login');
})->name('logout');

Route::get('/proforma/{doc}', 'PdfController@ticket')->middleware('verify');
