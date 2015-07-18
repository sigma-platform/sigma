@extends('user.sidebar')
@section('subject')
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">{{ (isset($user)) ? "Edition d'un utilisateur" : "Ajout d'un utilisateur" }}</h3>
				</div>
				<div class="panel-body">
					@foreach($errors->all() as $error)
						<p class="alert alert-danger">{{ $error }}</p>
					@endforeach
					<form action="{{ (isset($user)) ? "/user/update/$user->id" : "/user/store" }}" method="post">
						<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
						<div class="form-group">
							<label class="help-block" for="email">E-Mail</label>
							<input id="email" name="email" class="form-control" type="text" value="{{ (isset($user)) ? $user->email : "" }}"/>
						</div>
						<div class="form-group">
							<label class="help-block" for="firstname">Firstname</label>
							<input id="firstname" name="firstname" class="form-control" type="text" value="{{ (isset($user)) ? $user->firstname : "" }}"/>
						</div>
						<div class="form-group">
							<label class="help-block" for="lastname">Lastname</label>
							<input id="lastname" name="lastname" class="form-control" type="text" value="{{ (isset($user)) ? $user->lastname : "" }}"/>
						</div>
						<div class="form-group">
							<label class="help-block" for="role">Role</label>
							<select class="form-control" name="role_id" id="role">
								@foreach($roles as $role)
									<option value="{{ $role->id }}" {{ (isset($user) && $user->role_id == $role->id) ? "selected" : "" }}>{{ $role->label }}</option>
								@endforeach
							</select>
						</div>
						<button type="submit" class="btn btn-default btn-group-justified">{{ (isset($user)) ? "Mettre à jour" : "Créer" }}</button>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection