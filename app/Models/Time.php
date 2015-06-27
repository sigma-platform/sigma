<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Time extends Model {

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'time';

	/**
	 * List of assignable fields
	 *
	 * @var array
	 */
	protected $fillable = ['time', 'date'];

	/**
	 * User relationship
	 *
	 * @return array
	 */
	public function users()
	{
		return $this->belongsToMany('App\Models\User', 'time_spent');
	}

	/**
	 * Task relationship
	 *
	 * @return array
	 */
	public function tasks()
	{
		return $this->belongsToMany('App\Models\Task', 'time_spent');
	}
}