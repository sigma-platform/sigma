<?php namespace App\Http\Requests;

use App\Models\Project;
use App\Models\ProjectGroup;
use \Auth;
use Illuminate\Http\Response;

class ProjectGroupFormRequest extends Request {

	/**
	 * Rules used to validate the store request.
	 *
	 * @var array
	 */
	private $rules = [
		'label' => 'required|max:255',
		'image' => 'image'
	];

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return $this->rules;
	}

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		if(!Auth::check())
		{
			return false;
		}

		$user = Auth::user();

		return $user->is('admin');
	}

	/**
	 * Validate the request
	 *
	 * @return void|Response
	 */
	public function validate()
	{
		$id = $this->route()->getParameter('id');
		if($id && !ProjectGroup::find($id))
		{
			return new Response('Le groupe sélectionné n\'existe pas.', 404);
		}

		parent::validate();
	}

}
