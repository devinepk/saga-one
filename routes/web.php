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

Route::prefix('journal')->group(function() {

    Route::get('/', 'JournalController@index');
    Route::get('contents', 'JournalController@contents');
    Route::get('read', 'JournalController@read');
    Route::get('write', 'JournalController@write');
    Route::get('create', 'JournalController@create');
    Route::get('invite', 'JournalController@invite');

});
