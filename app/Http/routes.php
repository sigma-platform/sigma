<?php

/**
 * Rest API Routes
 */
Route::post('/api/auth/login', 'Rest\AuthController@login');
Route::get('/api/auth/logout', ['middleware' => 'token', 'uses' => 'Rest\AuthController@logout']);

/**
 * Site Routes
 */
Route::get('/', 'Site\HomeController@index');

Route::group(['middleware' => ['token', 'auth', 'is'], 'role' => 'admin'], function()
{
	// User
	Route::get('/user', 'Site\UserController@index');
	Route::get('/user/create', 'Site\UserController@create');
	Route::post('/user/store', 'Site\UserController@store');
	Route::get('/user/edit/{id}', 'Site\UserController@edit');
	Route::post('/user/update/{id}', 'Site\UserController@update');
	Route::get('/user/destroy/{id}', 'Site\UserController@destroy');

	//Project
	Route::get('/project', 'Site\ProjectController@index');
	Route::get('/project/create', 'Site\ProjectController@create');
	Route::post('/project/store', 'Site\ProjectController@store');
	Route::get('/project/edit/{id}', 'Site\ProjectController@edit');
	Route::post('/project/update/{id}', 'Site\ProjectController@update');
	Route::get('/project/destroy/{id}', 'Site\ProjectController@destroy');

	//ProjectGroup
	Route::post('/project-group/store', 'Site\ProjectGroupController@store');
});

Route::controllers([
	'auth' => 'Site\Auth\AuthController',
	'password' => 'Site\Auth\PasswordController'
]);
