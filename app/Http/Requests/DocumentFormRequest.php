<?php namespace App\Http\Requests;

use App\Models\Document;
use Illuminate\Http\Response;

class DocumentFormRequest extends SigmaFormRequest {

	/**
	 * Rules used to validate the store request.
	 *
	 * @var array
	 */
	private $rules = [
		'label' => 'required|max:60',
		'document_group_id' => 'required|exists:document_group,id'
	];

	/**
	 * Rules used to validate the store request.
	 *
	 * @var array
	 */
	private $rulesUpdate = [
		'label' => 'max:60',
		'document_group_id' => 'exists:document_group,id'
	];

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		if(!$this->route()->getParameter('document'))
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
		$id = $this->route()->getParameter('document');
		if($id && !Document::find($id))
		{
			return new Response('The selected document doesn\'t exist.', 404);
		}

		parent::validate();
	}

}
