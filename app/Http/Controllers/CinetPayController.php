<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\CheckoutSession;
use App\Models\IPN;
use App\Models\Commande;
use Stdfn;


class CinetPayController extends Controller
{
	
	
    public function __construct()
    {
        $this->middleware('auth');
    }
	
	
	//Call via cURL this endpoint /requesttopay
	public function initPaiementCinetPay(Request $request)
    {
		
		$commande_id 		= $request->commande_id;
		
		$commande = Commande::where(['commande_id'=>$commande_id])->first();
		
		//APPELER L'API DE CINETPAY
		if(!empty($commande)){
			
			$transaction_id 	= Stdfn::guidv4();
		
			$ENDPOINT 			= 'https://api-checkout.cinetpay.com/v2/payment';
			$SITE_ID 			= '391516';
			$API_KEY 			= '2782059835fd0aabd4be567.60280545';
			$RETURN_URL	= 'http://reussiteconcours.com/callback';
			$NOTIFY_URL	= 'http://reussiteconcours.com/callback';
			
			
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => $ENDPOINT,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>'{
				"amount":"'.$commande->commande_montant_total.'",
				"currency":"XOF",
				"apikey":"'.$API_KEY.'",
				"site_id":"'.$SITE_ID.'",
				"transaction_id":"'.$transaction_id.'",
				"description":"'.$commande->commande_numero.'",
				"return_url":"'.$RETURN_URL.'",
				"notify_url":"'.$NOTIFY_URL.'",
				"metadata":"User-'.Auth::user()->id.'",
				"customer_id":"'.Auth::user()->id.'",
				"customer_name":"'.Auth::user()->nom.'",
				"customer_surname":"'.Auth::user()->prenoms.'",
				"channels":"MOBILE_MONEY",
				"invoice_data":{"commande_numero":"'.$commande->commande_numero.'","commande_nombre_article":"'.$commande->commande_numero.'"},
			  }',
			  CURLOPT_HTTPHEADER => array(
				// 'Content-Type: application/json',
			  ),
			));	
			
			$response 			= curl_exec($curl);
			$err 			  	= curl_error($curl);
			$curl_status_code 	= curl_getinfo($curl, CURLINFO_HTTP_CODE);
				
			curl_close($curl);
				
			if ($err) {
			  echo "cURL Error #:" . $err;
			  dd($err);
			} else {
				
				$reponse_json = json_decode($response);
				dd($reponse_json);
			}
			
			
			//Si http response code 202 : accepted
			if($curl_status_code == 202){
				
				
				
				/*
				//save data in session 
				session(['x_reference_id'=> $x_reference_id, 'montant_saisi'=>$montant_saisi, 'numero_mobile_money'=>$numero_mobile_money]);
				// session('montant_saisi', $montant_saisi);
				// session('numero_mobile_money', $numero_mobile_money);
				
				
				//Save checkout data
				//utiliser la meme table de wave
				$wave_checkout_sessionwave_checkout_session 													= new CheckoutSession();
				$wave_checkout_session->operateur_mobile_money_id 						= 2;
				$wave_checkout_session->checkout_session_nom_operateur 					= 'CINETPAY';
				$wave_checkout_session->user_id 										= Auth::user()->id;
				$wave_checkout_session->declaration_id 									= $declaration_id;
				$wave_checkout_session->numero_mobile_money_initiation 					= $numero_mobile_money;
				$wave_checkout_session->wave_checkout_session_code_unique_initiation 	= $x_reference_id;
				$wave_checkout_session->mtn_x_reference_id 								= $x_reference_id;
				$wave_checkout_session->amount 											= $montant_saisi;
				$wave_checkout_session->mtn_curl_status_code 							= $curl_status_code;
				$wave_checkout_session->wave_checkout_session_date_creation 			= gmdate('Y-m-d H:i:s');
				
				$wave_checkout_session->save();
				*/
				
				# REDIRIGER POUR ATTENDRE LA CONFIRMATION DU PAIEMENT, ET L'INVITER À COMPOSER *133# POUR VALIDER LE PAIEMENT';
				
				return redirect()->route('PaiementAConfirmer');
				
				
			}else{
				
				return back()->with('warning','PAIEMENT MTN NON ABOUTI, VEUILLEZ REESSAYER SVP !');
				
			}	
			
			
		}else{
			return back()->with('warning', 'Commande introuvable');
		}
		
    }
	
	
	public function PaiementAConfirmer(Request $request)
    {
		
		$x_reference_id = session('x_reference_id');
		
		$montant_saisi  = session('montant_saisi');
		$numero_mobile_money  = session('numero_mobile_money');
		
		dd($x_reference_id);
		
		//si pas encore approuvé, vérifier sur le serveur
		if(!empty($x_reference_id)){
			
			$this->CheckTransactionStatus($x_reference_id);
			
		}
		
		return view('declaration.paiement_mtn_a_confirmer', ['x_reference_id'=>$x_reference_id, 'montant_saisi'=>$montant_saisi]);
		
    }
	
	
	//Check transaction status
	public function CheckTransactionStatus($x_reference_id)
    {
		
		
		
	}
	
	
	public function MTNEvents(Request $request)
    {
		
		//TEST POUR VOIR SI LES NOTIFICATIONS ARRIVENT
		$ipn = new IPN();
		$ipn->ipn_data = 'MTNEvents ';
		$ipn->ipn_date = gmdate('Y-m-d H:i:s');
		$ipn->save();
		
    }
	
	
	public function MTNSuccess(Request $request)
    {
		
		
    }
	
	public function MTNError(Request $request)
    {
		dd('MTNError');
    }
	
	
}
