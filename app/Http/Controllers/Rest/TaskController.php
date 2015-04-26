<?php namespace App\Http\Controllers\Rest;

use App\Http\Requests\TaskFormRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Token;
use App\Models\Task;
use App\Models\Version;

class TaskController extends Controller {

	public function indexForUserWithProject($projectId)
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

		if(!$user->hasAccess(null, $projectId))
		{
			return response()->json(
				[
					'success' => false,
					'payload' => [],
					'error' => "You do not have access to this project.",
				], 400);
		}

		$versionsId = Version::where('project_id', '=', $projectId)->lists('id');
		$tasks = Task::whereIn('version_id', $versionsId)->get()->toArray();

		return response()->json(
			[
				'success' => true,
				'payload' => $tasks
			]
		);
	}

	public function indexForUserWithVersion($versionId)
	{
		$user = User::find(Token::getToken($_GET['token'])->user_id);
		$vesion = Version::find($versionId);

		if(!$user)
		{
			return response()->json(
				[
					'success' => false,
					'payload' => [],
					'error' => "The specified user doesn't exist.",
				], 404);
		}

		if(!$user->hasAccess(null, $vesion->project_id))
		{
			return response()->json(
				[
					'success' => false,
					'payload' => [],
					'error' => "You do not have access to this project.",
				], 400);
		}

		$tasks = Task::where('version_id', '=', $versionId)->get()->toArray();

		return response()->json(
			[
				'success' => true,
				'payload' => $tasks
			]
		);
	}

	public function store(TaskFormRequest $request)
	{
		$task = Task::create($request->all());

		return response()->json(
			[
				'success' => true,
				'message' => 'Task successfully added.',
				'payload' => $task->toArray()
			]);
	}

	public function update(TaskFormRequest $request, $taskId)
	{
		Task::find($taskId)->update($request->all());

		return response()->json(
			[
				'success' => true,
				'message' => 'Task successfully updated.',
				'payload' => Task::find($taskId)
			]
		);
	}

	public function updateProgress(TaskFormRequest $request, $taskId)
	{
		$task = Task::find($taskId);

		$progress = $request->input('progress');

		if($progress)
		{
			$task->fill(array('progress' => $progress));
			$task->save();
		}

		return response()->json(
			[
				'success' => true,
				'message' => 'Progress successfully updated.',
				'payload' => $task->toArray()
			]
		);
	}
}