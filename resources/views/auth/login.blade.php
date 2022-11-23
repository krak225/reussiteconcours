@extends('layouts.app')

@section('content')
	
	<!---page Title --->
	<section class="bg-img pt-150 pb-20" data-overlay="7" style="background-image: url(../images/front-end-img/background/bg-8.jpg);">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="text-center">						
						<h2 class="page-title text-white">Ouverture de session</h2>
						<ol class="breadcrumb bg-transparent justify-content-center">
							<li class="breadcrumb-item"><a href="#" class="text-white-50"><i class="mdi mdi-home-outline"></i></a></li>
							<li class="breadcrumb-item text-white active" aria-current="page">Login</li>
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
							<h2 class="text-primary">Se connecter</h2>
							<p class="mb-0">Identifiez-vous pour continuer.</p>							
						</div>
						<div class="p-40">
							<form action="{{ route('login') }}" method="post">
							{{ csrf_field() }}
								<div class="form-group">
									<div class="input-group mb-15">
										<div class="input-group-prepend">
											<span class="input-group-text bg-transparent"><i class="ti-user"></i></span>
										</div>
										<input type="text" class="form-control pl-15 bg-transparent" name="email" value="{{ old('email') }}" placeholder="Username">
									</div>
								</div>
								<div class="form-group">
									<div class="input-group mb-15">
										<div class="input-group-prepend">
											<span class="input-group-text  bg-transparent"><i class="ti-lock"></i></span>
										</div>
										<input type="password" class="form-control pl-15 bg-transparent" placeholder="Password" name="password" required>
									</div>
								</div>
								  <div class="row">
									<div class="col-6">
									  <div class="checkbox ml-5">
										<input type="checkbox" id="basic_checkbox_1">
										<label for="basic_checkbox_1">Se souvenir</label>
									  </div>
									</div>
									<!-- /.col -->
									<div class="col-6">
									 <div class="fog-pwd text-right">
										<a href="javascript:void(0)" class="hover-warning"><i class="ion ion-locked"></i> Mot de passe oublié ?</a><br>
									  </div>
									</div>
									<!-- /.col -->
									<div class="col-12 text-center">
									  <button type="submit" class="btn btn-info btn-block mt-15">SE CONNECTER</button>
									</div>
									<!-- /.col -->
								  </div>
							</form>	
							<div class="text-center">
								<p class="mt-15 mb-0">Pas encore inscrit ? <a href="{{ route('inscription') }}" class="text-warning ml-5">S'inscrire</a></p>
							</div>	
						</div>
					</div>								

					<div class="text-center">
					  <p class="mt-20">- Se connecter via  -</p>
					  <p class="d-flex gap-items-2 mb-0 justify-content-center">
						  <a class="btn btn-social-icon btn-round btn-facebook" href="#"><i class="fa fa-facebook"></i></a>
						  <a class="btn btn-social-icon btn-round btn-twitter" href="#"><i class="fa fa-twitter"></i></a>
						  <a class="btn btn-social-icon btn-round btn-instagram" href="#"><i class="fa fa-instagram"></i></a>
						</p>	
					</div>
				</div>
			</div>
		</div>
	</section>
	

@endsection