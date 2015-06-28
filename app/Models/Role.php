<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'role';

	const APP_USER_ROLE = 'user';
	const APP_ADMIN_ROLE = 'admin';
	const PROJECT_CLIENT_ROLE = 'client';
	const PROJECT_DEV_ROLE = 'dev';
	const PROJECT_MANAGER_ROLE = 'manager';

	/**
	 * Globals access levels.
	 *
	 * @var array
	 */
	public static $appAccessLevels = [
		self::APP_USER_ROLE => 1,
		self::APP_ADMIN_ROLE => 2
	];

	/**
	 * Project access levels.
	 *
	 * @var array
	 */
	public static $projectAccessLevels = [
		self::PROJECT_CLIENT_ROLE => 1,
		self::PROJECT_DEV_ROLE => 2,
		self::PROJECT_MANAGER_ROLE => 3
	];
}