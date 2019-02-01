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

Route::view('/', 'home')->middleware('verify');

Route::get('/login', function() {
    return view('login', ['header' => 'none']);
});

Route::get('/logout', function() {
    session()->forget('user');
    return redirect('login');
});

Route::get('/proforma/{doc}', 'PdfController@ticket')->middleware('verify');
