<?php

/**
 * Rest API Routes
 */
Route::post('/api/auth/login', 'Rest\AuthController@login');
Route::group(['prefix' => 'api', 'middleware' => 'token', 'namespace' => 'Rest'], function()
{
	Route::get('/auth/logout', 'AuthController@logout');

	// Project
	Route::get('/project/user/{role?}', 'ProjectController@indexForUser');
	Route::get('/project/{id}', 'ProjectController@show');

	// Task
	Route::get('/project/{projectId}/task', 'TaskController@indexForUserWithProject');
	Route::get('/version/{versionId}/task', 'TaskController@indexForUserWithVersion');
	Route::get('/task/{id}', 'TaskController@show');

	//User
	Route::get('/project/{projectId}/user', 'UserController@indexForProject');
	Route::get('/user/{id}', 'UserController@show');

	//Version
	Route::get('/version/{id}', 'VersionController@show');

	Route::group(['middleware' => 'is', 'role' => 'dev'], function()
	{
		// Task
		Route::put('/task/update/{id}/progress', 'TaskController@updateProgress');

		// Comment
		Route::get('/task/{taskId}/comment', 'CommentController@indexForTask');
		Route::resource('comment', 'CommentController', array('only' => array('show', 'store', 'update', 'destroy')));

		// Todos
		Route::get('/task/{taskId}/todo', 'TodoController@indexForTask');
		Route::resource('todo', 'TodoController', array('only' => array('show', 'store', 'destroy')));

		// Time
		Route::get('/time', 'TimeController@indexForUser');
		Route::resource('time', 'TimeController', array('only' => array('show', 'store', 'update', 'destroy')));

		// Version
		Route::post('/version', 'VersionController@store');
		Route::put('/version/{id}', 'VersionController@update');
		Route::delete('/version/{id}', 'VersionController@destroy');
	});

	Route::group(['middleware' => 'is', 'role' => 'manager'], function()
	{
		// Task
		Route::post('/task', 'TaskController@store');
		Route::put('/task/{id}', 'TaskController@update');
		Route::delete('/task/{id}', 'TaskController@destroy');

		// User
		Route::post('/user', 'UserController@store');
		Route::put('/user/{id}', 'UserController@update');
		Route::delete('/user/{id}', 'UserController@destroy');

		// Project
		Route::post('/project', 'ProjectController@store');
		Route::put('/project/{id}', 'ProjectController@update');
		Route::put('/project/{id}/user', 'ProjectController@syncUserAccess');

		// Document
		Route::get('/project/{projectId}/document', 'DocumentController@indexForProject');
		Route::resource('document', 'DocumentController', array('only' => array('show', 'store', 'update', 'destroy')));
		Route::get('/project/{projectId}/document-group', 'DocumentGroupController@indexForProject');
		Route::resource('document-group', 'DocumentGroupController', array('only' => array('show', 'store', 'update', 'destroy')));

		// File
		Route::get('/document/{documentId}/file', 'FileController@indexForDocument');
		Route::post('/file', 'FileController@store');
		Route::get('/file/{id}', 'FileController@download');
		Route::delete('/file/{id}', 'FileController@destroy');
	});
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
