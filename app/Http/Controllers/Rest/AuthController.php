<?php namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use App\Models\Token;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;

class AuthController extends Controller
{

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest', ['except' => 'logout']);
	}

	/**
	 * Login a user via a HTTP request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function login(Request $request)
	{
		$validator = $this->getValidationFactory()->make($request->all(), [
			'email' => 'required', 'password' => 'required',
		]);

		$credentials = $request->only('email', 'password');

		if (!$validator->fails() && $this->auth->validate($credentials))
		{
			$user = User::getUserWithEmail($credentials['email']);

			return response()->json(
				[
					'success' => true,
					'message' => 'Auhtentication successfull.',
					'payload' => $user->createToken()
				]);
		}

		return response()->json(
			[
				'success' => false,
				'message' => 'The credentials do not match any user.',
				'payload' => []
			], 400);
	}

	/**
	 * Log the user out of the application via a HTTP request.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function logout()
	{
		Token::destroy($_GET['token']);

		return response()->json(
			[
				'success' => true,
				'message' => 'You are now logged out.',
				'payload' => []
			], 204);
	}
}