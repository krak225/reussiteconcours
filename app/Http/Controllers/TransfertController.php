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


class TransfertController extends Controller
{
	
	
    public function __construct()
    {
        $this->middleware('auth');
    }
	
	
	public function getAccessToken()
    {
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://client.cinetpay.com/v1/auth/login',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS => 'apikey=2782059835fd0aabd4be567.60280545&password=Bvr!d%402022%40',
		  CURLOPT_HTTPHEADER => array(
			'Content-Type: application/x-www-form-urlencoded'
		  ),
		));

		$response = curl_exec($curl);
		
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
		  echo $err;
		  return null;
		  //throw new Exception("Error :" . $err);
		} 
		else{
			
			$result = json_decode($response,true);
			
			// dd($result);
			
			$code = $result['code'];
			
			if($code == 0){
				
				$token = $result['data']['token'];

				return $token;
				
			}else{
				return null;
			}
			
		}
	
	}
	
	
	//
	public function initTransfertCinetPay(Request $request)
    {
		
		$token = $this->getAccessToken();
		
		//APPELER L'API DE CINETPAY
		if(!empty($token)){
			
			$transaction_id 	= Stdfn::guidv4();
		
			$ENDPOINT 			= 'https://client.cinetpay.com/v1/transfer/money/send/contact';
			$NOTIFY_URL	= 'https://reussiteconcours.com/notify';
			
			$curl = curl_init();
			
			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://client.cinetpay.com/v1/auth/login',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS => "client_transaction_id=$transaction_id&amount=100&prefix=225&phone=0504783689&notify_url=$NOTIFY_URL",
			  CURLOPT_HTTPHEADER => array(
				'Authorization: Bearer '.$token,
				'Content-Type: application/x-www-form-urlencoded'
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
			
			dd($reponse_json);
			
			
			
		}else{
			return back()->with('warning', 'ACCÈS NON AUTORISÉ');
		}
		
    }
	
}
