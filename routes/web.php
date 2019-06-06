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
Route::get('/', 'HomeController@welcome');
Route::group(['middleware' => ['web', 'auth']], function () {
    Route::resource('questionCategory', 'QuestionCategoryController');
    Route::resource('testCategory', 'TestCategoryController');
    Route::resource('question', 'QuestionController');
    Route::resource('test', 'TestController');
    Route::resource('user', 'UserController');
    Route::get('questions/itens/{questionCategory}', 'QuestionController@indexFromCategory');
    Route::get('questions/itens/{questionCategory}/create', 'QuestionController@createFromCategory');
    Route::get('questions/itensWithoutCategory', 'QuestionController@indexWithoutCategory');
    Route::get('tests/itens/{testCategory}', 'TestController@indexFromCategory');
    Route::get('tests/itens/{testCategory}/create', 'TestController@createFromCategory');
    Route::get('tests/itensWithoutCategory', 'TestController@indexWithoutCategory');
    Route::get('tests/{test}/questions/{questionCategory?}', 'QuestionsInTestsController@index');
    Route::get('questions_in_tests/{test}/{question}/store', 'QuestionsInTestsController@store');
    Route::get('questions_in_tests/{test}/{question}/destroy', 'QuestionsInTestsController@destroy');
});