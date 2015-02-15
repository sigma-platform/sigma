<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Response;

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

	public function handle($request, Closure $next)
	{
		$user = $this->auth->user();
		$route = $request->route();

		if($user && $route)
		{
			$actions = $route->getAction();

			if(array_key_exists('role', $actions))
			{
				$role = $actions['role'];

				if(!$user->is($role))
				{
					return new Response('Permissions insuffisantes', 403);
				}
			}
		}

		return $next($request);
	}
}