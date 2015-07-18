<?php namespace App\Http\Controllers\Rest;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Task;
use App\Http\Requests\CommentFormRequest;

class CommentController extends Controller {

	/**
	 * Display a listing of the resource for a task.
	 *
	 * @param  int  $taskId
	 * @return Response
	 */
	public function indexForTask($taskId)
	{
		if(!Task::find($taskId))
		{
			return response()->json(
				[
					'success' => false,
					'payload' => [],
					'error' => 'The selected task doesn\'t exist.'
				]
			);
		}

		$comments = Comment::with(array('user' => function($query)
		{
			$query->select('id', 'firstname', 'lastname');
		}))->where('task_id', '=', $taskId)->get()->toArray();

		return response()->json(
			[
				'success' => true,
				'payload' => $comments,
			]
		);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  CommentFormRequest  $request
	 * @return Response
	 */
	public function store(CommentFormRequest $request)
	{
		$comment = Comment::create($request->all());

		return response()->json(
			[
				'success' => true,
				'payload' => Comment::with(array('user' => function($query)
				{
					$query->select('id', 'firstname', 'lastname');
				}))->find($comment->id)->toArray(),
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
		$comment = Comment::find($id);

		if(!$comment)
		{
			return response()->json(
				[
					'success' => false,
					'message' => 'The selected comment doesn\'t exist.',
					'payload' => []
				]
			);
		}

		return response()->json(
			[
				'success' => true,
				'payload' => Comment::with(array('user' => function($query)
				{
					$query->select('id', 'firstname', 'lastname');
				}))->find($id)->toArray()
			]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  CommentFormRequest  $request
	 * @param  int  $id
	 * @return Response
	 */
	public function update(CommentFormRequest $request, $id)
	{
		Comment::find($id)->update($request->all());

		return response()->json(
			[
				'success' => true,
				'payload' => Comment::with(array('user' => function($query)
				{
					$query->select('id', 'firstname', 'lastname');
				}))->find($id)->toArray(),
				'message' => 'Comment successfully updated.'
			]
		);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$comment = Comment::find($id);

		if(!$comment)
		{
			return response()->json(
				[
					'success' => false,
					'message' => 'The selected comment doesn\'t exist.',
					'payload' => []
				]
			);
		}

		Comment::destroy($id);

		return response()->json(
			[
				'success' => true,
				'message' => 'The comment has been successfully deleted.',
				'payload' => []
			]);
	}

}
