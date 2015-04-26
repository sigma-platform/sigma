<?php namespace App\Http\Middleware;

use App\Models\Role;
use App\Models\Token;
use App\Models\User;
use App\Models\Version;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

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
		$user = ($this->auth->user()) ? $this->auth->user() : User::find(Token::getToken($_GET['token'])->user_id);
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
					if($request->input('project_id'))
					{
						$projectId = $request->input('project_id');
					}
					elseif($request->input('version_id'))
					{
						$version = Version::find($request->input('version_id'));
						$projectId = ($version) ? $version->project_id : null;
					}
					elseif($request->route()->getParameter('projectId'))
					{
						$projectId = $request->route()->getParameter('projectId');
					}
				}


				if(($projectId && !$user->hasAccess($role, $projectId)) || !$user->is($role))
				{
					return ($request->segment(1) != 'api') ?
						new Response('Forbidden', 403) :
						response()->json(
							[
								'success' => false,
								'error' => 'Forbidden',
								'payload' => []
							], 403);
				}
			}
		}

		return $next($request);
	}
}