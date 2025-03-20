<?php

/*

Developer: Sergio Eduardo Santillana Lopez.
Last update: 15/04/2021.

*/

use App\Mail\NewUserWelcomeMail;

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

Auth::routes();

Route::get('/email', function () {
    return new NewUserWelcomeMail();
});

Route::post('follow/{user}', 'FollowsController@store');

Route::post('like/post/{post}', 'LikesController@storePost');
Route::post('like/comment/{comment}', 'LikesController@storeComment');

Route::get('/', 'PostsController@index');
Route::get('/p/create', 'PostsController@create');
Route::post('/p', 'PostsController@store');
// The routes order is important in this case because if '/p/{post}' is before '/p/create', '/p/{post}' will match first and we'll never get to
// '/p/create'. That's why '/p/{post}' has to be left at the end
Route::get('/p/{post}', 'PostsController@show');

Route::post('/c/getComments/', 'CommentsController@getComments')->name('comment.getComments');
Route::get('/c/create', 'CommentsController@create');
Route::post('/c', 'CommentsController@store');

Route::post('/reply/create', 'RepliesController@store');
Route::post('/reply/index', 'RepliesController@index');

Route::post('/profile/getProfiles/', 'ProfilesController@getProfiles')->name('profile.getProfiles');
Route::get('/profile/{user}', 'ProfilesController@index')->name('profile.show');

//Route::get('/profile/{user}', 'MessagesController@store')->name('message.store');

Route::patch('/profile/{user}', 'ProfilesController@update')->name('profile.update');
Route::get('/profile/{user}/notifications', 'NotificationsController@index');
Route::post('/profile/{user}/notifications/numberNotifications', 'NotificationsController@getNumberNotifications');
Route::get('/profile/{user}/conversations', 'ConversationsController@index');
Route::get('/profile/{user}/messages', 'MessagesController@index');
Route::get('/profile/{user}/edit', 'ProfilesController@edit')->name('profile.edit');
Route::get('/profile/{user}/followers', 'ProfilesController@followers');
Route::get('/profile/{user}/following', 'ProfilesController@following');

Route::get('/m', 'MessagesController@sendMessage');
Route::get('/m/getMessage', 'MessagesController@getMessage');
Route::post('/m', 'MessagesController@store');
