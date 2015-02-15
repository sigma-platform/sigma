@extends('app')
@section('content')
	<div class="page-with-sidebar">
		<div class="sidebar-wrapper">
			<ul class="nav nav-sidebar">
				<li>
					<a href="/project" class="{{ Request::is('project') ? 'active' : '' }}">
						<span class="glyphicon glyphicon-list"></span>
						<span class="link-name">Liste des projets</span>
					</a>
				</li>
				<li>
					<a href="/project/waiting" class="{{ Request::is('project/waiting') ? 'active' : '' }}">
						<span class="glyphicon glyphicon-inbox"></span>
						<span class="link-name">Liste des demandes</span>
					</a>
				</li>
				<li>
					<a href="/project/create" class="{{ Request::is('project/create') ? 'active' : '' }}">
						<span class="glyphicon glyphicon-plus"></span>
						<span class="link-name">Ajouter un projet</span>
					</a>
				</li>
			</ul>
		</div>
		<div class="content-wrapper">
			@yield('subject')
		</div>
	</div>
@endsection