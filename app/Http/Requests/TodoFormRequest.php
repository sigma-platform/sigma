<?php namespace App\Http\Requests;

use App\Models\Todo;
use Illuminate\Http\Response;

class TodoFormRequest extends SigmaFormRequest {

	/**
	 * Rules used to validate the store request.
	 *
	 * @var array
	 */
	private $rules = [
		'label' => 'required|max:255',
		'done' => 'boolean|required',
		'task_id' => 'required|exists:task,id'
	];

	/**
	 * Rules used to validate the store request.
	 *
	 * @var array
	 */
	private $rulesUpdate = [
		'label' => 'max:255',
		'done' => 'boolean',
		'task_id' => 'exists:task,id'
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
		if($id && !Todo::find($id))
		{
			return new Response('The selected todo doesn\'nt exist.', 404);
		}

		parent::validate();
	}

}
