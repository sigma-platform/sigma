@extends('app')
@section('content')
	<div class="page-with-sidebar">
		<div class="sidebar-wrapper">
			<ul class="nav nav-sidebar">
				<li>
					<a href="/user">
						<span class="glyphicon glyphicon-list"></span>
						Liste des utilisateurs
					</a>
				</li>
				<li>
					<a href="/user/create">
						<span class="glyphicon glyphicon-plus"></span>
						Ajouter un utilisateur
					</a>
				</li>
			</ul>
		</div>
		<div class="content-wrapper">
			@yield('subject')
		</div>
	</div>
@endsection