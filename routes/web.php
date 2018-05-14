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

Route::resource('reservarbutaca', 'ReservarButacaController')->only([
    'index', 'show', 'store', 'create', 'edit', 'update', 'destroy'
]);


Route::get('/', function () {
    return view('create');
});
