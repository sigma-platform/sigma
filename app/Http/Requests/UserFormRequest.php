<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use App\Models\User;
use \Auth;

class UserFormRequest extends FormRequest
{
	/**
	 * Liste des règles de validations pour la création.
	 *
	 * @var array
	 */
	private $rules = [
		'firstname' => 'required|max:255',
		'lastname' => 'required|max:255',
		'email' => 'required|email|unique:user',
		'password' => 'required|max:60',
		'role_id' => 'required|exists:role,id'
	];

	/**
	 * Liste des règles de validations pour la mise à jour.
	 *
	 * @var array
	 */
	private $rulesUpdate = [
		'firstname' => 'max:255',
		'lastname' => 'max:255',
		'email' => 'email',
		'password' => 'max:60',
		'role_id' => 'exists:role,id'
	];

	/**
	 * Retourne les règles de validations à utilisées.
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
	 * Determine si l'utilisateur est autorisé à effectuer la requête
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

	public function forbiddenResponse()
	{
		return new Response('Permissions insuffisantes', 403);
	}

	/**
	 * Valide la requête
	 *
	 * @return void|Response
	 */
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