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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::redirect('/', 'polls')->name('home');

// Poll Routes
Route::resource('polls', 'PollController')->middleware('auth');
Route::patch('polls/{id}/toggle', 'PollController@toggleActivation')->name('polls.toggle');
Route::resource('polls.options', 'PollOptionController')->except([
    'show', 'create', 'edit', 'index'
]);
Route::get('polls/{poll}/options/{option?}', 'PollOptionController@index')->name('polls.options.index')->middleware('auth');
Route::post('polls/{poll}/vote', 'PollOptionController@vote')->name('polls.options.vote');
Route::get('polls/{poll}/results', 'PollController@getResult')->name('polls.options.vote.result');
