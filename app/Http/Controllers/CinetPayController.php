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
			$RETURN_URL	= 'https://reussiteconcours.com/retour';
			$NOTIFY_URL	= 'https://reussiteconcours.com/notify';
			
			
			$params = array(
				"transaction_id"=>$transaction_id,
				"amount"=>$commande->commande_montant_total,
				"currency"=>"XOF", //Auth::user()->pays_bases->devise,
				"apikey"=>$API_KEY,
				"site_id"=>$SITE_ID,
				"description"=>'Paiement de la commande N° '.$commande->commande_numero,
				"return_url"=>$RETURN_URL,
				"notify_url"=>$NOTIFY_URL,
				"metadata"=>'cmd_'.$commande_id."_user_".Auth::user()->id,
				"customer_id"=>Auth::user()->id,
				"customer_name"=>Auth::user()->nom,
				"customer_surname"=>Auth::user()->prenoms,
				"customer_email"=>Auth::user()->email,
				// "customer_phone_number"=>Auth::user()->pays_bases->indicatif.Auth::user()->telephone1,
				// "customer_address"=>Auth::user()->adresse,
				// "customer_city"=>Auth::user()->ville,
				// "customer_country"=>Auth::user()->pays_bases->code2,
				// "customer_state"=>Auth::user()->pays_bases->code2,
				// "customer_zip_code"=>Auth::user()->pays_bases->code_postal,
				"channels"=>"ALL",
			);
		
			// print '<pre>';print_r($params);print '</pre>';
			// dd();
			
			$curl = curl_init();
			
			curl_setopt_array($curl, array(
			  CURLOPT_URL => $ENDPOINT,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_SSL_VERIFYHOST => 0,
			  CURLOPT_SSL_VERIFYPEER => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>json_encode($params),
			  CURLOPT_HTTPHEADER => array(
				'content-type:application/json'
			  ),
			));
			
			
			$response 			= curl_exec($curl);
			$err 			  	= curl_error($curl);
			$curl_status_code 	= curl_getinfo($curl, CURLINFO_HTTP_CODE);
				
			curl_close($curl);
			
			if ($err) {
			  echo "cURL Error #:" . $err;
			} else {
				$reponse_json = json_decode($response);
			}
			
			// dd($reponse_json);
			
			$code = $reponse_json->code;
			$message = $reponse_json->message;
			$description = $reponse_json->description;
			$api_response_id = $reponse_json->api_response_id;
			
			//Si http response code 202 : accepted
			if($code == 201){
				
				$payment_url = $reponse_json->data->payment_url;
				$payment_token = $reponse_json->data->payment_token;
				
				//save data in session 
				session(['transaction_id'=> $transaction_id, 'montant'=>$commande->commande_montant_total]);
				
				//Save checkout data
				$checkout_session 									= new CheckoutSession();
				$checkout_session->transaction_id 					= $transaction_id;
				$checkout_session->api_response_id 					= $api_response_id;
				$checkout_session->checkout_session_nom_operateur 	= 'CINETPAY';
				$checkout_session->user_id 							= Auth::user()->id;
				$checkout_session->commande_id 						= $commande_id;
				$checkout_session->payment_token 					= $payment_token;
				$checkout_session->payment_url 						= $payment_url;
				$checkout_session->amount 							= $commande->commande_montant_total;
				$checkout_session->curl_status_code 				= $code;
				$checkout_session->payment_status 					= '';
				$checkout_session->checkout_session_date_creation 	= gmdate('Y-m-d H:i:s');
				
				$checkout_session->save();
				
				
				//redirection vers l'url de paiement
				return redirect($payment_url);
				
				
			}else{
				
				// dd('warning',"ERREUR LORS DE L'INITIAION DU PAIEMENT. " . $description);
				return back()->with('warning',"ERREUR LORS DE L'INITIAION DU PAIEMENT. " . $description);
				
			}	
			
			
		}else{
			// dd('Commande introuvable');
			return back()->with('warning', 'Commande introuvable');
		}
		
    }
	
	
	public function PaiementAConfirmer(Request $request)
    {
		
		$transaction_id = session('transaction_id');
		
		$montant  = session('montant');
		
		// dd($transaction_id);
		
		//si pas encore approuvé, vérifier sur le serveur
		if(!empty($transaction_id)){
			
			$this->CheckTransactionStatus($transaction_id);
			
		}
		
		return view('paiement_a_confirmer', ['transaction_id'=>$transaction_id, 'montant'=>$montant]);
		
    }
	
	
	
	//Check transaction status
	public function CheckTransactionStatus($transaction_id)
    {
		$API_KEY 			= '2782059835fd0aabd4be567.60280545';
		$SITE_ID 			= '391516';

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api-checkout.cinetpay.com/v2/payment/check',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>'{
			"transaction_id":"$transaction_id", //ENTRER VOTRE TRANSACTION ID
			"site_id": "$SITE_ID", //ENTRER VOTRE SITE ID
			"apikey" : "$API_KEY" //ENTRER VOTRE APIKEY

		}',
		  CURLOPT_HTTPHEADER => array(
			'Content-Type: application/json'
		  ),
		));

		$response = curl_exec($curl);

		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
		  echo $err;
		  //throw new Exception("Error :" . $err);
		} 
		else{
			$res = json_decode($response,true);
			
			/*{
				"code": "00",
				"message": "SUCCES",
				"data": {
					"amount": "100",
					"currency": "XOF",
					"status": "ACCEPTED",
					"payment_method": "OM",
					"description": "GFGHHG",
					"metadata": null,
					"operator_id": "MP210930.1743.C36452",
					"payment_date": "2021-09-30 17:43:30"
				},
				"api_response_id": "1633023959.8459"
			}*/

			print_r($res);
		} 
	
	}
	
	
	public function getTransactionStatus($transaction_id)
    {
		$API_KEY 			= '2782059835fd0aabd4be567.60280545';
		$SITE_ID 			= '391516';
		
		
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api-checkout.cinetpay.com/v2/payment/check',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>'{
			"transaction_id":"$transaction_id", //ENTRER VOTRE TRANSACTION ID
			"site_id": "$SITE_ID", //ENTRER VOTRE SITE ID
			"apikey" : "$API_KEY" //ENTRER VOTRE APIKEY

		}',
		  CURLOPT_HTTPHEADER => array(
			'Content-Type: application/json'
		  ),
		));

		$response = curl_exec($curl);

		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
		  echo $err;
		  //throw new Exception("Error :" . $err);
		} 
		else{
			$result = json_decode($response,true);
			
			/*{
				"code": "00",
				"message": "SUCCES",
				"data": {
					"amount": "100",
					"currency": "XOF",
					"status": "ACCEPTED",
					"payment_method": "OM",
					"description": "GFGHHG",
					"metadata": null,
					"operator_id": "MP210930.1743.C36452",
					"payment_date": "2021-09-30 17:43:30"
				},
				"api_response_id": "1633023959.8459"
			}*/

			return $result;
			
		}
	
	}
	
	
	public function retour(Request $request)
    {
		
		# RETOUR SUR LE SITE APRES CINETPAY';
		// $ipn = new IPN();
		// $ipn->ipn_data = 'retour Events ';
		// $ipn->ipn_date = gmdate('Y-m-d H:i:s');
		// $ipn->save();
		
		return redirect()->route('telechargements');
		
    }
	
	
}
