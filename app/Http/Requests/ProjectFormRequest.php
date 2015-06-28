<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use App\Models\Project;
use \Auth;

class ProjectFormRequest extends SigmaFormRequest {

	/**
	 * Rules used to validate the store request.
	 *
	 * @var array
	 */
	private $rules = [
		'name' => 'required|max:255',
		'description' => 'required',
		'slug' => 'required|alpha_dash|max:255',
		'status' => 'required|boolean',
		'project_group_id' => 'exists:project_group,id'
	];

	/**
	 * Rules used to validate the update request.
	 *
	 * @var array
	 */
	private $rulesUpdate = [
		'name' => 'max:255',
		'slug' => 'alpha_dash|max:255',
		'status' => 'boolean',
		'project_group_id' => 'exists:project_group,id'
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
		if($this->ajax())
		{
			return true;
		}

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
		// Check if update or store
		if(!$this->route()->getParameter('id'))
		{
			// Store
			// Before validate
			$input = $this->all();

			$input['status'] = ($this->segment(1) == 'api') ? 0 : 1;

			$this->replace($input);

			parent::validate();
		}
		else
		{
			// Update
			if(!Project::find($this->route()->getParameter('id')))
			{
				return ($this->segment(1) != 'api') ?
					new Response('Le projet sélectionné n\'existe pas.', 404) :
					response()->json(
						[
							'success' => false,
							'error' => 'Le projet sélectionné n\'existe pas.',
							'payload' => []
						], 404);
			}

			parent::validate();
		}
	}
}
