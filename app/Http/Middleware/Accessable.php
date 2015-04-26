<?php namespace App\Http\Middleware;

use App\Models\Role;
use App\Models\Token;
use App\Models\User;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Response;
use \App\Http\Requests\Request;

class Accessable {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	public function handle(Request $request, Closure $next)
	{
		$user = $this->auth->user() || User::find(Token::getToken($_GET['token']));
		$route = $request->route();

		if($user && $route)
		{
			$actions = $route->getAction();

			if(array_key_exists('role', $actions))
			{
				$role = $actions['role'];

				$projectId = null;
				if(array_key_exists($role, Role::$projectAccessLevels))
				{
					$projectId = $request->route()->getParameter('projectId');
				}

				if(!$user->is($role) || ($projectId && !$user->hasAccess($role, $projectId)))
				{
					return ($request->segment(1) != 'api') ?
						new Response('Permissions insuffisantes', 403) :
						response()->json(
							[
								'success' => false,
								'error' => 'Permissions insuffisantes',
								'payload' => []
							], 403);
				}
			}
		}

		return $next($request);
	}
}