<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
 */
// App::setLocale('en');

if(version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}

Carbon\Carbon::setLocale('pl');
setlocale(LC_TIME, 'pl_PL.UTF-8'); 
Auth::routes();

Route::get('/', 'ChannelController@index');
Route::resource('channel', 'ChannelController');

Route::post('/channel/{channel}/message', 'ChannelMessageController@store');
Route::delete('/messages/{channelMessage}', 'ChannelMessageController@destroy');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('user', 'UserController', ['only' => [
        'edit', 'update',
    ]]);

});

// Admin routes
Route::group(['prefix' => 'admin', 'as' =>'admin.'], function () {
    Route::get('/', 'Admin\AdminController@index')->name('index');
    Route::resource('users', 'Admin\UserController');

    Route::resource('channels', 'Admin\ChannelController');
    Route::post('channels/{channel}/accept', 'Admin\ChannelController@accept')->name('channels.accept');
    Route::post('channels/{channel}/reject', 'Admin\ChannelController@reject')->name('channels.reject');
    Route::post('channels/{channel}/message', 'Admin\ChannelController@storemsg')->name('channels.message');

    Route::resource('messages', 'Admin\MessageController', ['only' => ['destroy', 'update']]);
});
