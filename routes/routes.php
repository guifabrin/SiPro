<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::group(['middleware' => ['web']], function () {
    Route::get('/', function () {
        return view('home.welcome');
    });

    Route::get('/policy', function(){
        return view('home.policy');
    });
});

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/redirect', 'SocialAuthController@redirect');
    Route::get('/callback', 'SocialAuthController@callback');

    Route::get('/home', 'HomeController@index');

    Route::get('/home/user/', 'HomeController@read');
    Route::get('/home/user/avatar', 'HomeController@getAvatar');
    Route::get('/home/user/password', 'HomeController@passwordForm');
    Route::post('/home/user/password', 'HomeController@passwordUpdate');

    Route::post('/home/upload/image', 'UploadsController@image');
    Route::post('/home/upload/html', 'UploadsController@html2doc');

    Route::get('/home/questions', 'QuestionsController@read');
    Route::get('/home/questions/read/', 'QuestionsController@read');
    Route::get('/home/questions/read/{selectedCategorie}', 'QuestionsController@read');
    Route::get('/home/questions/create', 'QuestionsController@form');
    Route::get('/home/questions/create/{selectedCategorie}', 'QuestionsController@form');
    Route::post('/home/questions/create', 'QuestionsController@createOrUpdate');
    Route::post('/home/questions/create/{selectedCategorie}', 'QuestionsController@createOrUpdate');
    Route::get('/home/questions/delete/{id}', 'QuestionsController@confirm');
    Route::post('/home/questions/delete/{id}', 'QuestionsController@delete');
    Route::get('/home/questions/update/{id}', 'QuestionsController@form');
    Route::post('/home/questions/update/{id}', 'QuestionsController@createOrUpdate');

    Route::get('/home/questions/categories', 'QuestionCategoriesController@read');
    Route::get('/home/questions/categories/create', 'QuestionCategoriesController@form');
    Route::post('/home/questions/categories/create', 'QuestionCategoriesController@createOrUpdate');
    Route::get('/home/questions/categories/delete/{id}', 'QuestionCategoriesController@confirm');
    Route::post('/home/questions/categories/delete/{id}', 'QuestionCategoriesController@delete');
    Route::get('/home/questions/categories/update/{id}', 'QuestionCategoriesController@form');
    Route::post('/home/questions/categories/update/{id}', 'QuestionCategoriesController@createOrUpdate');

    Route::get('/home/tests', 'TestsController@read');
    Route::get('/home/tests/create', 'TestsController@form');
    Route::get('/home/tests/create/{selected_categorie}', 'TestsController@form');
    Route::post('/home/tests/create', 'TestsController@createOrUpdate');
    Route::post('/home/tests/create/{selected_categorie}', 'TestsController@createOrUpdate');
    Route::get('/home/tests/delete/{id}', 'TestsController@confirm');
    Route::post('/home/tests/delete/{id}', 'TestsController@delete');
    Route::get('/home/tests/update/{id}', 'TestsController@form');
    Route::post('/home/tests/update/{id}', 'TestsController@createOrUpdate');

    Route::get('/home/tests/show/{id}', 'TestsController@show');
    Route::get('/home/tests/show/{id}/data/', 'TestsController@showData');
    
    Route::get('/home/tests/categories', 'TestCategoriesController@read');
    Route::get('/home/tests/categories/create', 'TestCategoriesController@form');
    Route::post('/home/tests/categories/create', 'TestCategoriesController@createOrUpdate');
    Route::get('/home/tests/categories/delete/{id}', 'TestCategoriesController@confirm');
    Route::post('/home/tests/categories/delete/{id}', 'TestCategoriesController@delete');
    Route::get('/home/tests/categories/update/{id}', 'TestCategoriesController@form');
    Route::post('/home/tests/categories/update/{id}', 'TestCategoriesController@createOrUpdate');

    Route::post('/home/questions_in_tests/create', 'QuestionsInTestsController@create');
    Route::post('/home/questions_in_tests/delete', 'QuestionsInTestsController@delete');
    Route::get('/home/questions_in_tests/json/{question_categorie_id}/{test_id}', 'QuestionsInTestsController@json');
});