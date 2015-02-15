<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectGroup extends Model {

	/**
	 * Le nom de la table utilisée par le model.
	 *
	 * @var string
	 */
	protected $table = 'project_group';

	/**
	 * Liste des champs assignable
	 *
	 * @var array
	 */
	protected $fillable = ['label', 'image'];
}