<?php namespace App\Http\Controllers\Rest;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Time;
use App\Models\Token;
use App\Models\User;
use App\Http\Requests\TimeFormRequest;

class TimeController extends Controller {

	/**
	 * Display a listing of the resource for a user.
	 *
	 * @return Response
	 */
	public function indexForUser()
	{
		$user = User::find(Token::find($_GET['token'])->user_id);

		return response()->json(
			[
				'success' => true,
				'payload' => $user->times,
			]
		);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  TimeFormRequest  $request
	 * @return Response
	 */
	public function store(TimeFormRequest $request)
	{
		$time = Time::create(
			array(
				'time' => $request->get('time'),
				'date' => $request->get('date')
			));

		$time->tasks()->attach([$request->get('task_id') => ['user_id' => $request->get('user_id')]]);

		return response()->json(
			[
				'success' => true,
				'payload' => $time->toArray(),
				'message' => 'Time spent successfully added.'
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
		$time = Time::find($id);

		if(!$time)
		{
			return response()->json(
				[
					'success' => false,
					'message' => 'The selected time spent doesn\'t exist.',
					'payload' => []
				]
			);
		}

		return response()->json(
			[
				'success' => true,
				'payload' => $time->toArray()
			]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  TimeFormRequest  $request
	 * @param  int  $id
	 * @return Response
	 */
	public function update(TimeFormRequest $request, $id)
	{
		Time::find($id)->update($request->all());

		return response()->json(
			[
				'success' => true,
				'payload' => Time::find($id)->toArray(),
				'message' => 'Time spent on the task successfully updated.'
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
		$time = Time::find($id);

		if(!$time)
		{
			return response()->json(
				[
					'success' => false,
					'message' => 'The selected time spent doesn\'t exist.',
					'payload' => []
				]
			);
		}

		$time->tasks()->detach();
		Time::destroy($id);

		return response()->json(
			[
				'success' => true,
				'message' => 'The time spent has been successfully deleted.',
				'payload' => []
			]);
	}

}
