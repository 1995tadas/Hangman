<?php

use Illuminate\Support\Facades\Auth;
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

Route::prefix('words')->name('words.')->middleware('auth')->group(function () {
    Route::get('/', 'WordController@index')->name('index');
    Route::view('create', 'words.create')->name('create');
    Route::post('/', 'WordController@store')->name('store');
    Route::where(['id', '[0-9]+'])->group(function () {
        Route::get('{id}', 'WordController@edit')->name('edit');
        Route::put('{id}', 'WordController@update')->name('update');
        Route::delete('{id}', 'WordController@destroy')->name('destroy');
    });
});

Route::get('/', 'GameController@play')->name('game.play');


Auth::routes([
    'register' => config('app.registration'),
    'reset' => false,
    'verify' => false
]);

Route::get('/home', 'HomeController@index')->name('home');
