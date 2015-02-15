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

Route::get('/', 'HomeController@index');

Route::group(['middleware' => ['auth', 'is'], 'role' => 'admin'], function()
{
	// User
	Route::get('/user', 'UserController@index');
	Route::get('/user/create', 'UserController@create');
	Route::post('/user/store', 'UserController@store');
	Route::get('/user/edit/{id}', 'UserController@edit');
	Route::post('/user/update/{id}', 'UserController@update');
	Route::get('/user/destroy/{id}', 'UserController@destroy');

	//Project
	Route::get('/project', 'ProjectController@index');
	Route::get('/project/create', 'ProjectController@create');
	Route::post('/project/store', 'ProjectController@store');
	Route::get('/project/edit/{id}', 'ProjectController@edit');
	Route::post('/project/update/{id}', 'ProjectController@update');
	Route::get('/project/destroy/{id}', 'ProjectController@destroy');

	//ProjectGroup
	Route::post('/project-group/store', 'ProjectGroupController@store');
});

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController'
]);
