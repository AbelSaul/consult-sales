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
//Proformas
Route::get('/proformas', 'ProformaController@index')->name('consultas')->middleware('verify');
Route::get('/proformas/{id}', 'ProformaController@edit')->middleware('verify');
//Clientes
Route::get('/clientes-form', 'ClientController@form')->name('clientes-form')->middleware('verify');
Route::get('/clientes/{id}', 'ClientController@edit')->middleware('verify');
//Cuentas por cobrar
Route::get('/cuentas-por-cobrar', 'FinanceController@receivable')->name('cuentas-por-cobrar')->middleware(['verify','receivables']);



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
