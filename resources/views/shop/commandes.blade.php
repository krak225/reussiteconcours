@extends('layouts.app')

@section('content')

	
	<!---page Title --->
	<section class="bg-img pt-150 pb-20" data-overlay="7" style="background-image: url(../images/front-end-img/background/bg-8.jpg);">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="text-center">						
						<h2 class="page-title text-white">Commandes</h2>
						<ol class="breadcrumb bg-transparent justify-content-center">
							<li class="breadcrumb-item"><a href="#" class="text-white-50"><i class="mdi mdi-home-outline"></i></a></li>
							<li class="breadcrumb-item text-white active" aria-current="page">Commandes</li>
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
					<h4 class="box-title"><strong>LISTE DES COMMANDES</strong></h4>
				  </div>

				  <div class="box-body">
					<div class="table-responsive">
						<table class="table product-overview_commande">
							<thead>
								<tr>
									<th>Date</th>
									<th>Numéro de la commande</th>
									<th style="text-align:center">Montant total</th>
									<th style="text-align:center">Statut</th>
									<th style="text-align:center">Paiement</th>
									<th style="text-align:center">Action</th>
								</tr>
							</thead>
							<tbody id="cart-tablebody_commande">
								@foreach($commandes as $commande)
								<tr>
									<td>{{ Stdfn::dateFromDB($commande->commande_date_creation) }}</td>
									<td>{{ $commande->commande_numero }}</td>
									<td width="150" align="center" class="font-weight-900">{{ $commande->commande_montant_total }} FCFA</td>
									<td width="150" align="center">{{ $commande->commande_statut }}</td>
									<td width="150" align="center">{{ $commande->commande_statut_paiement }}</td>
									<td width="150" align="center"><a href="{{ route('DetailsCommande', $commande->commande_id) }}">Détails</a></td>
								</tr>
								@endforeach								
							</tbody>
						</table>
					</div>

				  </div>
				</div>
			  </div>
			</div>
		</div>
	</section>		


@endsection