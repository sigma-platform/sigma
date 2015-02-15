<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {

	/**
	 * Le nom de la table utilisée par le model.
	 *
	 * @var string
	 */
	protected $table = 'role';

	/**
	 * Liste des niveaux d'accès globaux
	 *
	 * @var array
	 */
	public static $appAccessLevels = [
		'user' => 1,
		'admin' => 2
	];

	/**
	 * Liste des niveaux d'accès pour les projets
	 *
	 * @var array
	 */
	public static $projectAccessLevels = [
		'client' => 1,
		'dev' => 2,
		'manager' => 3
	];
}