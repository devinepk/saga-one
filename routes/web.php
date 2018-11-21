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

// Route::post('entry/{entry}/comment', 'Api\CommentApiController@add')->name('api.comment.add');

Route::post('entry/{entry}/comment', function(Illuminate\Http\Request $request, App\Entry $entry) {

    // No validation necessary as message is a text field
    $comment = new App\Comment;
    $comment->message = htmlspecialchars($request->input('message'));
    $comment->user()->associate(Auth::user());
    $entry->comments()->save($comment);

    // Return an updated set of comments for this entry
    return $entry->comments()->with('user')->get()->toJson();

})->name('api.comment.add');

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

Route::get('/mailable', function () {
    return new App\Mail\UserWelcomeMailable(App\User::find(1));
});
