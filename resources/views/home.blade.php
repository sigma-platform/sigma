@extends('app')

@section('content')
	<div class="row" style="padding-top: 70px; padding-left: 10px; padding-right: 10px">
		@if(Session::has('message'))
			<div class="col-md-12">
				<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					{{ Session::get('message') }}
				</div>
			</div>
		@endif
		<div class="col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">User requests</h3>
				</div>
				<div class="panel-body">
					@if(count($users) <= 0)
						<div class="well well-sm">No user requests.</div>
					@endif
					@if(count($users) > 0)
					<table class="table table-responsive">
						<thead>
							<tr>
								<th>E-Mail</th>
								<th>Name</th>
								<th>Role</th>
								<th>Accept</th>
								<th>Refuse</th>
							</tr>
						</thead>
						<tbody>
							@foreach($users as $user)
								<tr>
									<td>{{ $user->email }}</td>
									<td>{{ $user->firstname }} {{ $user->lastname }}</td>
									<td>{{ $user->role->label }}</td>
									<td>
										<a href="/accept-user/{{ $user->id }}"><span class="glyphicon glyphicon-check"></span></a>
									</td>
									<td>
										<a href="/refuse-user/{{ $user->id }}"><span class="glyphicon glyphicon-remove"></span></a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
					@endif
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Project requests</h3>
				</div>
				<div class="panel-body">
					@if(count($projects) <= 0)
						<div class="well well-sm">No project requests.</div>
					@endif
					@if(count($projects) > 0)
					<table class="table table-responsive">
						<thead>
							<tr>
								<th>Name</th>
								<th>Group</th>
								<th>View</th>
								<th>Accept</th>
								<th>Refuse</th>
								<th width="0"></th>
							</tr>
						</thead>
						<tbody>
							@foreach($projects as $project)
								<tr>
									<td>{{ $project->name }}</td>
									<td>{{ $project->projectGroup->label }}</td>
									<td>
										<a href="#" data-target="#projectModal" data-toggle="modal"><span class="glyphicon glyphicon-eye-open"></span></a>
									</td>
									<td>
										<a href="/accept-project/{{ $project->id }}"><span class="glyphicon glyphicon-check"></span></a>
									</td>
									<td>
										<a href="/refuse-project/{{ $project->id }}"><span class="glyphicon glyphicon-remove"></span></a>
									</td>
									<td width="0">
										<div class="modal fade" id="projectModal" tabindex="-1" role="dialog" aria-labelledby="project" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
														<h4 class="modal-title" id="myModalLabel">Project</h4>
													</div>
													<div class="modal-body">
														<label for="">Name</label>
														<div class="well well-sm">{{ $project->name }}</div>
														<label for="">Description</label>
														<div class="well well-sm">{{ $project->description }}</div>
														<label for="">Group</label>
														<div class="well well-sm">{{ $project->projectGroup->label }}</div>
														<label for="">Created the</label>
														<div class="well well-sm">{{ date('d/m/Y', strtotime($project->created_at)) }}</div>
													</div>
												</div>
											</div>
										</div>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
					@endif
				</div>
			</div>
		</div>
	</div>
@endsection
