<?php namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use App\Models\ProjectGroup;

class ProjectGroupController extends Controller
{

	/**
	 * Return a JSON listing of the projects group.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return response()->json(
			[
				'success' => true,
				'payload' => ProjectGroup::all()->toArray(),
			]
		);
	}
}