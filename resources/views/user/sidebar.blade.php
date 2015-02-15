@extends('app')
@section('content')
	<div class="page-with-sidebar">
		<div class="sidebar-wrapper">
			<ul class="nav nav-sidebar">
				<li>
					<a href="/user" class="{{ Request::is('user') ? 'active' : '' }}">
						<span class="glyphicon glyphicon-list"></span>
						<span class="link-name">Liste des utilisateurs</span>
					</a>
				</li>
				<li>
					<a href="/user/create" class="{{ Request::is('user/create') ? 'active' : '' }}">
						<span class="glyphicon glyphicon-plus"></span>
						<span class="link-name">Ajouter un utilisateur</span>
					</a>
				</li>
			</ul>
		</div>
		<div class="content-wrapper">
			@yield('subject')
		</div>
	</div>
@endsection