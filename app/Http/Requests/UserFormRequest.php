<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use App\Models\User;
use \Auth;

class UserFormRequest extends FormRequest
{
	private $rules = [
		'firstname' => 'required|max:255',
		'lastname' => 'required|max:255',
		'email' => 'required|email|unique:user',
		'password' => 'required|max:60',
		'role_id' => 'required|exists:role,id'
	];

	private $rulesUpdate = [
		'firstname' => 'max:255',
		'lastname' => 'max:255',
		'email' => 'email',
		'password' => 'max:60',
		'role_id' => 'exists:role,id'
	];

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

	public function authorize()
	{
		if(!Auth::check())
		{
			return false;
		}

		$user = Auth::user();

		return $user->is('admin');
	}

	public function forbiddenResponse()
	{
		return new Response('Permissions insuffisantes', 403);
	}

	public function validate()
	{
		// Check si update ou store
		if(!$this->route()->getParameter('id'))
		{
			// Avant validation
			$input = $this->all();

			$input['password'] = User::generatePassword();

			$this->replace($input);

			parent::validate();

			// Après validation
			$input['password'] = bcrypt($input['password']);
			$this->replace($input);
		}
		else
		{
			if(!User::find($this->route()->getParameter('id')))
			{
				return new Response('L\'utilisateur sélectionné n\'existe pas.', 404);
			}

			parent::validate();
		}
	}
}