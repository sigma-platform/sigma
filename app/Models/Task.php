<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model {

	use SoftDeletes;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'task';

	/**
	 * List of assignable fields
	 *
	 * @var array
	 */
	protected $fillable = ['label', 'description', 'status', 'date_start', 'date_end', 'estimated_time', 'progress', 'user_id', 'version_id'];

	/**
	 * List of fields that are excluded from JSON returns
	 *
	 * @var array
	 */
	protected $hidden = ['deleted_at'];

	/**
	 * User relationship
	 *
	 * @return User
	 */
	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}

	/**
	 * Version relationship
	 *
	 * @return Version
	 */
	public function version()
	{
		return $this->belongsTo('App\Models\Version');
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
	 * Time spent for a task
	 *
	 * @return array
	 */
	public function timeSpent()
	{
		return $this->belongsToMany('App\Models\Time', 'time_spent')
			->selectRaw('sum(time) as time')
			->groupBy('pivot_task_id');
	}

	/**
	 * Accessor for the time spent on the task
	 *
	 * @return int
	 */
	public function getTimeSpentAttribute()
	{
		if (!array_key_exists('timeSpent', $this->relations))
		{
			$this->load('timeSpent');
		}

		$related = $this->getRelation('timeSpent')->first();

		return ($related) ? $related->time : 0;
	}
}