<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Install extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('role', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('label', 60);
			$table->tinyInteger('access_level');
			$table->enum('type', array('user','project'));
		});

		Schema::create('user', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('firstname', 45);
			$table->string('lastname', 45);
			$table->string('email', 60)->unique();
			$table->string('password', 60);
			$table->boolean('status');
			$table->string('avatar', 60)->nullable();
			$table->rememberToken();
			$table->integer('role_id', false, true);
			$table->timestamps();
			$table->softDeletes();

			$table->foreign('role_id')->references('id')->on('role');
		});

		Schema::create('token', function(Blueprint $table)
		{
			$table->string('token', 36);
			$table->primary('token');
			$table->integer('user_id', false, true);
			$table->timestamps();

			$table->foreign('user_id')->references('id')->on('user');
		});

		Schema::create('password_reset', function(Blueprint $table)
		{
			$table->string('email', 60)->index();
			$table->string('token', 100)->index();
			$table->timestamp('created_at');
		});

		Schema::create('action', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('label', 60);
			$table->integer('user_id', false, true);
			$table->timestamps();

			$table->foreign('user_id')->references('id')->on('user');
		});

		Schema::create('project_group', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('label', 60);
			$table->string('image', 60)->nullable();
		});

		Schema::create('project', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 60);
			$table->text('description')->nullable();
			$table->string('slug', 60)->unique();
			$table->boolean('status');
			$table->integer('project_group_id', false, true);
			$table->timestamps();
			$table->softDeletes();

			$table->foreign('project_group_id')->references('id')->on('project_group');
		});

		Schema::create('user_project_role', function(Blueprint $table)
		{
			$table->integer('user_id', false, true);
			$table->integer('project_id', false, true);
			$table->integer('role_id', false, true);

			$table->foreign('user_id')->references('id')->on('user');
			$table->foreign('project_id')->references('id')->on('project');
			$table->foreign('role_id')->references('id')->on('role');

			$table->primary(['user_id', 'project_id', 'role_id']);
		});

		Schema::create('document_group', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('label', 60);
			$table->integer('project_id', false, true);
			$table->softDeletes();

			$table->foreign('project_id')->references('id')->on('project');
		});

		Schema::create('document', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('label', 60);
			$table->text('description')->nullable();
			$table->integer('document_group_id', false, true);
			$table->timestamps();
			$table->softDeletes();

			$table->foreign('document_group_id')->references('id')->on('document_group');
		});

		Schema::create('file', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('file', 60);
			$table->integer('document_id', false, true);
			$table->timestamps();

			$table->foreign('document_id')->references('id')->on('document');
		});

		Schema::create('version', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('label', 60);
			$table->text('description')->nullable();
			$table->date('date_start');
			$table->date('date_end');
			$table->integer('project_id', false, true);
			$table->timestamps();
			$table->softDeletes();

			$table->foreign('project_id')->references('id')->on('project');
		});

		Schema::create('task', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('label', 60);
			$table->text('description')->nullable();
			$table->enum('status', array('Etude','Validation','Réalisation','Recette','Acceptée'));
			$table->date('date_start');
			$table->date('date_end');
			$table->decimal('estimated_time', 5, 1);
			$table->integer('progress');
			$table->integer('user_id', false, true);
			$table->integer('version_id', false, true);
			$table->timestamps();
			$table->softDeletes();

			$table->foreign('user_id')->references('id')->on('user');
			$table->foreign('version_id')->references('id')->on('version');
		});

		Schema::create('time', function(Blueprint $table)
		{
			$table->increments('id');
			$table->decimal('time', 4, 1);
			$table->date('date');
			$table->timestamps();
		});

		Schema::create('time_spent', function(Blueprint $table)
		{
			$table->integer('task_id', false, true);
			$table->integer('user_id', false, true);
			$table->integer('time_id', false, true);

			$table->foreign('task_id')->references('id')->on('task');
			$table->foreign('user_id')->references('id')->on('user');
			$table->foreign('time_id')->references('id')->on('time');

			$table->primary(['task_id', 'user_id', 'time_id']);
		});

		Schema::create('todo', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('label', 60);
			$table->boolean('done');
			$table->integer('task_id', false, true);

			$table->foreign('task_id')->references('id')->on('task');
		});

		Schema::create('comment', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('content');
			$table->timestamps();
			$table->integer('task_id', false, true);
			$table->integer('user_id', false, true);

			$table->foreign('task_id')->references('id')->on('task');
			$table->foreign('user_id')->references('id')->on('user');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('comment');
		Schema::dropIfExists('todo');
		Schema::dropIfExists('time_spent');
		Schema::dropIfExists('time');
		Schema::dropIfExists('task');
		Schema::dropIfExists('version');
		Schema::dropIfExists('file');
		Schema::dropIfExists('document');
		Schema::dropIfExists('document_group');
		Schema::dropIfExists('user_project_role');
		Schema::dropIfExists('project');
		Schema::dropIfExists('project_group');
		Schema::dropIfExists('action');
		Schema::dropIfExists('password_reset');
		Schema::dropIfExists('token');
		Schema::dropIfExists('user');
		Schema::dropIfExists('role');
	}

}
