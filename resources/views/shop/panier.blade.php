@extends('layouts.app')

@section('content')
	
	<!---page Title --->
	<section class="bg-img pt-150 pb-20" data-overlay="7" style="background-image: url(../images/front-end-img/background/bg-8.jpg);">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="text-center">						
						<h2 class="page-title text-white">Mon panier</h2>
						<ol class="breadcrumb bg-transparent justify-content-center">
							<li class="breadcrumb-item"><a href="#" class="text-white-50"><i class="mdi mdi-home-outline"></i></a></li>
							<li class="breadcrumb-item text-white active" aria-current="page">Mon panier</li>
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
				<div class="box">
				  <div class="box-header bg-info">
					<h4 class="box-title"><strong>DETAILS DE LA COMMANDE (<span id="cartArticlesCount">0</span> livres)</strong></h4>
				  </div>

				  <div class="box-body">
					<div class="table-responsive">
						<table class="table product-overview">
							<thead>
								<tr>
									<th>Image</th>
									<th>Informations </th>
									<th style="text-align:center">Prix</th>
									<th style="text-align:center">Action</th>
								</tr>
							</thead>
							<tbody id="cart-tablebody">
															
							</tbody>
						</table>
						<!--button class="btn btn-success pull-right"><i class="fa fa fa-shopping-cart"></i> Checkout</button>
						<button class="btn btn-info"><i class="fa fa-arrow-left"></i> Continue shopping</button-->
					</div>

				  </div>
				</div>
			  </div>
			  <div class="col-12 col-lg-6">
				<!--div class="box">
				  <div class="box-header bg-success">
					<h4 class="box-title"><strong>Bon de réduction</strong></h4>
				  </div>
				  <div class="box-body">
					<p>Si vous avez un code de réduction, entrez-le ici</p>
					<form class="form-inline mt-20">
						<div class="input-group w-p100">
							<input type="text" class="form-control">
							<div class="input-group-prepend">
							  <button type="button" class="btn btn-danger">Appliquer</button>
							</div>
						</div>
					</form>

				  </div>
				</div-->
				<div class="box">
				  <div class="box-header bg-dark">
					<h4 class="box-title"><strong>Support technique</strong></h4>
				  </div>

				  <div class="box-body">
					<h4 class="font-weight-800"><i class="ti-mobile"></i> +(225) 05 05 882 822</h4>
					<p>Contactez-nous pour toute information. Nous sommes disponible 7j/7.</p>
				  </div>
				</div>
			  </div>
			  <div class="col-12 col-lg-6">
				<div class="box">
				  <div class="box-header bg-info">
					<h4 class="box-title"><strong>Résumé de ma commande</strong></h4>
				  </div>
				  <div class="box-body py-0">
					<div class="table-responsive">
						<table class="table simple mb-0">
							<tbody>
								<tr>
									<td>Total</td>
									<td class="text-right font-weight-700 subtotal">0</td>
								</tr>
								<tr>
									<td>Réduction</td>
									<td class="text-right font-weight-700"><span class="text-danger mr-15">0%</span>0</td>
								</tr>
								<tr>
									<th class="bt-1">Net à Payer</th>
									<th class="bt-1 text-right font-weight-900 font-size-18 subtotal">0</th>
								</tr>
							</tbody>
						</table>
					</div>
				  </div>
				  <div class="box-footer">	
					<form method="post" action="{{route('SaveCommande')}}">
						{!! csrf_field() !!}
						<button class="btn btn-primary" id="btnAnnulerCommande">Annuler la commande</button>
						<button type="submit" class="btn btn-success pull-right" id="btnConfirmerCommande">Confirmer la commande</button>
					</form>
				  </div>
				</div> 
			  </div>
			</div>
		</div>
	</section>		

@endsection