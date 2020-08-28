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

Route::view('/', 'layout.app');

Route::name('words.')->group(function () {
    Route::get('words', 'WordController@index')->name('index');
    Route::view('words/create', 'words.create')->name('create');
    Route::post('words', 'WordController@store')->name('store');
    Route::get('words/edit/{word}', 'WordController@edit')->where('word', '[0-9]+')->name('edit');
    Route::put('words/{id}', 'WordController@update')->where('id', '[0-9]+')->name('update');
});

