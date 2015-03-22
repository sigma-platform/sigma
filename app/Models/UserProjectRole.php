<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProjectRole extends Model {

	/**
	 * Name of the table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user_project_role';

	/**
	 * List of assignable fields
	 *
	 * @var array
	 */
	protected $fillable = ['user_id', 'project_id', 'role_id'];

	/**
	 * ProjectGroup relationship
	 *
	 * @return ProjectGroup
	 */
	public function user()
	{
		return $this->belongsTo('User');
	}

	/**
	 * Project relationship
	 *
	 * @return Project
	 */
	public function project()
	{
		return $this->belongsTo('Project');
	}

	/**
	 * Role relationship
	 *
	 * @return Role
	 */
	public function role()
	{
		return $this->belongsTo('Role');
	}
}