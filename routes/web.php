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

Auth::routes();

Route::get('/', function () {
    return view('home.welcome');
});
Route::get('/policy', function () {
    return view('home.policy');
});
Route::get('/redirect', 'SocialAuthController@redirect');
Route::get('/callback', 'SocialAuthController@callback');
Route::get('/logout', function () {
    Auth::logout();
    return view('home.welcome');
});
Route::group(['middleware' => ['web', 'auth']], function () {
    Route::resource('questionCategory', 'QuestionCategoryController');
    Route::resource('testCategory', 'TestCategoryController');
    Route::resource('question', 'QuestionController');
    Route::resource('test', 'TestController');
    Route::get('questions/itens/{questionCategory}', 'QuestionFromCategoryController@index');
    Route::get('questions/itens/{questionCategory}/create', 'QuestionFromCategoryController@create');
    Route::get('questions/itensWithoutCategory', 'QuestionWithoutCategoryController@index');
    Route::get('tests/{test}/questions/{questionCategory?}', 'QuestionsInTestsController@index');
    Route::get('tests/itens/{testCategory}', 'TestFromCategoryController@index');
    Route::get('tests/itens/{testCategory}/create', 'TestFromCategoryController@create');
    Route::get('tests/itensWithoutCategory', 'TestWithoutCategoryController@index');
    Route::get('questions_in_tests/{test}/{question}/store', 'QuestionsInTestsController@store');
    Route::get('questions_in_tests/{test}/{question}/destroy', 'QuestionsInTestsController@destroy');
});