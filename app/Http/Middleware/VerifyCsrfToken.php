<?php namespace App\Http\Middleware;

use App\Models\Token;
use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if($request->ajax())
		{
			if(!isset($_GET['token']) || !Token::getToken($_GET['token']))
			{
				return response()->json(
					[
						'success' => false,
						'payload' => array(),
						'error' => 'Please authenticate yourself.'
					], 401);
			}
			return $this->addCookieToResponse($request, $next($request));
		}

		return parent::handle($request, $next);
	}

}
