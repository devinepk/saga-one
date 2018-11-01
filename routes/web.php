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

Route::view('/', 'welcome');

Route::resource('journal', 'JournalController');

Route::prefix('user')->group(function() {

    Route::get('/', 'UsersController@index')->name('dashboard');
    Route::get('account', 'UsersController@account');

});

Auth::routes(['verify' => true]);
