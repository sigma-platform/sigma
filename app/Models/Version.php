<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Version extends Model {

	use SoftDeletes;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'version';

	/**
	 * List of assignable fields
	 *
	 * @var array
	 */
	protected $fillable = ['label', 'description', 'date_start', 'date_end', 'project_id'];

	/**
	 * List of fields that are excluded from JSON returns
	 *
	 * @var array
	 */
	protected $hidden = ['deleted_at'];

	/**
	 * Project relationship
	 *
	 * @return Project
	 */
	public function project()
	{
		return $this->belongsTo('App\Models\Project');
	}

	/**
	 * Task relationship
	 *
	 * @return Task
	 */
	public function tasks()
	{
		return $this->hasMany('App\Models\Task');
	}

}