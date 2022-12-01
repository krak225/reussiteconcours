<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\CheckoutSession;
use App\Models\IPN;
use App\Models\Commande;
use App\Models\OrdreDeVirement;
use App\Models\Virement;
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
	public function addContact(Request $request)
    {
		
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://client.cinetpay.com/v1/transfer/contact?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIwMzM1LCJpc3MiOiJodHRwczovL2NsaWVudC5jaW5ldHBheS5jb20vdjEvYXV0aC9sb2dpbiIsImlhdCI6MTY2OTY1NjY3NCwiZXhwIjoxNjY5NjYzOTM0LCJuYmYiOjE2Njk2NTY2NzQsImp0aSI6ImdvNVFKT09NQ0c3eDNNcVAifQ.tEVkLvqdgma0lnpxu1QEscVFCGhmHIIF-0rraB72oZo',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS => 'data=%5B%7B%20%22prefix%22%3A%20%22221%22%2C%20%22phone%22%3A%20%2205047836%22%2C%20%22name%22%3A%20%22C%C3%A9dric%22%2C%20%22surname%22%3A%20%22S%22%2C%20%22email%22%3A%20%22email%40example.com%22%20%7D%5D',
		  CURLOPT_HTTPHEADER => array(
			'Content-Type: application/x-www-form-urlencoded',
			'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIwMzM1LCJpc3MiOiJodHRwczovL2NsaWVudC5jaW5ldHBheS5jb20vdjEvYXV0aC9sb2dpbiIsImlhdCI6MTY2OTY1MDg0NSwiZXhwIjoxNjY5NjU4MTA1LCJuYmYiOjE2Njk2NTA4NDUsImp0aSI6IkR1Rk5oY2gyS0Y1amVhN0cifQ.OuDczvdxm772If35VYLJL4_SJyehY3K69AXP6pGEcOw'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		echo $response;
		
    }
	
	
	//
	public function sendMoney($phone, $amount)
    {	
		
		$amount = ($amount > 100)? 100 : $amount;
		// $phone = '0504783689';
		$prefix = '225';
		
		$token = $this->getAccessToken();
		
		//
		if(!empty($token)){
			
			$transaction_id 	= Stdfn::guidv4();
		
			$ENDPOINT 			= 'https://client.cinetpay.com/v1/transfer/money/send/contact?token='.$token.'&transaction_id='.$transaction_id;
			$NOTIFY_URL			= 'https://reussiteconcours.com/notify';
			
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
				CURLOPT_POSTFIELDS => 'data=%5B%7B%22amount%22%3A%22'.$amount.'%22%2C%22phone%22%3A%22'.$phone.'%22%2C%22prefix%22%3A%22'.$prefix.'%22%2C%22notify_url%22%3A%22https%3A%2F%2Freussiteconcours.com%2Fnotify%22%7D%5D',
				CURLOPT_HTTPHEADER => array(
					'Content-Type: application/x-www-form-urlencoded',
					'Authorization: Bearer '. $token
				),
			));

			$response = curl_exec($curl);
			
			$result = json_decode($response);
			
			dd($result);
			
			if($result->code == 0){
				
				curl_close($curl);
				// echo $response;
				
				return true;
				
			}else{
				
				return false;
				
			}
			
			
		}else{
			
			return false;
			
			// return back()->with('warning', 'ACCÈS NON AUTORISÉ');
			
		}
		
    }
	
	
	public function ExecuterOrdresVirements(Request $request){
		
		$ordres = OrdreDeVirement::where(['ordredevirement_statut'=>'VALIDE'])->get();
		
		foreach($ordres as $ov){
			
			$virement = new Virement();
			$virement->ordredevirement_id 		= $ov->ordredevirement_id;
			$virement->virement_montant 		= $ov->ordredevirement_montant;
			$virement->virement_beneficiaire 	= $ov->ordredevirement_destination;
			$virement->virement_date_creation 	= gmdate('Y-m-d H:i:s');
			$virement->virement_statut 			= 'EN ATTENTE';
			
			if($this->sendMoney('0504783689', $virement->virement_montant)){
				$virement->virement_statut 			= 'EFFECTUE';
			}
			
			$virement->save();
			
		}
		
		return 'Ordres de virements exécutés avec succès !';
		
	}
	
}
