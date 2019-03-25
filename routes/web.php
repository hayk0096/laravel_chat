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

Route::get('/', 'ChatController@getPublicChatPage')->name('public.chat.page');

Route::post('/messages', 'ChatController@sendPublicMessage')->name('public.message.submit');


Route::get('/private/{room}', [
    'as' => 'private.room.page',
    'uses' => 'ChatController@getPrivateRoomPage',
    'middleware' => 'auth'
]);

Route::post('/room-messages', ['as' => 'private.message.submit', 'uses' => 'ChatController@sendPrivateMessage']);


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
