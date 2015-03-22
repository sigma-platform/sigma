<?php namespace App\Http\Controllers\Site;

use App\Http\Requests\ProjectGroupFormRequest;
use App\Http\Controllers\Controller;
use App\Models\ProjectGroup;
use Illuminate\Http\Response;

class ProjectGroupController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  ProjectGroupFormRequest  $request
	 * @return Response
	 */
	public function store(ProjectGroupFormRequest $request)
	{
		$projectGroup = ProjectGroup::create($request->all());

		if($request->hasFile("image"))
		{
			$projectGroup->storeImageForGroup($request->file("image"));
		}

		return redirect()->back()->with('newGroupId', $projectGroup->id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
