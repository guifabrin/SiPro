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
    return view('home.welcome');
});

Route::get('/policy', function () {
    return view('home.policy');
});

Auth::routes();

Route::group(['middleware' => 'web'], function () {
    Route::get('/redirect', 'SocialAuthController@redirect');
    Route::get('/callback', 'SocialAuthController@callback');

    Route::get('/user/', 'UserController@read');
    Route::get('/user/password', 'UserController@passwordForm');
    Route::post('/user/password', 'UserController@passwordUpdate');
});
Route::get('/logout', function(){
	Auth::logout();
    return view('home.welcome');
});