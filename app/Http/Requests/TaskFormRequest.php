<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use App\Models\Task;
use \Auth;

class TaskFormRequest extends FormRequest {

	/**
	 * Rules used to validate the store request.
	 *
	 * @var array
	 */
	private $rules = [
		'label' => 'required|max:60',
		'status' => 'required|in:Etude,Validation,Réalisation,Recette,Acceptée',
		'date_start' => 'required|date',
		'date_end' => 'required|date',
		'estimated_time' => 'required|numeric',
		'progress' => 'required|integer',
		'user_id' => 'required|exists:user,id',
		'version_id' => 'required|exists:version,id'
	];

	/**
	 * Rules used to validate the update request.
	 *
	 * @var array
	 */
	private $rulesUpdate = [
		'label' => 'max:60',
		'status' => 'in:Etude,Validation,Réalisation,Recette,Acceptée',
		'date_start' => 'date',
		'date_end' => 'date',
		'estimated_time' => 'numeric',
		'progress' => 'integer',
		'user_id' => 'exists:user,id',
		'version_id' => 'exists:version,id'
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
				new Response('La tâche sélectionnée n\'existe pas.', 404) :
				response()->json(
					[
						'success' => false,
						'error' => 'La tâche sélectionnée n\'existe pas.',
						'payload' => []
					], 404);
		}

		parent::validate();
	}
}
