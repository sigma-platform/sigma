<?php namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use App\Http\Requests\VersionFormRequest;
use App\Models\Version;

class VersionController extends Controller {

	public function show($versionId) {
		$version = Version::find($versionId);

		if(!$version)
		{
			return response()->json(
				[
					'success' => false,
					'message' => 'The selected version doesn\'t exist.',
					'payload' => []
				]
			);
		}

		return response()->json(
			[
				'success' => true,
				'payload' => $version->toArray()
			]);
	}

	public function store(VersionFormRequest $request) {
		$version = Version::create($request->all());

		return response()->json(
			[
				'success' => true,
				'message' => 'Version successfully added.',
				'payload' => $version->toArray()
			]);
	}

	public function update(VersionFormRequest $request, $versionId) {
		Version::find($versionId)->update($request->all());

		return response()->json(
			[
				'success' => true,
				'message' => 'Version successfully updated.',
				'payload' => Version::find($versionId)->toArray()
			]
		);
	}

	public function destroy($versionId) {
		$version = Version::find($versionId);

		if(!$version)
		{
			return response()->json(
				[
					'success' => false,
					'message' => 'The selected version doesn\'t exist.',
					'payload' => []
				]
			);
		}

		Version::destroy($versionId);

		return response()->json(
			[
				'success' => true,
				'message' => 'The version has been successfully deleted.',
				'payload' => []
			]
			, 204);
	}
}

