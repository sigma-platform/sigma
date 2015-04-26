<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model {

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
}