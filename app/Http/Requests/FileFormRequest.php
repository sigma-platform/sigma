<?php namespace App\Http\Requests;

use App\Models\File;
use Illuminate\Http\Response;

class FileFormRequest extends SigmaFormRequest {

	/**
	 * Rules used to validate the store request.
	 *
	 * @var array
	 */
	private $rules = [
		'file' => 'required|max:60',
		'document_id' => 'required|exists:document,id'
	];

	/**
	 * Rules used to validate the store request.
	 *
	 * @var array
	 */
	private $rulesUpdate = [
		'file' => 'max:60',
		'document_id' => 'exists:document,id'
	];

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		if(!$this->route()->getParameter('id'))
		{
			return $this->rules;
		}
		else
		{
			return $this->rulesUpdate;
		}
	}

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Validate the request
	 *
	 * @return void|Response
	 */
	public function validate()
	{
		$id = $this->route()->getParameter('id');
		if($id && !File::find($id))
		{
			return new Response('The selected document doesn\'t exist.', 404);
		}

		parent::validate();
	}

}
