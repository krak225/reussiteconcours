@extends('layouts.app')

@section('content')
<ul class="breadcrumb no-border no-radius b-b b-light pull-in"> 
	<li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Accueil</a></li> 
	<li><a href="{{ route('utilisateurs') }}"><i class="fa fa-users"></i> Utilisateurs</a></li> 
	<li class="active">Modification de compte utilisateur</li> 
</ul> 

<div class="m-b-md"> 
	<h3 class="m-b-none">Modification d'un compte utilisateur</h3> 
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
		<form enctype="multipart/form-data"  method="post" class="form-horizontal" action="{{route('ModifierUtilisateur',$user->id)}}">
			
			{!! csrf_field() !!}
			
			<div class="step-pane active" id="step1"> 
					
				<div class="form-group">
					<label for="login" class="col-md-4 control-label">Login</label>

					<div class="col-md-4">
						<input type="text" disabled class="form-control" value="{{ $user->email }}">
						
					</div>
				</div>

				
				<div class="form-group{{ $errors->has('profil_id') ? ' has-error' : '' }}">
					<label for="profil_id" class="col-md-4 control-label">Profil <span class="text text-danger">&nbsp;<span></label>

					<div class="col-md-4">
						
						<select  id="profil_id" class="form-control" name="profil_id" required>
							<option value="">Choisir</option>
							@foreach($profils as $profil)
							<?php $selected = ($user->profil_id == $profil->profil_id) ? ' selected ' : '' ; ?>
							<option {{$selected}} value="{{ $profil->profil_id }}">{{ $profil->profil_libelle }}</option>
							@endforeach
						</select>
						@if ($errors->has('profil_id'))
							<span class="help-block">
								<strong>{{ $errors->first('profil_id') }}</strong>
							</span>
						@endif
					</div>
				</div>
				
				
				<div class="form-group{{ $errors->has('code_importateur') ? ' has-error' : '' }}">
					<label for="code_importateur" class="col-md-4 control-label">Code importateur/fabricant <span class="text text-danger"></span></label>

					<div class="col-md-4">
						<input autocomplete="off" id="code_importateur" type="text" class="form-control" name="code_importateur" value="{{ $user->code_importateur }}" >

						@if ($errors->has('code_importateur'))
							<span class="help-block">
								<strong>{{ $errors->first('code_importateur') }}</strong>
							</span>
						@endif
					</div>
				</div>
				
				
				<!--div class="form-group{{ $errors->has('service_id') ? ' has-error' : '' }}">
					<label for="service_id" class="col-md-4 control-label">Service <span class="text text-danger">&nbsp;<span></label>

					<div class="col-md-4">
						
						<select  id="service_id" class="form-control" name="service_id" required>
							<option value="">Choisir</option>
							@foreach($services as $service)
							<?php $selected = ($user->service_id == $service->service_id) ? ' selected ' : '' ; ?>
							<option {{$selected}} value="{{ $service->service_id }}">{{ $service->service_nom }} ({{$service->direction_nom}})</option>
							@endforeach
						</select>
						@if ($errors->has('service_id'))
							<span class="help-block">
								<strong>{{ $errors->first('service_id') }}</strong>
							</span>
						@endif
					</div>
				</div-->
				

				<div class="form-group{{ $errors->has('nom') ? ' has-error' : '' }}">
					<label for="nom" class="col-md-4 control-label">Nom</label>

					<div class="col-md-4">
						<input id="nom" type="text" class="form-control" name="nom" value="{{ $user->nom }}" autofocus>

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
						<input id="prenoms" type="text" class="form-control" name="prenoms" value="{{ $user->prenoms }}" >

						@if ($errors->has('prenoms'))
							<span class="help-block">
								<strong>{{ $errors->first('prenoms') }}</strong>
							</span>
						@endif
					</div>
				</div>

				<div class="form-group{{ $errors->has('societe') ? ' has-error' : '' }}">
					<label for="societe" class="col-md-4 control-label">Entreprise/société</label>

					<div class="col-md-4">
						<input id="societe" type="text" class="form-control" name="societe" value="{{ $user->societe }}" required>

						@if ($errors->has('societe'))
							<span class="help-block">
								<strong>{{ $errors->first('societe') }}</strong>
							</span>
						@endif
					</div>
				</div>

				<div class="form-group{{ $errors->has('numero_registre_commerce') ? ' has-error' : '' }}">
					<label for="numero_registre_commerce" class="col-md-4 control-label">Numéro Régistre de commerce</label>

					<div class="col-md-4">
						<input autocomplete="off" id="numero_registre_commerce" type="text" maxlength="50" class="form-control" name="numero_registre_commerce" value="{{ $user->numero_registre_commerce }}" placeholder="" >

						@if ($errors->has('numero_registre_commerce'))
							<span class="help-block">
								<strong>{{ $errors->first('numero_registre_commerce') }}</strong>
							</span>
						@endif
					</div>
				</div>
				
				<div class="form-group{{ $errors->has('telephone') ? ' has-error' : '' }}">
					<label for="telephone" class="col-md-4 control-label">Téléphone mobile</label>

					<div class="col-md-4">
						<input id="telephone" type="text" class="form-control" name="telephone" value="{{ $user->telephone }}" >

						@if ($errors->has('telephone'))
							<span class="help-block">
								<strong>{{ $errors->first('telephone') }}</strong>
							</span>
						@endif
					</div>
				</div>
				
				<div class="form-group{{ $errors->has('adresse_email') ? ' has-error' : '' }}">
					<label for="adresse_email" class="col-md-4 control-label">Adresse E-mail</label>

					<div class="col-md-4">
						<input id="adresse_email" type="text" class="form-control" name="adresse_email" value="{{ $user->adresse_email }}" >

						@if ($errors->has('adresse_email'))
							<span class="help-block">
								<strong>{{ $errors->first('adresse_email') }}</strong>
							</span>
						@endif
					</div>
				</div>
				
				<div class="form-group{{ $errors->has('adresse_postale') ? ' has-error' : '' }}">
					<label for="adresse_postale" class="col-md-4 control-label">Adresse Postale</label>

					<div class="col-md-4">
						<input id="adresse_postale" type="text" class="form-control" name="adresse_postale" value="{{ $user->adresse_postale }}" >

						@if ($errors->has('adresse_postale'))
							<span class="help-block">
								<strong>{{ $errors->first('adresse_postale') }}</strong>
							</span>
						@endif
					</div>
				</div>
				
				
				<div class="form-group{{ $errors->has('situation_geographique') ? ' has-error' : '' }}">
					<label for="situation_geographique" class="col-md-4 control-label">Situation géographique <span class="text text-danger">&nbsp;<span></label>

					<div class="col-md-4">
						<input autocomplete="off" id="situation_geographique" type="text" class="form-control" name="situation_geographique" value="{{ $user->situation_geographique }}"  >

						@if ($errors->has('situation_geographique'))
							<span class="help-block">
								<strong>{{ $errors->first('situation_geographique') }}</strong>
							</span>
						@endif
					</div>
				</div>
				
				<!--div class="form-group">
					<label for="option_modifier_motdepasse" class="col-md-4 control-label">Modifier le mot de passe</label>

					<div class="col-md-4">
						<input type="checkbox" id="checkbox_option_modifier_motdepasse" name="option_modifier_motdepasse" value="1"> 
					</div>
				</div>
				
				<div id="box_motdepasse" style="display:none;">
					
					<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
						<label for="password" class="col-md-4 control-label">Mot de passe</label>

						<div class="col-md-4">
							<input id="password" type="password" class="form-control" name="password">

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
							<input id="password-confirm" type="password" class="form-control" name="password_confirmation" >
							@if ($errors->has('password'))
								<span class="help-block">
									<strong>{{ $errors->first('password') }}</strong>
								</span>
							@endif
						</div>
						
					</div>
				</div-->
				
				
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