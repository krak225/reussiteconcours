@extends('layouts.app')

@section('content')

	<!-- BANNER -->
	<!--div id="slides" class="section banner owl-carousel">
		<ul class="slides-container">
			<li>
				<img src="images/slides/slide5.jpg" alt="">
				<div class="overlay-bg"></div>
				<div class="container">
					<div class="wrap-caption">
						<h2 class="caption-heading animate__animated animate__slideInRight">
							Lignes de Transport HTB
						</h2>
						<p class="excerpt animate__animated">(Overhead Lines)</p>	
					</div>
				</div>
			</li>
			<li>
				<img src="images/slides/slide2.jpg" alt="">
				<div class="overlay-bg"></div>
				<div class="container">
					<div class="wrap-caption right">
						<h2 class="caption-heading animate__animated animate__fadeInUp">
							Postes Sources HTB
						</h2>
						<p class="excerpt animate__animated animate__slideInUp">(Substations)</p>	
					</div>
				</div>
			</li>
			<li>
				<img src="images/slides/slide3.jpg" alt="">
				<div class="overlay-bg"></div>
				<div class="container">
					<div class="wrap-caption center">
						<h2 class="caption-heading animate__animated animate__fadeInDown">
							Réseaux HTA/BT/EP
						</h2>
						<p class="excerpt animate__animated animate__slideInRight">(Distribution)</p>	
					</div>
				</div>
			</li>
			<li>
				<img src="images/slides/slide3.jpg" alt="">
				<div class="overlay-bg"></div>
				<div class="container">
					<div class="wrap-caption center">
						
						<h2 class="caption-heading animate__animated animate__fadeInDown">
							Traitement Appels d’Offres
						</h2>
						<p class="excerpt animate__animated animate__slideInRight">(Tendering)</p>	
					</div>
				</div>
			</li>
			
		</ul>

		<nav class="slides-navigation">
			<div class="container">
				<a href="#" class="next">
					<i class="fa fa-chevron-right"></i>
				</a>
				<a href="#" class="prev">
					<i class="fa fa-chevron-left"></i>
				</a>
	      	</div>
	    </nav>
		
	</div-->
	
	
    <section class="bg-img pt-70 pb-50" data-overlay="2" style="background-image: url({{ asset('images/bg_accueil.jpg')}}); background-position: top center;">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="text-center mt-80">
						<h1 class="box-title text-white font-weight-600 mb-30" style="margin-top: 150px;">Tout pour réussir à votre concours</h1>	
						<form class="cours-search" action="#" autocomplete="off">
							<div class="input-group">
								<input type="text" class="form-control mr-2" required="" placeholder="Quel concours voulez-vous passer cette année ?" name="r" value="">
								<button class="btn btn-primary" type="submit">Rechercher</button>
							</div>
						</form>
					</div>
					<div class="text-center">
						<a href="#" class="btn btn-outline text-white">Liste des documents</a>
					</div>
				</div>
			</div>
		</div>
	</section>

	<a name="ed"></a>
	<section class="py-50 bg-white" data-aos="fade-up">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-7 col-12 text-center">
					<h1 class="mb-15">Explorer les documents</h1>
					<hr class="w-100 bg-primary">
				</div>
			</div>
			<div class="row mt-30">
				<div class="col-12">
					<ul class="nav nav-tabs justify-content-center bb-0 mb-10" role="tablist">
						<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#all" role="tab">Tout</a> </li>
						@foreach($concours as $cc)
						<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab_{{ $cc->concours_id }}" role="tab">{{ $cc->concours_libelle }}</a> </li>
						@endforeach
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="all" role="tabpanel">
							<div class="px-15 pt-15">
								<div class="row">
									
									@foreach($livres as $livre)
									<div class="col-lg-3 col-md-6 col-12">
										<div class="box">
											<a href="{{ route('details_livre', $livre->livre_id) }}">
												<img class="card-img-top" src="{{ asset('images/livres/couvertures/'.$livre->livre_couverture) }}" alt="Photo">
											</a>
											<div class="box-body"> 
												<div class="text-left">
													<h4 class="box-title"><a href="{{ route('details_livre', $livre->livre_id) }}">{{ $livre->livre_nom }}</a></h4>
													<!--p class="mb-10 text-light font-size-12"><i class="fa fa-calendar mr-5"></i> {{ $livre->livre_date_creation }}</p-->
													<p class="box-text text-muted my-5 text-justify">{{ $livre->livre_description }}</p>
													<h4 class="pro-price text-blue">{{ $livre->livre_prix }} FCFA<small class="ml-5"><del><!--$24.99--></del></small></h4>
													<span class="btn btn-outline btn-primary btn-sm btnAddPanier" data-livre_id="{{ $livre->livre_id }}" data-livre_prix="{{ $livre->livre_prix }}" data-livre_nom="{{ $livre->livre_nom }}" data-livre_description="{{ $livre->livre_description }}" data-livre_couverture="{{ asset('images/livres/couvertures/'.$livre->livre_couverture) }}"><i class="mdi mdi-cart-plus"></i> Ajouter au panier</span>
												</div>
											</div>
										</div>
									</div>
									@endforeach
									
								</div>
							</div>
						</div>
						
						@foreach($concours as $cc)
						<div class="tab-pane" id="tab_{{ $cc->concours_id }}" role="tabpanel">
							<div class="px-15 pt-15">
								<div class="row">
									
									@if(isset($cc->livres))
									@foreach($cc->livres as $livre)
									<div class="col-lg-3 col-md-6 col-12">
										<div class="box">
											<a href="{{ route('details_livre', $livre->livre_id) }}">
												<img class="card-img-top" src="{{ asset('images/livres/couvertures/'.$livre->livre_couverture) }}" alt="Photo">
											</a>
											<div class="box-body"> 
												<div class="text-left">
													<h4 class="box-title">{{ $livre->livre_nom }}</h4>
													<!--p class="mb-10 text-light font-size-12"><i class="fa fa-calendar mr-5"></i> {{ $livre->livre_date_creation }}</p-->
													<p class="box-text">{{ $livre->livre_description }}</p>
													<h4 class="pro-price text-blue">{{ $livre->livre_prix }} FCFA<small class="ml-5"><del><!--$24.99--></del></small></h4>
													<span class="btn btn-outline btn-primary btn-sm btnAddPanier" data-livre_id="{{ $livre->livre_id }}" data-livre_prix="{{ $livre->livre_prix }}" data-livre_nom="{{ $livre->livre_nom }}" data-livre_description="{{ $livre->livre_description }}" data-livre_couverture="{{ asset('images/livres/couvertures/'.$livre->livre_couverture) }}"><i class="mdi mdi-cart-plus"></i> Ajouter au panier</span>
												</div>
											</div>
										</div>
									</div>
									@endforeach
									@endif
									
								</div>
							</div>
						</div>
						@endforeach
						
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<a name="cp"></a>
	<section class="pt-xl-100 pb-50" data-aos="fade-up">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-xl-10 col-12">
					<div class="box box-body p-xl-50 p-30">
						<div class="row align-items-center">
							<div class="col-lg-6 col-12">
								<p class="badge badge-danger badge-lg">LIVE</p>
								<h1 class="mb-15">COURS DE PREPARATIONS</h1>
								<h4 class="font-weight-400">Des professeurs qualifiés pour vous dispenser les cours qu'il faut...</h4>
								<p class="font-size-22">Experimentez dès maintenant !</p>
								<a href="#" class="btn btn-outline btn-primary">S'inscrire</a> 
								<a href="https://wa.me/0505882822" class="btn btn-outline btn-success">Discuter sur WhatsApp</a>
							</div>
							<div class="col-lg-6 col-12">
								<div class="media-list media-list-hover media-list-divided md-post mt-lg-0 mt-30">
									<a class="media media-single box-shadowed bg-white pull-up mb-15" href="#">
									  <img class="w-80 rounded ml-0" src="{{ asset('images/cours_preparation.png') }}" alt="...">
									  <div class="media-body font-weight-500">
										<h5 class="overflow-hidden text-overflow-h nowrap">INHP</h5>
										<small class="text-fade">Samedi, de 8:00 - 12:00</small>
										<p><small class="text-fade mt-10">CULTURE GENERALE</small></p>
									  </div>
									</a>
									<a class="media media-single box-shadowed bg-white pull-up mb-15" href="#">
									  <img class="w-80 rounded ml-0" src="{{ asset('images/cours_preparation.png') }}" alt="...">
									  <div class="media-body font-weight-500">
										<h5 class="overflow-hidden text-overflow-h nowrap">CAFOP</h5>
										<small class="text-fade">Samedi, de 14:00 - 18:00</small>
										<p><small class="text-fade mt-10">MATHEMAQIQUE</small></p>
									  </div>
									</a>
									<a class="media media-single box-shadowed bg-white pull-up mb-15" href="#">
									  <img class="w-80 rounded ml-0" src="{{ asset('images/cours_preparation.png') }}" alt="...">
									  <div class="media-body font-weight-500">
										<h5 class="overflow-hidden text-overflow-h nowrap">INFAS</h5>
										<small class="text-fade">Samedi, de 14:00 - 18:00</small>
										<p><small class="text-fade mt-10">SCIENCES NATURELLES</small></p>
									  </div>
									</a>
									<a class="media media-single box-shadowed bg-white pull-up mb-0" href="#">
									  <img class="w-80 rounded ml-0" src="{{ asset('images/cours_preparation.png') }}" alt="...">
									  <div class="media-body font-weight-500">
										<h5 class="overflow-hidden text-overflow-h nowrap">POLICE</h5>
										<small class="text-fade">Samedi, de 14:00 - 18:00</small>
										<p><small class="text-fade mt-10">OPAJ</small></p>
									  </div>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>						
		</div>
	</section>
	
	<section class="py-50" data-aos="fade-up">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-7 col-12 text-center">
					<h1 class="mb-15">Nos Partenaires.</h1>					
					<hr class="w-100 bg-primary">
				</div>
			</div>
			<div class="row mt-30">
				<div class="col-12">
					<div class="owl-carousel owl-theme owl-btn-1" data-nav-arrow="false" data-nav-dots="false" data-items="6" data-md-items="4" data-sm-items="3" data-xs-items="2" data-xx-items="2">
						<div class="item"><img src="../images/front-end-img/unilogo/uni-1.jpg" class="img-fluid my-15 rounded box-shadowed pull-up" alt="" ></div>
						<div class="item"><img src="../images/front-end-img/unilogo/uni-2.jpg" class="img-fluid my-15 rounded box-shadowed pull-up" alt="" ></div>
						<div class="item"><img src="../images/front-end-img/unilogo/uni-3.jpg" class="img-fluid my-15 rounded box-shadowed pull-up" alt="" ></div>
						<div class="item"><img src="../images/front-end-img/unilogo/uni-4.jpg" class="img-fluid my-15 rounded box-shadowed pull-up" alt="" ></div>
						<div class="item"><img src="../images/front-end-img/unilogo/uni-5.jpg" class="img-fluid my-15 rounded box-shadowed pull-up" alt="" ></div>
						<div class="item"><img src="../images/front-end-img/unilogo/uni-6.jpg" class="img-fluid my-15 rounded box-shadowed pull-up" alt="" ></div>
						<div class="item"><img src="../images/front-end-img/unilogo/uni-7.jpg" class="img-fluid my-15 rounded box-shadowed pull-up" alt="" ></div>
						<div class="item"><img src="../images/front-end-img/unilogo/uni-8.jpg" class="img-fluid my-15 rounded box-shadowed pull-up" alt="" ></div>
						<div class="item"><img src="../images/front-end-img/unilogo/uni-9.jpg" class="img-fluid my-15 rounded box-shadowed pull-up" alt="" ></div>
						<div class="item"><img src="../images/front-end-img/unilogo/uni-10.jpg" class="img-fluid my-15 rounded box-shadowed pull-up" alt="" ></div>
						<div class="item"><img src="../images/front-end-img/unilogo/uni-11.jpg" class="img-fluid my-15 rounded box-shadowed pull-up" alt="" ></div>
						<div class="item"><img src="../images/front-end-img/unilogo/uni-12.jpg" class="img-fluid my-15 rounded box-shadowed pull-up" alt="" ></div>
					</div>
				</div>
			</div>
		</div>
	</section>
	

@endsection