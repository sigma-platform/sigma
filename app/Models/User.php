<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'user';

	/**
	 * List of assignable fields
	 *
	 * @var array
	 */
	protected $fillable = ['firstname', 'lastname', 'email', 'password', 'status', 'role_id'];

	/**
	 * List of fields that are excluded from JSON returns
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	/**
	 * Role relationship
	 *
	 * @return Role
	 */
	public function role()
	{
		return $this->belongsTo('App\Models\Role');
	}

	/**
	 * Project relationship
	 *
	 * @return array
	 */
	public function projects()
	{
		return $this->belongsToMany('App\Models\Project', 'user_project_role');
	}

	/**
	 * Project relationship
	 *
	 * @return array
	 */
	public function managerProjects()
	{
		return $this->belongsToMany('App\Models\Project', 'user_project_role')->wherePivot('role_id', '=', 3);
	}

	/**
	 * Project relationship
	 *
	 * @return array
	 */
	public function devProjects()
	{
		return $this->belongsToMany('App\Models\Project', 'user_project_role')->wherePivot('role_id', '=', 4);
	}

	/**
	 * Project relationship
	 *
	 * @return array
	 */
	public function clientProjects()
	{
		return $this->belongsToMany('App\Models\Project', 'user_project_role')->wherePivot('role_id', '=', 5);
	}

	/**
	 * Time relationship
	 *
	 * @return array
	 */
	public function times()
	{
		return $this->belongsToMany('App\Models\Time', 'time_spent');
	}

	/**
	 * Check if the user has the designated role
	 *
	 * @param string $role
	 * @return boolean
	 */
	public function is($role)
	{
		if(array_key_exists($role, Role::$appAccessLevels))
		{
			return $this->role->access_level >= Role::$appAccessLevels[$role];
		}

		return true;
	}

	/**
	 * Check if the user has the designated role for the selected project
	 *
	 * @param string $role
	 * @param int $projectId
	 * @return boolean
	 */
	public function hasAccess($role = null, $projectId)
	{
		if($role)
		{
			$property = $role . 'Projects';
		}
		else
		{
			$property = 'projects';
		}

		$listProjectId = array();
		foreach($this->$property as $project)
		{
			$listProjectId[] = $project->id;
		}

		return in_array($projectId, $listProjectId);
	}

	/**
	 * Create a new token
	 *
	 * @return Token
	 */
	public function createToken()
	{
		return Token::create(['user_id' => $this->id]);
	}

	/**
	 * Get a user by its email
	 *
	 * @param string $email
	 * @return User
	 */
	public static function getUserWithEmail($email)
	{
		return User::where('email', '=', $email)->first();
	}

	/**
	 * Generate a password
	 *
	 * @return string
	 */
	public static function generatePassword()
	{
		return substr(
			str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!#$%&;"),
			0,
			8
		);
	}
}
