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

Route::get('/', function() { return view('welcome'); });

Route::get('/read', function() {
    return view('journal.read');
});

Route::get('/write', function() {
    return view('journal.add_entry');
});



