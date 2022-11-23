@extends('layouts.app')

@section('content')

	
	<!---page Title --->
	<section class="bg-img pt-150 pb-20" data-overlay="7" style="background-image: url(../images/front-end-img/background/bg-8.jpg);">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="text-center">						
						<h2 class="page-title text-white">Téléchargement</h2>
						<ol class="breadcrumb bg-transparent justify-content-center">
							<li class="breadcrumb-item"><a href="#" class="text-white-50"><i class="mdi mdi-home-outline"></i></a></li>
							<li class="breadcrumb-item text-white" aria-current="page">Commandes</li>
							<li class="breadcrumb-item text-white active" aria-current="page">Livres achetés</li>
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
					<h4 class="box-title"><strong>LISTE DES LIVRES TELECHARGEABLES ({{ count($livres_achetes) }} )</strong></h4>
				  </div>

				  <div class="box-body">
					<div class="table-responsive">
						<table class="table product-overview">
							<thead>
								<tr>
									<th>Image</th>
									<th>Informations </th>
									<th style="text-align:center">Prix</th>
									<th style="text-align:center">Nombre Téléch.</th>
									<th style="text-align:center">Action</th>
								</tr>
							</thead>
							<tbody id="cart-tablebody">
								@foreach($livres_achetes as $livre)
								<tr>
									<td><img src="{{ asset('images/livres/couvertures/'.$livre->livre_couverture) }}" alt="" width="80"></td>
									<td>
										<h5>{{ $livre->livre_nom }}</h5>
										<p>{{ $livre->livre_description }}</p>
									</td>
									<td width="150" align="center" class="font-weight-900">{{ $livre->livre_prix }} FCFA</td>
									<td width="150" align="center">{{ $livre->detail_commande_nombre_telechargement }}</td>
									<td width="150" align="center"><a href="{{ route('telecharger', $livre->livre_id) }}"><i class="fa fa-download text-success"></i> Télécharger</a></td>
								</tr>
								@endforeach								
							</tbody>
						</table>
					</div>

				  </div>
				</div>
			  </div>
			  <div class="col-12 col-lg-6">
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
			</div>
		</div>
	</section>		


@endsection