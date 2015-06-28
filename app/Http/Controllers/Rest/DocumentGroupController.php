<?php namespace App\Http\Controllers\Rest;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\DocumentGroup;
use App\Http\Requests\DocumentGroupFormRequest;
use App\Models\Role;
use App\Models\Token;
use App\Models\User;

class DocumentGroupController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @param  int  $projectId
	 * @return Response
	 */
	public function indexForProject($projectId)
	{
		$user = User::find(Token::getToken($_GET['token'])->user_id);

		if(!$user->hasAccess(null, $projectId)
		   && $user->role->access_level != Role::$appAccessLevels[Role::APP_ADMIN_ROLE])
		{
			return response()->json(
				[
					'success' => false,
					'payload' => [],
					'error' => "You do not have access to this project.",
				], 403);
		}

		return response()->json(
			[
				'success' => true,
				'payload' => DocumentGroup::all()->toArray(),
			]
		);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  DocumentGroupFormRequest  $request
	 * @return Response
	 */
	public function store(DocumentGroupFormRequest $request)
	{
		$documentGroup = DocumentGroup::create($request->all());

		return response()->json(
			[
				'success' => true,
				'payload' => $documentGroup->toArray(),
				'message' => 'Group of document successfully created.'
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
		$documentGroup = DocumentGroup::find($id);

		if(!$documentGroup)
		{
			return response()->json(
				[
					'success' => false,
					'payload' => [],
					'error' => 'The selected group of document doesn\'t exist.'
				]
			);
		}

		return response()->json(
			[
				'success' => true,
				'payload' => $documentGroup->toArray(),
			]
		);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  DocumentGroupFormRequest  $request
	 * @param  int  $id
	 * @return Response
	 */
	public function update(DocumentGroupFormRequest $request, $id)
	{
		DocumentGroup::find($id)->update($request->all());

		return response()->json(
			[
				'success' => true,
				'payload' => DocumentGroup::find($id)->toArray(),
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
		$documentGroup = DocumentGroup::find($id);

		if(!$documentGroup)
		{
			return response()->json(
				[
					'success' => false,
					'payload' => [],
					'error' => 'The selected group of document doesn\'t exist.'
				]
			);
		}

		DocumentGroup::destroy($id);

		return response()->json(
			[
				'success' => true,
				'payload' => [],
				'message' => 'Group of document successfully deleted.'
			]
		);
	}

}
