<?php namespace App\Http\Controllers\Rest;

use App\Http\Requests\ProjectFormRequest;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Role;
use App\Models\Token;
use App\Models\User;

class ProjectController extends Controller {

	/**
	 * Return a JSON listing of the projects.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return response()->json(
			[
				'success' => true,
				'payload' => Project::with('projectGroup')->get()->toArray(),
			]);
	}

	/**
	 * Return a JSON listing of the projects for the user.
	 *
	 * @param string $role role filter
	 * @return \Illuminate\Http\Response
	 */
	public function indexForUser($role = null)
	{
		$user = User::find(Token::getToken($_GET['token'])->user_id);

		if(!$user)
		{
			return response()->json(
				[
					'success' => true,
					'payload' => "L'utilisateur spécifié n'éxiste pas.",
				], 404);
		}

		$projects = array();

		if(!$role)
		{
			$projects = $user->projects;
		}

		if(array_key_exists($role, Role::$projectAccessLevels))
		{
			$property = $role . 'Projects';
			$projects = $user->$property;
		}

		return response()->json(
			[
				'success' => true,
				'payload' => $projects,
			]);
	}

	/**
	 * Store a newly created project in storage.
	 *
	 * @param  ProjectFormRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(ProjectFormRequest $request)
	{
		$project = Project::create($request->all());

		return response()->json(
			[
				'success' => true,
				'message' => 'Le projet a correctement été ajouté.',
				'payload' => $project->toArray()
			]);
	}

	/**
	 * Return the specified project as JSON.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$project = Project::with('projectGroup')->find($id);

		if(!$project)
		{
			return response()->json(
				[
					'success' => false,
					'error' => 'Le projet sélectionné n\'existe pas.',
					'payload' => []
				], 404);
		}

		return response()->json(
			[
				'success' => true,
				'payload' => $project->toArray()
			]);
	}

	/**
	 * Update the specified project in storage.
	 *
	 * @param  ProjectFormRequest  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(ProjectFormRequest $request, $id)
	{
		$project = Project::find($id);

		$project->fill($request->all());
		$project->save();

		return response()->json(
			[
				'success' => true,
				'message' => 'Le projet à correctement été modifié.',
				'payload' => $project->toArray()
			]);
	}

}
