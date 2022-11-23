@extends('layouts.app')

@section('content')

<ul class="breadcrumb no-border no-radius b-b b-light pull-in"> 
	<li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Accueil</a></li> 
	<li class="active">Première connexion</li> 
</ul> 

<div class="m-b-md"> 
	<h3 class="m-b-none">Première connexion</h3> 
</div>

<section class="panel panel-default"> 
	<div class="row m-l-none m-r-none bg-light lter">
	
		<header class="panel-heading text-center"> 
			<!--strong>SE CONNECTER A LA PLATEFORME</strong--> 
		</header> 

		<form class="form-horizontal panel-body wrapper-lg" method="POST" action="{{ route('SavePremiereConnexion') }}">
			{{ csrf_field() }}
			
			<div class="form-group{{ $errors->has('login') ? ' has-error' : '' }}">
				<label for="login" class="col-md-4 control-label">Code importateur</label>

				<div class="col-md-4">
					<input autocomplete="off" id="login" type="text" class="form-control" name="login" value="{{ old('login') }}" required autofocus>

					@if ($errors->has('login'))
						<span class="help-block">
							<strong>{{ $errors->first('login') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group{{ $errors->has('adresse_email') ? ' has-error' : '' }}">
				<label for="adresse_email" class="col-md-4 control-label">Adresse e-mail</label>

				<div class="col-md-4">
					<input autocomplete="off" id="adresse_email" type="email" class="form-control" name="adresse_email" required>

					@if ($errors->has('adresse_email'))
						<span class="help-block">
							<strong>{{ $errors->first('adresse_email') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group">
			
				<div class="col-md-12 text-center">
				
					<button type="submit" class="btn btn-primary">
						OBTENIR MON MOT DE PASSE PAR MAIL
					</button>
				
				</div>
				
				<div class="col-md-12 text-center" style="padding:25px 0px;">
					<a class="btn btn-link btn btn-info" href="{{ route('login') }}">
						J'ai déjà mon mot de passe
					</a>
				</div>
				
			</div>
		</form>
		
	</div>
	
</section>



@endsection