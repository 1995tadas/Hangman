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

Route::prefix('words')->name('words.')->group(function () {
    Route::get('/', 'WordController@index')->name('index');
    Route::view('create', 'words.create')->name('create');
    Route::post('/', 'WordController@store')->name('store');
    Route::get('edit/{word}', 'WordController@edit')->where('word', '[0-9]+')->name('edit');
    Route::put('{id}', 'WordController@update')->where('id', '[0-9]+')->name('update');
    Route::delete('{word}', 'WordController@destroy')->where('id', '[0-9]+')->name('destroy');
});

