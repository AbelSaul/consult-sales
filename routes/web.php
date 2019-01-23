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

Route::view('/', 'home');
Route::view('/login', 'login');

Route::get('/data', function () {
    $user = [
        'usuario' => 'ADMIN',
        'contraseña' => '2531',
        'database' => 'nbdata2018_1'
    ];

    session(['auth' => $user]);

    return session('auth');
});

