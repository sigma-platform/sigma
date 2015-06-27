<?php namespace App\Http\Controllers\Rest;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Todo;
use App\Models\Task;
use App\Http\Requests\TodoFormRequest;

class TodoController extends Controller {

	/**
	 * Display a listing of the resource for a task.
	 *
	 * @param  int  $taskId
	 * @return Response
	 */
	public function indexForTask($taskId)
	{
		if(Task::find($taskId))
		{
			return response()->json(
				[
					'success' => false,
					'payload' => [],
					'error' => 'The selected todo does\'nt exist.'
				]
			);
		}

		$todos = Todo::where('task_id', '=', $taskId)->get()->toArray();

		return response()->json(
			[
				'success' => true,
				'payload' => $todos,
			]
		);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  TodoFormRequest  $request
	 * @return Response
	 */
	public function store(TodoFormRequest $request)
	{
		$todo = Todo::create($request->all());

		return response()->json(
			[
				'success' => true,
				'payload' => $todo->toArray(),
			]
		);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$todo = Todo::find($id);

		if(!$todo)
		{
			return response()->json(
				[
					'success' => false,
					'message' => 'The selected todo doesn\'t exist.',
					'payload' => []
				]
			);
		}

		return response()->json(
			[
				'success' => true,
				'payload' => $todo->toArray()
			]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$todo = Todo::find($id);

		if(!$todo)
		{
			return response()->json(
				[
					'success' => false,
					'message' => 'The selected todo doesn\'t exist.',
					'payload' => []
				]
			);
		}

		Todo::destroy($id);

		return response()->json(
			[
				'success' => true,
				'message' => 'The todo has been successfully deleted.',
				'payload' => []
			]);
	}

}
