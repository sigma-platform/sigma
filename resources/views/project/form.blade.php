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
							<textarea id="description" name="description" class="form-control" cols="30" rows="5">
								{{ (isset($project)) ? $project->description : "" }}
							</textarea>
						</div>
						<div class="form-group">
							<label class="help-block" for="slug">Identifiant</label>
							<input id="slug" name="slug" class="form-control" type="text" value="{{ (isset($project)) ? $project->slug : "" }}"/>
							<p class="help-block">Attention ce champs doit contenir uniquement des caractères alphanumérique ainsi que des tirets.</p>
						</div>
						<div class="form-group">
							<label class="help-block" for="project_group">Groupe</label>
							<select class="form-control" name="project_group_id" id="project_group">
								@foreach($projectGroups as $projectGroup)
									<option value="{{ $projectGroup->id }}" {{ (isset($project) && $project->project_group_id == $projectGroup->id) ? "selected" : "" }}>{{ $projectGroup->label }}</option>
								@endforeach
							</select>
						</div>
						<button type="submit" class="btn btn-default btn-group-justified">{{ (isset($project)) ? "Mettre à jour" : "Créer" }}</button>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection