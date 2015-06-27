<?php namespace App\Http\Requests;

use App\Models\Time;
use Illuminate\Http\Response;

class TimeFormRequest extends SigmaFormRequest {

	/**
	 * Rules used to validate the store request.
	 *
	 * @var array
	 */
	private $rules = [
		'time' => 'numeric|required',
		'date' => 'required|date',
		'task_id' => 'required|exists:task,id',
		'user_id' => 'required|exists:user,id',
	];

	/**
	 * Rules used to validate the store request.
	 *
	 * @var array
	 */
	private $rulesUpdate = [
		'time' => 'numeric',
		'date' => 'date'
	];

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		\Log::info($this->route()->parameters());
		if(!$this->route()->getParameter('time'))
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
		$id = $this->route()->getParameter('time');
		if($id && !Time::find($id))
		{
			return new Response('The selected time doesn\'nt exist.', 404);
		}

		parent::validate();
	}

}
