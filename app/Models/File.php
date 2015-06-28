<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model {

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'file';

	/**
	 * List of assignable fields
	 *
	 * @var array
	 */
	protected $fillable = ['file', 'document_id'];
}