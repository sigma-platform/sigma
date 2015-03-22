<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * Name of the table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user';

	/**
	 * List of assignable fields
	 *
	 * @var array
	 */
	protected $fillable = ['firstname', 'lastname', 'email', 'password', 'role_id'];

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
		return $this->belongsTo('Role');
	}

	/**
	 * UserProjectRole relationship
	 *
	 * @return UserProjectRole
	 */
	public function userProjectsRoles()
	{
		return $this->belongsTo('UserProjectRole');
	}

	/**
	 * Check if the user has the designated role
	 *
	 * @param string $role
	 * @return boolean
	 */
	public function is($role)
	{
		return $this->role->access_level === Role::$appAccessLevels[$role];
	}

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
		return User::query()->where('email', '=', $email)->first();
	}

	/**
	 * Generate a password
	 *
	 * @return string
	 */
	public static function generatePassword()
	{
		return substr(
			str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?"),
			0,
			8
		);
	}
}
