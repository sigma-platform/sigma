<?php namespace App\Http\Requests;

use App\Models\Comment;
use Illuminate\Http\Response;

class CommentFormRequest extends SigmaFormRequest {

	/**
	 * Rules used to validate the store request.
	 *
	 * @var array
	 */
	private $rules = [
		'content' => 'required',
		'task_id' => 'required|exists:task,id'
	];

	/**
	 * Rules used to validate the store request.
	 *
	 * @var array
	 */
	private $rulesUpdate = [
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
		if($id && !Comment::find($id))
		{
			return new Response('The selected comment doesn\'nt exist.', 404);
		}

		parent::validate();
	}

}
