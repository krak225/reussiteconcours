@extends('layouts.app')

@section('content')

<ul class="breadcrumb no-border no-radius b-b b-light pull-in"> 
	<li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Accueil</a></li> 
	<li class="active">Mon compte</li> 
</ul> 

<div class="m-b-md"> 
	<h3 class="m-b-none">Modifier mon mot de passe</h3> 
</div>

@if(Session::has('message'))
	<div class="alert alert-success">
	  {{Session::get('message')}}
	</div>
@endif

@if (Session::has('errors'))
	<div class="alert alert-danger">
		{{ $errors->first('new_password') }}
	</div>
@endif

@if (Session::has('authFailed'))
	<div class="alert alert-danger">
	{{Session::get('authFailed')}}
	</div>
@endif

<section class="panel panel-default"> 
	<div class="row m-l-none m-r-none bg-light lter">
	
		<header class="panel-heading text-center"> 
			<strong></strong> 
		</header> 
		
		@if(Session::has('current_password'))
			<div class="alert alert-info">
			Mot de passe actuel est:  {{Session::get('current_password')}}
			</div>
		@endif

		<form class="form-horizontal panel-body wrapper-lg" method="post" action="{{ route('updatePassword') }}">
			{{ csrf_field() }}

			<div class="form-group{{ $errors->has('current_password') ? ' has-error' : '' }}">
				<label for="current_password" class="col-md-4 control-label">Mot de passe actuel</label>

				<div class="col-md-4">
					<input id="current_password" type="password" class="form-control" name="current_password" value="@if(session('current_password')) Burida2022 @endif" required autofocus>

					@if ($errors->has('current_password'))
						<span class="help-block">
							<strong>{{ $errors->first('current_password') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group">
				<label for="new_password" class="col-md-4 control-label">Nouveau Mot de passe</label>

				<div class="col-md-4">
					<input id="new_password_confirmation" type="password" class="form-control {{ $errors->has('new_password') ? ' has-error' : '' }}" name="new_password_confirmation" required>

					
				</div>
			</div>

			
			<div class="form-group">
				<label for="new_password" class="col-md-4 control-label">Confirmer le nouveau Mot de passe</label>

				<div class="col-md-4">
					<input id="new_password" type="password" class="form-control {{ $errors->has('new_password') ? ' has-error' : '' }}" name="new_password" required>

				</div>
			</div>

			
			<div class="form-group">
				<label class="col-md-4 control-label">&nbsp;</label>
				<div class="col-md-4">
					<input type="submit" class="btn btn-primary" value="Valider"/>
				</div>
			</div>

		</form>
		
	</div>
	
</section>



@endsection