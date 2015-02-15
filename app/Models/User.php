<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * Le nom de la table utilisée par le model
	 *
	 * @var string
	 */
	protected $table = 'user';

	/**
	 * Liste des champs assignable
	 *
	 * @var array
	 */
	protected $fillable = ['firstname', 'lastname', 'email', 'password', 'role_id'];

	/**
	 * Liste des champs exclus des retour JSON
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	/**
	 * Permet d'accéder à l'objet Role dans utilisateur
	 *
	 * @return Role
	 */
	public function role()
	{
		return $this->belongsTo('App\Models\Role');
	}

	/**
	 * Permet de déterminer si l'utilisateur a le role passé en paramètre
	 *
	 * @param string role
	 *
	 * @return boolean
	 */
	public function is($role)
	{
		return $this->role->access_level === Role::$appAccessLevels[$role];
	}

	public static function generatePassword()
	{
		return substr(
			str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?"),
			0,
			8
		);
	}
}
