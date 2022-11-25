@extends('layouts.app')

@section('content')


	<!---page Title --->
	<section class="bg-img pt-150 pb-20" data-overlay="7" style="background-image: url(../images/front-end-img/background/bg-8.jpg);">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="text-center">						
						<h2 class="page-title text-white">{{ $livre->livre_nom }}</h2>
						<ol class="breadcrumb bg-transparent justify-content-center">
							<li class="breadcrumb-item"><a href="#" class="text-white-50"><i class="mdi mdi-home-outline"></i></a></li>
							<li class="breadcrumb-item text-white active" aria-current="page">{{ $livre->livre_nom }}</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--Page content -->
	
	<section class="py-50">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="box mb-0">
						<div class="box-body">
							<div class="row">
								<div class="col-md-4 col-sm-6">
									<div class="box box-body b-1 text-center no-shadow">
										<img src="{{ asset('images/livres/couvertures/'.$livre->livre_couverture) }}" id="product-image" class="img-fluid" alt="" />
									</div>
									<div class="pro-photos">
										<div class="photos-item item-active">
											<img src="{{ asset('images/livres/couvertures/'.$livre->livre_couverture) }}" alt="" >
										</div>
										<div class="photos-item">
											<img src="../images/front-end-img/product/product-7.png" alt="" >
										</div>
										<div class="photos-item">
											<img src="../images/front-end-img/product/product-8.png" alt="" >
										</div>
										<div class="photos-item">
											<img src="../images/front-end-img/product/product-9.png" alt="" >
										</div>
									</div>
									<div class="clear"></div>
								</div>
								<div class="col-md-8 col-sm-6">
									<h2 class="box-title mt-0">{{ $livre->livre_nom }}</h2>
									<div class="list-inline">
										<a class="text-warning"><i class="mdi mdi-star"></i></a>
										<a class="text-warning"><i class="mdi mdi-star"></i></a>
										<a class="text-warning"><i class="mdi mdi-star"></i></a>
										<a class="text-warning"><i class="mdi mdi-star"></i></a>
										<a class="text-warning"><i class="mdi mdi-star"></i></a>
									</div>
									<h1 class="pro-price mb-0 mt-20">{{ $livre->livre_prix }} FCFA</h1>
									<hr>
									<p>{{ $livre->livre_description }}</p>
									<hr>
									<div class="d-inline-block">
										<button class="btn btn-primary mr-10 mb-10 btnAddPanier" data-livre_id="{{ $livre->livre_id }}" data-livre_prix="{{ $livre->livre_prix }}" data-livre_nom="{{ $livre->livre_nom }}" data-livre_description="{{ $livre->livre_description }}"><i class="mdi mdi-cart-plus"></i> Ajouter au panier</button>
										<!--button class="btn btn-success mr-10 mb-10"><i class="mdi mdi-download"></i> Télécharger</button-->
									</div>
									<h4 class="box-title mt-20 d-block">Concours concernés</h4>
									<ul class="list list-unstyled mb-30">
										<li><i class="fa fa-check text-danger float-none"></i> POLICE</li>
										<li><i class="fa fa-check text-danger float-none"></i> CAFOP</li>
										<li><i class="fa fa-check text-danger float-none"></i> INHP</li>
									</ul>
								</div>
								<div class="col-12">
									<!-- Nav tabs -->
									<ul class="nav nav-tabs customtab2" role="tablist">
										<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home7" role="tab"><span class="hidden-sm-up"><i class="ion-home"></i></span> <span class="hidden-xs-down">Detail</span></a> </li>
										<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#messages7" role="tab"><span class="hidden-sm-up"><i class="ion-email"></i></span> <span class="hidden-xs-down">Témoignages clients</span></a> </li>
									</ul>
									<!-- Tab panes -->
									<div class="tab-content">
										<div class="tab-pane active" id="home7" role="tabpanel">
											<div class="px-15 pt-30">{{ $livre->livre_description }}</div>
										</div>
										<div class="tab-pane" id="messages7" role="tabpanel">
											<div class="px-15 pt-30">
												<div class="card card-body no-border no-shadow mb-0 p-0">
													<!--div class="card-courses-list-bx">
														<ul class="card-courses-view">
															<li class="card-courses-user">
																<div class="card-courses-user-pic bg-primary-light">
																	<img src="../images/avatar/avatar-1.png" alt="">
																</div>
																<div class="card-courses-user-info">
																	<h5>Reviewer</h5>
																	<h4>Keny White</h4>
																</div>
															</li>
															<li class="card-courses-review">
																<h5>3 Review</h5>
																<ul class="cours-star">
																	<li class="active"><i class="fa fa-star"></i></li>
																	<li class="active"><i class="fa fa-star"></i></li>
																	<li class="active"><i class="fa fa-star"></i></li>
																	<li><i class="fa fa-star"></i></li>
																	<li><i class="fa fa-star"></i></li>
																</ul>
															</li>
															<li class="card-courses-categories">
																<h5>Date</h5>
																<h4>10/12/2019</h4>
															</li>
														</ul>
													</div>
													<div class="row card-courses-dec">
														<div class="col-md-12">
															<h6 class="mb-10">Best Quality Product</h6>
															<p>Lorem ipsum dolor sit amet, est ei idque voluptua copiosae, pro detracto disputando reformidans at, ex vel suas eripuit. Vel alii zril maiorum ex, mea id sale eirmod epicurei. Sit te possit senserit, eam alia veritus maluisset ei, id cibo vocent ocurreret per. Te qui doming doctus referrentur, usu debet tamquam et. Sea ut nullam aperiam, mei cu tollit salutatus delicatissimi. </p>	
														</div>
													</div-->
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>				
					</div>
				</div>
			</div>
		</div>
	</section>		
	
	<section class="pb-50">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<h2>Autres livres</h2>
					<hr>
				</div>
			</div>
			<div class="row fx-element-overlay">
			
				@foreach($autres_livres as $livre)
				<div class="col-12 col-xl-3 col-md-6">
					<div class="box box-default">
						<div class="fx-card-item">
							<div class="fx-card-avatar fx-overlay-1 mb-0"> <img src="{{ asset('images/livres/couvertures/'.$livre->livre_couverture) }}" alt="Photo">
								<div class="fx-overlay scrl-up">						
									<ul class="fx-info">
										<li><a class="btn btn-outline image-popup-vertical-fit" href="{{ route('details_livre', $livre->livre_id) }}">Voir plus</a></li>
										<li><span class="btn btn-outline btn-primary btn-sm btnAddPanier" data-livre_id="{{ $livre->livre_id }}" data-livre_prix="{{ $livre->livre_prix }}" data-livre_nom="{{ $livre->livre_nom }}" data-livre_description="{{ $livre->livre_description }}" data-livre_couverture="{{ asset('images/livres/couvertures/'.$livre->livre_couverture) }}"><i class="mdi mdi-cart-plus"></i> Ajouter au panier</span></li>
									</ul>
								</div>
							</div>
							<div class="fx-card-content text-left mb-0">							
								<div class="product-text">
									<h4 class="box-title mb-0">{{ $livre->livre_nom }}</h4>
									<p class="text-muted my-5 text-justify">{{ $livre->livre_description }}</p>
									<ul class="cours-star mb-5">
										<li class="active"><i class="fa fa-star"></i></li>
										<li class="active"><i class="fa fa-star"></i></li>
										<li class="active"><i class="fa fa-star"></i></li>
										<li class="active"><i class="fa fa-star"></i></li>
										<li class="active"><i class="fa fa-star"></i></li>
									</ul>
									<h4 class="pro-price text-blue">{{ $livre->livre_prix }} FCFA<small class="ml-5"><del></del></small></h4>
								</div>
							</div>
						</div>
					</div>				  
				</div>
				@endforeach  
			  
			</div>
		</div>
	</section>


@endsection