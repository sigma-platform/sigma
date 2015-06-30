<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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

	/**
	 * List of assignable fields
	 *
	 * @param UploadedFile $file
	 * @param Document $document
	 * @return String
	 */
	public static function saveUploadedFile($file, $document)
	{
		$extension = $file->getClientOriginalExtension();
		$directory = $document->getDocumentDirectory();

		if(!file_exists($directory))
		{
			mkdir($directory);
		}

		$filename = $file->getClientOriginalName() . '-' . mktime() . '.' . $extension;
		$fullname = $directory . $filename;
		$file->move($directory, $fullname);

		return $filename;
	}
}