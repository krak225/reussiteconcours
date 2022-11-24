@extends('layouts.app')

@section('content')

	<script src="{{ asset('js/aes.js') }}"></script>
	<!--script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script-->
	
	<script src="https://cdn.cinetpay.com/seamless/main.js"></script>
    <style>

        .sdk {
            display: block;
            position: absolute;
            background-position: center;
            text-align: center;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
    <script>
        function checkout() {
			// alert(apikey);
			CinetPay.setConfig({
                apikey: apikey,
                site_id: '391516',
                notify_url: 'http://reussiteconcours.com/notify',
                mode: 'PRODUCTION'
            });
			
            CinetPay.getCheckout({
                transaction_id: Math.floor(Math.random() * 100000000).toString(), // YOUR TRANSACTION ID
                amount: {{ $commande->commande_montant_total }},
                currency: 'XOF',
                channels: 'ALL',
                description: "Commande de {{ $commande->commande_nombre_article }} livre(s)",   
                 //Fournir ces variables pour le paiements par carte bancaire
                customer_name:"{{Auth::user()->nom }}",//Le nom du client
                customer_surname:"{{Auth::user()->prenoms }}",//Le prenom du client
                customer_email: "{{Auth::user()->email }}",//l'email du client
                customer_phone_number: "{{Auth::user()->telephone }}",//l'email du client
                customer_address : "CI",//addresse du client
                customer_city: "CI",// La ville du client
                customer_country : "CI",// le code ISO du pays
                customer_state : "CI",// le code ISO l'état
                customer_zip_code : "00225", // code postal

            });
            CinetPay.waitResponse(function(data) {
                if (data.status == "REFUSED") {
                    if (alert("Votre paiement a échoué")) {
                        window.location.reload();
                    }
                } else if (data.status == "ACCEPTED") {
                    if (alert("Votre paiement a été effectué avec succès")) {
                        window.location.reload();
                    }
                }
            });
            CinetPay.onError(function(data) {
                console.log(data);
            });
			
			
        }
    </script>
	
	<!---page Title --->
	<section class="bg-img pt-150 pb-20" data-overlay="7" style="background-image: url(../images/front-end-img/background/bg-8.jpg);">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="text-center">						
						<h2 class="page-title text-white">Paiement</h2>
						<ol class="breadcrumb bg-transparent justify-content-center">
							<li class="breadcrumb-item"><a href="#" class="text-white-50"><i class="mdi mdi-home-outline"></i></a></li>
							<li class="breadcrumb-item text-white active" aria-current="page">Paiement</li>
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
					<h4 class="box-title"><strong>DETAILS DE LA COMMANDE N° <b>{{ $commande->commande_numero }}</b> ({{ $commande->commande_nombre_article }} livres)</strong></h4>
				  </div>

				  <div class="box-body">
					<div class="table-responsive">
						<table class="table product-overview_commande">
							<thead>
								<tr>
									<th>Image</th>
									<th>Informations </th>
									<th style="text-align:center">Prix</th>
								</tr>
							</thead>
							<tbody id="cart-tablebody_commande">
								@foreach($livres_commandes as $livre)
								<tr>
									<td><img src="{{ asset('images/livres/couvertures/'.$livre->livre_couverture) }}" alt="" width="80"></td>
									<td>
										<h5>{{ $livre->livre_nom }}</h5>
										<p>{{ $livre->livre_description }}</p>
									</td>
									<td width="100" align="center" class="font-weight-900">{{ $livre->livre_prix }} FCFA</td>
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
			  <div class="col-12 col-lg-6">
				<div class="box">
				  <div class="box-header bg-info">
					<h4 class="box-title"><strong>Montant à payer</strong></h4>
				  </div>
				  <div class="box-body py-0">
					<div class="table-responsive">
						<table class="table simple mb-0">
							<tbody>
								<tr>
									<td>Total</td>
									<td class="text-right font-weight-700 subtotal_commande">{{ $commande->commande_montant_total }} FCFA</td>
								</tr>
								<tr>
									<td>Réduction</td>
									<td class="text-right font-weight-700"><span class="text-danger mr-15">0%</span>0 FCFA</td>
								</tr>
								<tr>
									<th class="bt-1">Net à Payer</th>
									<th class="bt-1 text-right font-weight-900 font-size-18 subtotal_commande">{{ $commande->commande_montant_total }} FCFA</th>
								</tr>
							</tbody>
						</table>
					</div>
				  </div>
				  @if($commande->commande_statut_paiement == "IMPAYE")
				  <div class="box-footer">	
					<form method="post" action="{{route('initPaiementCinetPay')}}">
						{!! csrf_field() !!}
						<input type="hidden" name="commande_id" value="{{$commande->commande_id}}"/>
						<button type="button" onclick="checkout()" class="btn btn-primary"><i class="fa fa-cc-paypal"></i> Payer par Mobile Money</button>
					</form>
				  </div>
				  @endif
				</div> 
			  </div>
			</div>
		</div>
	</section>		


@endsection