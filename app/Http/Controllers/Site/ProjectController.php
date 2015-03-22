<?php namespace App\Http\Controllers\Site;

use App\Http\Requests\ProjectFormRequest;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectGroup;
use Illuminate\Http\Response;

class ProjectController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('project.index')->with('projects', Project::with('projectGroup')->get());
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('project.form')->with('projectGroups', ProjectGroup::all());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  ProjectFormRequest  $request
	 * @return Response
	 */
	public function store(ProjectFormRequest $request)
	{
		Project::create($request->all());

		return redirect('/project')->with('message', 'Le projet a correctement été ajouté.');
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
		return view('project.form')
			->with('projectGroups', ProjectGroup::all())
			->with('project', Project::find($id));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  ProjectFormRequest  $request
	 * @param  int  $id
	 * @return Response
	 */
	public function update(ProjectFormRequest $request, $id)
	{
		$project = Project::find($id);

		$project->fill($request->all());
		$project->save();

		return redirect('/project')->with('message', 'Le projet à correctement été modifié.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$project = Project::find($id);

		Project::destroy($project->id);

		return redirect('/project')->with('message', 'Le projet a bien été supprimé.');
	}

}
