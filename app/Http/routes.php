<?php

/**
 * Rest API Routes
 */
Route::post('/api/auth/login', 'Rest\AuthController@login');
Route::get('/api/auth/logout', ['middleware' => 'token', 'uses' => 'Rest\AuthController@logout']);
Route::group(['prefix' => 'api', 'middleware' => 'token', 'namespace' => 'Rest'], function()
{
	Route::get('/project/user', 'ProjectController@indexForUser');
	//Route::get('/project', 'ProjectController@index');
	//Route::post('/project/store', 'ProjectController@store');
	Route::get('/project/{id}', 'ProjectController@show');
	//Route::put('/project/{id}', 'ProjectController@update');
});

/**
 * Site Routes
 */
Route::group(['middleware' => ['token', 'auth', 'is'], 'namespace' => 'Site', 'role' => 'admin'], function()
{
	Route::get('/', 'HomeController@index');

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
	'auth' => 'Site\Auth\AuthController',
	'password' => 'Site\Auth\PasswordController'
]);
