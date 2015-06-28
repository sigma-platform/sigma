<?php namespace App\Http\Requests;

use App\Models\DocumentGroup;
use Illuminate\Http\Response;

class DocumentGroupFormRequest extends SigmaFormRequest {

	/**
	 * Rules used to validate the store request.
	 *
	 * @var array
	 */
	private $rules = [
		'label' => 'required|max:60',
		'project_id' => 'required|exists:project,id'
	];

	/**
	 * Rules used to validate the store request.
	 *
	 * @var array
	 */
	private $rulesUpdate = [
		'label' => 'max:60',
		'project_id' => 'exists:project,id'
	];

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		if(!$this->route()->getParameter('document_group'))
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
		$id = $this->route()->getParameter('document_group');
		if($id && !DocumentGroup::find($id))
		{
			return new Response('The selected group of document doesn\'t exist.', 404);
		}

		parent::validate();
	}

}
