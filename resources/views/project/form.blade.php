@extends('project.sidebar')
@section('subject')
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">{{ (isset($project)) ? "Mise à jour d'un projet" : "Création d'un projet" }}</h3>
				</div>
				<div class="panel-body">
					@foreach($errors->all() as $error)
						<p class="alert alert-danger">{{ $error }}</p>
					@endforeach
					<form action="{{ (isset($project)) ? "/project/update/$project->id" : "/project/store" }}" method="post">
						<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
						<div class="form-group">
							<label class="help-block" for="name">Nom</label>
							<input id="name" name="name" class="form-control" type="text" value="{{ (isset($project)) ? $project->name : "" }}"/>
						</div>
						<div class="form-group">
							<label class="help-block" for="description">Description</label>
							<textarea id="description" name="description" class="form-control" cols="30" rows="5">@if(isset($project)){{ $project->description }}@endif</textarea>
						</div>
						<div class="form-group">
							<label class="help-block" for="slug">Identifiant</label>
							<input id="slug" name="slug" class="form-control" type="text" value="{{ (isset($project)) ? $project->slug : "" }}"/>
							<p class="help-block">Attention ce champs doit contenir uniquement des caractères alphanumérique ainsi que des tirets.</p>
						</div>
						<div class="form-group">
							<label class="help-block" for="project_group">Groupe</label>
							<div class="input-group">
								<select class="form-control" name="project_group_id" id="project_group">
									@foreach($projectGroups as $projectGroup)
										<option value="{{ $projectGroup->id }}"
											{{ (isset($project) && $project->project_group_id == $projectGroup->id) ? "selected" : "" }}
											{{ (Session::has('newGroupId') && Session::get('newGroupId') == $projectGroup->id) ? "selected" : "" }}>
											{{ $projectGroup->label }}
										</option>
									@endforeach
								</select>
								<div class="input-group-btn">
									<button class="btn btn-default" type="button" data-toggle="modal" data-target="#projectGroupModal">
										<span class="glyphicon glyphicon-plus"></span>
									</button>
								</div>
							</div>
						</div>
						<button type="submit" class="btn btn-default btn-group-justified">{{ (isset($project)) ? "Mettre à jour" : "Créer" }}</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="projectGroupModal" tabindex="-1" role="dialog" aria-labelledby="projectGroup" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="/project-group/store" method="post" enctype="multipart/form-data">
					<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Création d'un groupe</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label class="help-block" for="label">Label</label>
							<input id="label" name="label" class="form-control" type="text"/>
						</div>
						<div class="form-group">
							<label class="help-block" for="image">Image</label>
							<input id="image" name="image" class="form-control" type="file"/>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-default">Ajouter</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection