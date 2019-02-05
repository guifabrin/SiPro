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
//
//	Route::get('/user/', 'UserController@read');
//	Route::get('/user/password', 'UserController@passwordForm');
//	Route::post('/user/password', 'UserController@updatePassword');
//
//
//	Route::resource('/questions', 'QuestionsController');
//	Route::get('/questions/confirm/{id}', 'QuestionsController@confirm');
//
//	Route::resource('/tests/categories', 'TestCategoriesController');
//	Route::get('/tests/categories/confirm/{id}', 'TestCategoriesController@confirm');
//
//	Route::resource('/tests', 'TestsController');
//	Route::get('/tests/confirm/{id}', 'TestsController@confirm');
//	Route::get('/tests/categorie/{id}', 'TestsController@index_');
//	Route::get('/tests/categorie/{id}/create', 'TestsController@create_');
//
//	Route::post('/questions_in_tests/store', 'QuestionsInTestsController@store');
//	Route::post('/questions_in_tests/destroy', 'QuestionsInTestsController@destroy');
});
Route::get('/logout', function () {
    Auth::logout();
    return view('home.welcome');
});


Route::group(['middleware' => ['web', 'auth']], function () {
    Route::resource('questionCategory', 'QuestionCategoryController');
    Route::resource('testCategory', 'TestCategoryController');
    Route::resource('question', 'QuestionController');
    Route::get('questions/itens/{questionCategory}', 'QuestionFromCategoryController@index');
    Route::get('questions/itens/{questionCategory}/create', 'QuestionFromCategoryController@create');
    Route::get('questions/itensWithoutCategory', 'QuestionWithoutCategoryController@index');
});