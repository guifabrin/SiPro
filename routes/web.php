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
	Route::post('/user/password', 'UserController@updatePassword');

	Route::resource('questions/categories', 'QuestionCategoriesController');
	Route::get('questions/categories/confirm/{id}', 'QuestionCategoriesController@confirm');

	Route::resource('questions', 'QuestionsController');
	Route::get('questions/confirm/{id}', 'QuestionsController@confirm');
	Route::get('questions/categorie/{id}', 'QuestionsController@index_');
	Route::get('questions/categorie/{id}/create', 'QuestionsController@create_');
	Route::post('questions/categorie/{id}/store', 'QuestionsController@store_');

	Route::resource('tests/categories', 'TestCategoriesController');
	Route::get('tests/categories/confirm/{id}', 'TestCategoriesController@confirm');

});
Route::get('/logout', function () {
	Auth::logout();
	return view('home.welcome');
});