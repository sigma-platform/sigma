<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model {

	use SoftDeletes;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'document';

	/**
	 * List of assignable fields
	 *
	 * @var array
	 */
	protected $fillable = ['label', 'description', 'document_group_id'];

	/**
	 * DocumentGroup relationship
	 *
	 * @return DocumentGroup
	 */
	public function documentGroup()
	{
		return $this->belongsTo('App\Models\DocumentGroup');
	}

	/**
	 * File relationship
	 *
	 * @return File
	 */
	public function files()
	{
		return $this->hasMany('App\Models\File');
	}

	public function getDocumentDirectory()
	{
		return storage_path() . '/app/files/' . $this->id . '-' . $this->label . '/';
	}
}