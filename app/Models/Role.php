<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {

	/**
	 * Name of the table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'role';

	/**
	 * Globals access levels.
	 *
	 * @var array
	 */
	public static $appAccessLevels = [
		'user' => 1,
		'admin' => 2
	];

	/**
	 * Project access levels.
	 *
	 * @var array
	 */
	public static $projectAccessLevels = [
		'client' => 1,
		'dev' => 2,
		'manager' => 3
	];
}