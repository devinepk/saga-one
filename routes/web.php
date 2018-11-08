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

Route::get('journal/{journal}/invite', 'JournalController@invite')->name('journal.invite');
Route::get('journal/{journal}/contents', 'JournalController@contents')->name('journal.contents');
Route::get('journal/{journal}/delete', 'JournalController@confirmDelete')->name('journal.confirmDelete');
Route::get('journal/{journal}/add', 'JournalController@add')->name('journal.add');
Route::post('journal/{journal}/restore', 'JournalController@restore')->name('journal.restore');
Route::resource('journal', 'JournalController');

Route::resource('entry', 'EntryController');

Route::get('account', 'UsersController@account')->name('user.account');

Auth::routes(['verify' => true]);
