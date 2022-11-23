@extends('layouts.app')

@section('content')
	
	<!---page Title --->
	<section class="bg-img pt-150 pb-20" data-overlay="7" style="background-image: url(../images/front-end-img/background/bg-8.jpg);">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="text-center">						
						<h2 class="page-title text-white">Création de compte</h2>
						<ol class="breadcrumb bg-transparent justify-content-center">
							<li class="breadcrumb-item"><a href="#" class="text-white-50"><i class="mdi mdi-home-outline"></i></a></li>
							<li class="breadcrumb-item text-white active" aria-current="page">S'inscrire</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--Page content -->
	
	<section class="py-50">
		<div class="container">
			<div class="row justify-content-center no-gutters">
				<div class="col-lg-5 col-md-5 col-12">
					<div class="box box-body">
						<div class="content-top-agile pb-0 pt-20">
							<h2 class="text-primary">Création de compte</h2>
							<p class="mb-0">Inscrivez-vous pour continuer.</p>							
						</div>
						<div class="content-top-agile pb-0 pt-0">
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

							@if (Session::has('errors'))
								<div class="alert alert-danger">
									VEUILLEZ RENSEIGNER CORRECTEMENT LE FORMULAIRE
									
									{{Session::get('errors')}}
								</div>
							@endif
						</div>
						<div class="p-40">
							<form action="{{ route('inscription') }}" method="post">
							{{ csrf_field() }}
								<div class="form-group {{ $errors->has('nom') ? ' has-error' : '' }}">
									<div class="input-group mb-15">
										<div class="input-group-prepend">
											<span class="input-group-text bg-transparent"><i class="ti-user"></i></span>
										</div>
										<input type="text" class="form-control pl-15 bg-transparent" name="nom" value="{{ old('nom') }}" placeholder="Nom" required>
									</div>
								</div>
								<div class="form-group {{ $errors->has('prenoms') ? ' has-error' : '' }}">
									<div class="input-group mb-15">
										<div class="input-group-prepend">
											<span class="input-group-text bg-transparent"><i class="ti-user"></i></span>
										</div>
										<input type="text" class="form-control pl-15 bg-transparent" name="prenoms" value="{{ old('prenoms') }}" placeholder="Prénoms" required>
									</div>
								</div>
								<!--div class="form-group {{ $errors->has('telephone') ? ' has-error' : '' }}">
									<div class="input-group mb-15">
										<div class="input-group-prepend">
											<span class="input-group-text bg-transparent"><i class="fa fa-phone"></i></span>
										</div>
										<input type="text" class="form-control pl-15 bg-transparent" name="telephone" value="{{ old('telephone') }}" placeholder="Téléphone" required>
									</div>
								</div-->
								<div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
									<div class="input-group mb-15">
										<div class="input-group-prepend">
											<span class="input-group-text bg-transparent"><i class="ti-email"></i></span>
										</div>
										<input type="email" class="form-control pl-15 bg-transparent" name="email" value="{{ old('email') }}" placeholder="E-mail" required>
									</div>
								</div>
								<div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
									<div class="input-group mb-15">
										<div class="input-group-prepend">
											<span class="input-group-text  bg-transparent"><i class="ti-lock"></i></span>
										</div>
										<input type="password" class="form-control pl-15 bg-transparent" name="password" required placeholder="Mot de passe" required>
									</div>
								</div>
								<div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
									<div class="input-group mb-15">
										<div class="input-group-prepend">
											<span class="input-group-text  bg-transparent"><i class="ti-lock"></i></span>
										</div>
										<input type="password" class="form-control pl-15 bg-transparent" name="password_confirmation" required placeholder="Confirmer le mot de passe" required>
									</div>
								</div>
								  <div class="row">
									<!-- /.col -->
									<div class="col-12 text-center">
									  <button type="submit" class="btn btn-info btn-block mt-15">VALIDER</button>
									</div>
									<!-- /.col -->
								  </div>
							</form>	
							<div class="text-center">
								<p class="mt-15 mb-0">Déjà inscrit ? <a href="{{ route('login') }}" class="text-warning ml-5">Se connecter</a></p>
							</div>	
						</div>
					</div>								

				</div>
			</div>
		</div>
	</section>
	

@endsection