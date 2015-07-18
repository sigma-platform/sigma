<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'comment';

	/**
	 * List of assignable fields
	 *
	 * @var array
	 */
	protected $fillable = ['content', 'task_id', 'user_id'];

	/**
	 * User relationship
	 *
	 * @return User
	 */
	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}
}