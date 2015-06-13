<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model {

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'project';

	/**
	 * List of assignable fields
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'description', 'slug', 'status', 'project_group_id'];

	/**
	 * ProjectGroup relationship
	 *
	 * @return ProjectGroup
	 */
	public function projectGroup()
	{
		return $this->belongsTo('App\Models\ProjectGroup');
	}

	/**
	 * User relationship
	 *
	 * @return array
	 */
	public function users()
	{
		return $this->belongsToMany('App\Models\User', 'user_project_role');
	}
}