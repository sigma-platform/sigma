@extends('user.sidebar')
@section('subject')
	<div class="row">
		<div class="col-md-12">
			@if(Session::has('message'))
				<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					{{ Session::get('message') }}
				</div>
			@endif
			<div class="table-responsive">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>Name</th>
							<th>E-Mail</th>
							<th>Role</th>
							<th>Since</th>
							<th>Edit</th>
							<th>Delete</th>
						</tr>
					</thead>
					<tbody>
					@foreach($users as $user)
						<tr>
							<td>{{ $user->firstname }} {{ $user->lastname }}</td>
							<td>{{ $user->email }}</td>
							<td>{{ $user->role->label }}</td>
							<td>{{ date('d/m/Y', strtotime($user->created_at)) }}</td>
							<td>
								<a href="/user/edit/{{ $user->id }}">
									<span class="glyphicon glyphicon-pencil"></span>
								</a>
							</td>
							<td>
								<a href="/user/destroy/{{ $user->id }}">
									<span class="glyphicon glyphicon-remove"></span>
								</a>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection