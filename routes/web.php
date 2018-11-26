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

Route::view('/', 'welcome')->name('welcome');

Route::get('journal/{journal}/contents', 'JournalController@contents')->name('journal.contents');
Route::get('journal/{journal}/add', 'JournalController@add')->name('journal.add');
Route::put('journal/{journal}/archive', 'JournalController@archive')->name('journal.archive');
Route::get('journal/{journal}/settings', 'JournalController@settings')->name('journal.settings');
Route::post('journal/{journal}/invite', 'JournalController@invite')->name('journal.invite');


Route::post('journal/{journal}/queue', 'Api\JournalAPIController@updateQueue')->name('api.journal.updateQueue');
Route::resource('journal', 'JournalController');

Route::post('entry/{entry}/comment', 'Api\CommentAPIController@add')->name('api.comment.add');

Route::resource('entry', 'EntryController');

Route::get('account', 'UsersController@account')->name('user.account');
Route::put('account', 'UsersController@update')->name('user.update');

Auth::routes(['verify' => true]);

// Invites
Route::get('invite', 'InviteController@index')->name('invite.index');
Route::get('invite/verify/{id}', 'InviteController@verify')->name('invite.verify');
Route::get('invite/{invite}', 'InviteController@show')->name('invite.show');
Route::post('invite/{invite}', 'InviteController@accept')->name('invite.accept');
Route::delete('invite/{invite}', 'InviteController@delete')->name('invite.delete');
Route::get('invite/{invite}/decline', 'InviteController@decline')->name('invite.decline');
Route::get('invite/{invite}/resend', 'InviteController@resend')->name('invite.resend');

// Notifications
Route::post('notification/{notification}/read', 'NotificationController@markAsRead')->name('notification.read');
