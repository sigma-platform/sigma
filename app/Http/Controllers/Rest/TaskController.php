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

		if(!$user->hasAccess(null, $projectId))
		{
			return response()->json(
				[
					'success' => false,
					'payload' => [],
					'error' => "You do not have access to this project.",
				], 403);
		}

		$versionsId = Version::where('project_id', '=', $projectId)->lists('id');
		$tasks = Task::with('version', 'timeSpent')
			->leftJoin('version', 'task.version_id', '=', 'version.id')
			->select('task.*')
			->whereIn('task.version_id', $versionsId)
			->orderBy('version.date_start', 'asc')
			->get()->toArray();

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

		if(!$user->hasAccess(null, $vesion->project_id))
		{
			return response()->json(
				[
					'success' => false,
					'payload' => [],
					'error' => "You do not have access to the project related with this version.",
				], 403);
		}

		$tasks = Task::with('version', 'timeSpent')
			->leftJoin('version', 'version_id', '=', 'version.id')
			->select('task.*')
			->where('version_id', '=', $versionId)
			->orderBy('version.date_start', 'asc')
			->get()->toArray();

		return response()->json(
			[
				'success' => true,
				'payload' => $tasks
			]
		);
	}

	public function show($taskId)
	{
		$task = Task::with('timeSpent')->find($taskId);

		if(!$task)
		{
			return response()->json(
				[
					'success' => false,
					'message' => 'The selected task doesn\'t exist.',
					'payload' => []
				]
			);
		}

		return response()->json(
			[
				'success' => true,
				'payload' => $task->toArray()
			]);
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
				'message' => 'Version successfully updated.',
				'payload' => Task::find($taskId)->toArray()
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

	public function destroy($taskId) {
		$task = Task::find($taskId);

		if(!$task)
		{
			return response()->json(
				[
					'success' => false,
					'message' => 'The selected task doesn\'t exist.',
					'payload' => []
				]
			);
		}

		Task::destroy($taskId);

		return response()->json(
			[
				'success' => true,
				'message' => 'The task has been successfully deleted.',
				'payload' => []
			]);
	}
}