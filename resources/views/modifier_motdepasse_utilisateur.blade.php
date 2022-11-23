@extends('layouts.app')

@section('content')
<ul class="breadcrumb no-border no-radius b-b b-light pull-in"> 
	<li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Accueil</a></li> 
	<li><a href="{{ route('utilisateurs') }}"><i class="fa fa-users"></i> Utilisateurs</a></li> 
	<li class="active">Réinitialisation du mot de passe d'un utilisateur</li> 
</ul> 

<div class="m-b-md"> 
	<h3 class="m-b-none">Réinitialisation du mot de passe d'un utilisateur</h3> 
</div>

@if(Session::has('message'))
	<div class="alert alert-success">
	  {{Session::get('message')}}
	</div>
@endif

@if(Session::has('warning'))
	<div class="alert alert-warning">
	  {{Session::get('warning')}}
	</div>
@endif


<div class="panel panel-default"> 

	<div class="wizard-steps clearfix" id="form-wizard"> 
		<ul class="steps"> 
			<li data-target="#step3"><span class="badge"></span>Informations</li>
		</ul> 
	</div> 

	<div class="step-content clearfix"> 
		<form enctype="multipart/form-data"  method="post" class="form-horizontal" action="{{route('SaveModifierMotdepasseUtilisateur',$user->id)}}">
			
			{!! csrf_field() !!}
			
			<div class="step-pane active" id="step1"> 
					
				<div class="form-group">
					<label for="login" class="col-md-4 control-label">Login</label>

					<div class="col-md-4">
						<input type="text" disabled class="form-control" value="{{ $user->email }}">
						
					</div>
				</div>

				<div class="form-group{{ $errors->has('nom') ? ' has-error' : '' }}">
					<label for="nom" class="col-md-4 control-label">Nom</label>

					<div class="col-md-4">
						<input id="nom" type="text" class="form-control" disabled name="nom" value="{{ $user->nom }}" required>

						@if ($errors->has('nom'))
							<span class="help-block">
								<strong>{{ $errors->first('nom') }}</strong>
							</span>
						@endif
					</div>
				</div>

				<div class="form-group{{ $errors->has('prenoms') ? ' has-error' : '' }}">
					<label for="prenoms" class="col-md-4 control-label">Prénoms</label>

					<div class="col-md-4">
						<input id="prenoms" type="text" class="form-control" disabled name="prenoms" value="{{ $user->prenoms }}" required>

						@if ($errors->has('prenoms'))
							<span class="help-block">
								<strong>{{ $errors->first('prenoms') }}</strong>
							</span>
						@endif
					</div>
				</div>

				
				<div id="box_motdepasse">
					
					<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
						<label for="password" class="col-md-4 control-label">Mot de passe</label>

						<div class="col-md-4">
							<input id="password" type="password" class="form-control" name="password" autocomplete="off">

							@if ($errors->has('password'))
								<span class="help-block">
									<strong>{{ $errors->first('password') }}</strong>
								</span>
							@endif
						</div>
					</div>
					
					<div class="form-group">
						<label for="password-confirm" class="col-md-4 control-label">Confirmer mot de passe</label>

						<div class="col-md-4">
							<input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="off" >
							@if ($errors->has('password'))
								<span class="help-block">
									<strong>{{ $errors->first('password') }}</strong>
								</span>
							@endif
						</div>
						
					</div>
				</div>
				
				
			</div> 
			
			
			<div class="line line-lg pull-in"></div>
			
			<div class="actions pull-left"> 
				<button type="reset" class="btn btn-warning btn-sm">Annuler</button> 
			</div>

			<div class="actions pull-right"> 
				<button type="submit" class="btn btn-success btn-sm">ENREGISTRER</button> 
			</div>
			
		</form>
		
		 
	
	</div>
	
	
	
	
	
</div>
 
@endsection