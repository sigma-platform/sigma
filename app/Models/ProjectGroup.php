<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectGroup extends Model {

	use SoftDeletes;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'project_group';

	/**
	 * List of assignable fields
	 *
	 * @var array
	 */
	protected $fillable = ['label', 'image'];

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * Link an image to the the group
	 *
	 * @param  UploadedFile  $file
	 * @return ProjectGroup
	 */
	public function storeImageForGroup($file)
	{
		$extension = $file->getClientOriginalExtension();
		$directory = storage_path() . '/project_group/';
		$filename = $this->label . '-' . $this->id . '.' . $extension;
		$fullname = $directory . $filename;
		$file->move($directory, $fullname);

		$this->image = $filename;
		$saved = $this->save();

		return $saved;
	}
}