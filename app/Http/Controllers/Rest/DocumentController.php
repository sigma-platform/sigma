<?php namespace App\Http\Controllers\Rest;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\DocumentFormRequest;
use App\Models\Document;
use App\Models\Role;
use App\Models\Token;
use App\Models\User;

class DocumentController extends Controller {

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
				'payload' => Document::with('documentGroup')
					->orderBy('document_group_id')
					->get()->toArray(),
			]
		);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  DocumentFormRequest  $request
	 * @return Response
	 */
	public function store(DocumentFormRequest $request)
	{
		$document = Document::create($request->all());

		return response()->json(
			[
				'success' => true,
				'payload' => $document->toArray(),
				'message' => 'Document successfully created.'
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
		$document = Document::find($id);

		if(!$document)
		{
			return response()->json(
				[
					'success' => false,
					'payload' => [],
					'error' => 'The selected document doesn\'t exist.'
				]
			);
		}

		return response()->json(
			[
				'success' => true,
				'payload' => $document->toArray(),
			]
		);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  DocumentFormRequest  $request
	 * @param  int  $id
	 * @return Response
	 */
	public function update(DocumentFormRequest $request, $id)
	{
		Document::find($id)->update($request->all());

		return response()->json(
			[
				'success' => true,
				'payload' => Document::find($id)->toArray(),
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
		$document = Document::find($id);

		if(!$document)
		{
			return response()->json(
				[
					'success' => false,
					'payload' => [],
					'error' => 'The selected document doesn\'t exist.'
				]
			);
		}

		Document::destroy($id);

		return response()->json(
			[
				'success' => true,
				'payload' => [],
				'message' => 'Document successfully deleted.'
			]
		);
	}
}
