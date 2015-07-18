<?php namespace App\Http\Controllers\Site;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormRequest;
use App\Models\Role;
use App\Models\User;

class UserController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('user.index')->with('users', User::with('role')->where('status', '=', 1)->get());
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$roles = Role::where('type', '=', 'user')->get();

		return view('user.form')->with('roles', $roles);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  UserFormRequest  $request
	 * @return Response
	 */
	public function store(UserFormRequest $request)
	{
		User::create($request->all());

		return redirect('/user')
			->with('message', 'L\'utilisateur a été correctement ajouté.');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$roles = Role::where('type', '=', 'user')->get();

		return view('user.form')->with('roles', $roles)->with('user', User::find($id));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  UserFormRequest  $request
	 * @param  int  $id
	 * @return Response
	 */
	public function update(UserFormRequest $request, $id)
	{
		$user = User::find($id);

		$user->fill($request->all());
		$user->save();

		return redirect('/user')
			->with('message', 'L\'utilisateur a été correctement modifié.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$user = User::find($id);

		User::destroy($user->id);

		return redirect('/user')
			->with('message', 'L\'utilisateur a bien été supprimé.');
	}
}
