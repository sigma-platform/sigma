<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model {

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'todo';

	/**
	 * List of assignable fields
	 *
	 * @var array
	 */
	protected $fillable = ['label', 'done', 'task_id'];
}