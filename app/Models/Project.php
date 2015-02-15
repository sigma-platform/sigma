<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model {

	/**
	 * Le nom de la table utilisée par le model.
	 *
	 * @var string
	 */
	protected $table = 'project';

	/**
	 * Liste des champs assignable
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'description', 'slug', 'status', 'project_group_id'];

	/**
	 * Permet d'accéder à l'objet ProjectGroup dans le projet
	 *
	 * @return ProjectGroup
	 */
	public function projectGroup()
	{
		return $this->belongsTo('App\Models\ProjectGroup');
	}
}