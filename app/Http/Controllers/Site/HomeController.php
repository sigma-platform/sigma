<?php namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;

class HomeController extends Controller {

	/**
	 * Create a new controller instance.
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('home')
			->with('users', User::with('role')->where('status', '=', 0)->get())
			->with('projects', Project::with('projectGroup')->where('status', '=', 0)->get());
	}

	public function acceptUser($id)
	{
		User::find($id)->update(array('status' => 1));

		return redirect('/')->with('message', "User successfully accepted.");
	}

	public function refuseUser($id)
	{
		User::destroy($id);

		return redirect('/')->with('message', "User successfully refused.");
	}

	public function acceptProject($id)
	{
		Project::find($id)->update(array('status' => 1));

		return redirect('/')->with('message', "Project successfully accepted.");
	}

	public function refuseProject($id)
	{
		Project::destroy($id);

		return redirect('/')->with('message', "Project successfully refused.");
	}
}
