@extends('layouts.app')

@section('content')

<ul class="breadcrumb no-border no-radius b-b b-light pull-in"> 
	<li><a href="{{route('home')}}"><i class="fa fa-home"></i> Accueil</a></li>  
	<li class="active">Utilisateurs</li> 
</ul> 


@if(Session::has('warning'))
	<div class="alert alert-warning">
	  {{Session::get('warning')}}
	</div>
@endif

@if(Session::has('message'))
	<div class="alert alert-success">
	  {{Session::get('message')}}
	</div>
@endif


<div class="m-b-md"> 
	<h3 class="m-b-none">Liste des utilisateurs</h3> 
</div>

<section class="panel panel-default"> 
	<header class="panel-heading"> Liste des utilisateurs</header> 
	
	<div class="table-responsive"> 
		<table class="table table-striped m-b-none datatable" data-ride="listeusers"> 
			<thead> 
				<tr>  
					<th width="3%"></th>
					<th width="3%"></th>
					<th width="3%"></th>
					<!--th width="3%"></th-->
					<th width="15%">Nom</th> 
					<th width="">Prénoms</th> 
					<th width="15%">Login</th>
					<th width="15%">Profil</th> 
					<th width="10%">Téléphone</th>
					<th width="15%">Service</th>
				</tr> 
			</thead> 
			<tbody>
			@foreach($users as $user)
				<tr>
					<td>
						<a href="{{ route('DetailsUtilisateur',$user->id) }}"><i class="fa fa-info-circle text-info" title="Afficher les informations de cet utilisateur"></i></a>
					</td>
					<td>					
					@if(Auth::user()->profil_id == 1)
						<a href="{{ route('modifier_motdepasse_utilisateur',$user->id) }}"><i class="fa fa-lock text-success" title="Modifier son mot de passe"></i></a>
					@endif
					</td>
					<td>					
					@if(Auth::user()->profil_id == 1)
						<a href="{{ route('ModifierUtilisateur',$user->id) }}"><i class="fa fa-edit text-warning" title="Modifier cet utilisateur"></i></a>
					@endif
					</td>
					<!--td>					
					@if(Auth::user()->profil_id == 1)
						<span style="cursor:pointer" class="btnSupprimerUtilisateur" data-id="{{ $user->id }}"><i class="fa fa-times text-danger" title="Supprimer cet utilisateur"></i></span>
					@endif
					</td-->
					<td>{{ $user->nom }}</td> 
					<td>{{ $user->prenoms }}</td>
					<td>{{ $user->email }}</td> 
					<td>{{ $user->profil_libelle }}</td>
					<td>{{ $user->telephone }}</td>
					<td title="{{ $user->direction_nom }}">{{ $user->service_nom }}</td>
				</tr>	
			@endforeach
			</tbody> 
		</table> 
	</div> 
</section>

@endsection