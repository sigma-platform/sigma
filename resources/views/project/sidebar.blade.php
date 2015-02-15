@extends('app')
@section('content')
	<div class="page-with-sidebar">
		<div class="sidebar-wrapper">
			<ul class="nav nav-sidebar">
				<li>
					<a href="/project">
						<span class="glyphicon glyphicon-list"></span>
						Liste des projets
					</a>
				</li>
				<li>
					<a href="/project/waiting">
						<span class="glyphicon glyphicon-list"></span>
						Liste des demandes
					</a>
				</li>
				<li>
					<a href="/project/create">
						<span class="glyphicon glyphicon-plus"></span>
						Ajouter un projet
					</a>
				</li>
			</ul>
		</div>
		<div class="content-wrapper">
			@yield('subject')
		</div>
	</div>
@endsection