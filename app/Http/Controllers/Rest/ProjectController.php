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
					'success' => false,
					'payload' => [],
					'error' => "The specified user doesn't exist.",
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

		if($request->has('users'))
		{
			foreach($request->get('users') as $user)
			{
				$project->users()->sync([$user['user_id'] => ['role_id' => $user['role_id']]]);
			}
		}

		return response()->json(
			[
				'success' => true,
				'message' => 'Project succesfuly created.',
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
		$project = Project::with('projectGroup', 'users')->find($id);

		if(!$project)
		{
			return response()->json(
				[
					'success' => false,
					'error' => "The specified project doesn't exist.",
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

		if($request->has('users'))
		{
			foreach($request->get('users') as $user)
			{

			}
		}

		return response()->json(
			[
				'success' => true,
				'message' => 'Project successfully modified.',
				'payload' => $project->toArray()
			]);
	}

	public function syncUserAccess(ProjectFormRequest $request, $id)
	{
		$project = Project::find($id);

		if(!$project)
		{
			return response()->json(
				[
					'success' => false,
					'payload' => [],
					'error' => 'The selected project doesn\'t exist.'
				]
			);
		}

		if($request->has('users'))
		{
			$usersArray = json_decode($request->get('users'), true);

			$updated = [];
			foreach($usersArray as $user)
			{
				$updated[$user['user_id']] = (array('role_id'=>$user['role_id'],));
			}

			$project->users()->sync($updated);
		}

		return response()->json(
			[
				'success' => true,
				'payload' => $project->users,
				'message' => 'Users successfully synced to the project'
			]
		);
	}
}
