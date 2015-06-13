<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use App\Models\Task;
use \Auth;

class VersionFormRequest extends FormRequest {

	/**
	 * Rules used to validate the store request.
	 *
	 * @var array
	 */
	private $rules = [
		'label' => 'required|max:60',
		'date_start' => 'required|date',
		'date_end' => 'required|date',
		'project_id' => 'required|exists:project,id'
	];

	/**
	 * Rules used to validate the update request.
	 *
	 * @var array
	 */
	private $rulesUpdate = [
		'label' => 'max:60',
		'date_start' => 'date',
		'date_end' => 'date',
		'project_id' => 'exists:project,id'
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
		if($this->route()->getParameter('id') && !Task::find($this->route()->getParameter('id')))
		{
			return ($this->segment(1) != 'api') ?
				new Response('The selected version doesn\'t exist.', 404) :
				response()->json(
					[
						'success' => false,
						'error' => 'The selected version doesn\'t exist.',
						'payload' => []
					], 404);
		}

		parent::validate();
	}
}
