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


class CinetPay 
{
  protected $BASE_URL = null; //generer lien de paiement Pour la production

  //Variable obligatoire identifiant
/**
 * An identifier
 * @var string
 */

  public $amount = null ;
  public $apikey = null ;
  public $site_id = null;
  public $currency = 'XOF';
  public $transaction_id = null;
  public $customer_name = null;
  public $customer_surname = null;
  public $description = null;

  //Variable facultative identifiant
  public $channels = 'ALL';
  public $notify_url= null;
  public $return_url= null;

  //toute les variables 
  public $metadata = null;
  public $alternative_currency = null;
  public $customer_email = null;
  public $customer_phone_number = null;
  public $customer_address = null;
  public $customer_city = null;
  public $customer_country = null;
  public $customer_state = null;
  public $customer_zip_code = null; 

  //variables des payments check
  public $token = null;
  public $chk_payment_date = null;
  public $chk_operator_id = null;
  public $chk_payment_method = null;
  public $chk_code = null;
  public $chk_message = null;
  public $chk_api_response_id = null;
  public $chk_description = null;
  public $chk_amount = null;
  public $chk_currency = null;
  public $chk_metadata = null;
  /**
 * CinetPay constructor.
 * @param $site_id
 * @param $apikey
 * @param string $version
 * @param array $params
 */
  public function __construct($site_id, $apikey, $version = 'v2', $params = null)
  {
	$this->BASE_URL = sprintf('https://api-checkout.cinetpay.com/%s/payment',strtolower($version)); 
	$this->apikey = $apikey;
	$this->site_id = $site_id;
  }

  //generer lien de payment
  public function generatePaymentLink($param)
  {
	$this->CheckDataExist($param, "payment");
	//champs obligatoire
	$this->transaction_id = $param['transaction_id'];
	$this->amount = $param['amount'];
	$this->currency = $param['currency'];
	$this->description = $param['description'];
	//champs quasi obligatoire
	$this->customer_name = $param['customer_name'];
	$this->customer_surname = $param['customer_surname'];
	//champs facultatif
	if (!empty($param['notify_url'])) $this->notify_url = $param['notify_url'];
	if (!empty($param['return_url'])) $this->return_url = $param['return_url'];
	if (!empty($param['channels'])) $this->channels = $param['channels'];
	//exception pour le CREDIT_CARD
	if ($this->channels == "CREDIT_CARD"  )
	$this->checkDataExist($param, "paymentCard");

  if (!empty($param['alternative_currency'])) $this->alternative_currency = $param['alternative_currency'];
  if (!empty($param['customer_email']))  $this->customer_email = $param['customer_email'];
  if (!empty($param['customer_phone_number']))  $this->customer_phone_number = $param['customer_phone_number'];
  if (!empty($param['customer_address']))  $this->customer_address = $param['customer_address'];
  if (!empty($param['customer_city']))  $this->customer_city = $param['customer_city'];
  if (!empty($param['customer_country']))  $this->customer_country = $param['customer_country'];
  if (!empty($param['customer_state']))  $this->customer_state = $param['customer_state'];
  if (!empty($param['customer_zip_code']))  $this->customer_zip_code = $param['customer_zip_code'];
  if (!empty($param['metadata']))  $this->metadata = $param['metadata'];
	//soumission des donnees
	$data = $this->getData();
	
	$flux_json = $this->callCinetpayWsMethod($data, $this->BASE_URL);
	if ( $flux_json == false)
	throw new Exception("Un probleme est survenu lors de l'appel du WS !");

	$paymentUrl = json_decode($flux_json,true);

	if(is_array($paymentUrl))
	{
	  if(empty($paymentUrl['data']))
	  {
		$message = 'Une erreur est survenue, Code: ' . $paymentUrl['code'] . ', Message: ' . $paymentUrl['message'] . ', Description: ' . $paymentUrl['description'];

		throw new Exception($message);
	  }
	  
	  
	}
	
	return $paymentUrl;
  }

  //check data
  public function CheckDataExist($param, $action)// a customiser pour la function check status
  {
	if (empty($this->apikey))
	throw new Exception("Erreur: Apikey non defini");
	if (empty($this->site_id))
	throw new Exception("Erreur: Site_id non defini");
	if (empty($param['transaction_id']))
	$this->transaction_id = $this->generateTransId();

	if($action == "payment")
	{
	  if (empty($param['amount']))
	  throw new Exception("Erreur: Amount non defini");
	  if (empty($param['currency']))
	  throw new Exception("Erreur: Currency non defini");
	  if (empty($param['customer_name']))
	  throw new Exception("Erreur: Customer_name non defini");
	  if (empty($param['description']))
	  throw new Exception("Erreur: description non defini");
	  if (empty($param['customer_surname']))
	  throw new Exception("Erreur: Customer_surname non defini");
	  if (empty($param['notify_url']))
	  throw new Exception("Erreur: notify_url non defini");
	  if (empty($param['return_url']))
	  throw new Exception("Erreur: return_url non defini");
	}
	elseif ($action == "paymentCard") 
	{
	  if (empty($param['customer_email']))
	  throw new Exception("Erreur: customer_email non defini (champs requis pour le paiement par carte)");
	  if (empty($param['customer_phone_number']))
	  throw new Exception("Erreur: custom_phone_number non defini (champs requis pour le paiement par carte)");
	  if (empty($param['customer_address']))
	  throw new Exception("Erreur: Customer_address non defini (champs requis pour le paiement par carte)");
	  if (empty($param['customer_city']))
	  throw new Exception("Erreur: customer_city non defini (champs requis pour le paiement par carte)");
	  if (empty($param['customer_country']))
	  throw new Exception("Erreur: customer_country non defini (champs requis pour le paiement par carte)");
	  if (empty($param['customer_state']))
	  throw new Exception("Erreur: Customer_address non defini (champs requis pour le paiement par carte)");
	  if (empty($param['customer_zip_code']))
	  throw new Exception("Erreur: customer_zip_code non defini (champs requis pour le paiement par carte)");
	}
	
  }
  
  //send datas
  private function callCinetpayWsMethod($params, $url, $method = 'POST')
  {
	
	  if (function_exists('curl_version')) {
		 try {
			  $curl = curl_init();
			 
			  curl_setopt_array($curl, array(
				  CURLOPT_URL => $url,
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 45,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => $method,
				  CURLOPT_POSTFIELDS => json_encode($params),
				  CURLOPT_SSL_VERIFYPEER => 0,
				  CURLOPT_HTTPHEADER => array(
					  "content-type:application/json"
				  ),
			  ));
			  $response = curl_exec($curl);
			  $err = curl_error($curl);
			  curl_close($curl);
			  if ($err) {
				  throw new Exception("Error :" . $err);
			  } else {
				  return $response;
			  }
		  } catch (Exception $e) {
			  throw new Exception($e);
		  }
	  }  else {
		  throw new Exception("Vous devez activer curl ou allow_url_fopen pour utiliser CinetPay");
	  }
  }
  //getData
  public function getData()
  {
	$dataArray = array(
	  "amount"=> $this->amount,
	  "apikey"=> $this->apikey,
	  "site_id"=> $this->site_id,
	  "currency"=> $this->currency,
	  "transaction_id"=> $this->transaction_id,
	  "customer_surname"=> $this->customer_surname,
	  "customer_name"=> $this->customer_name,
	  "description"=> $this->description,
	  "notify_url"=> $this->notify_url,
	  "return_url"=> $this->return_url,
	  "channels"=> $this->channels,
	  "alternative_currency"=> $this->alternative_currency,
	  "customer_email"=> $this->customer_email,
	  "customer_phone_number"=> $this->customer_phone_number,
	  "customer_address"=> $this->customer_address,
	  "customer_city"=> $this->customer_city,
	  "customer_country"=> $this->customer_country,
	  "customer_state"=> $this->customer_state,
	  "customer_zip_code"=> $this->customer_zip_code,
	  "metadata" => $this->metadata,
	);
	return $dataArray;
  }
  //get payStatus
  public function getPayStatus($id_transaction,$site_id)
  {
	$data = (array)$this->getPayStatusArray($id_transaction,$site_id);
	
	$flux_json = $this->callCinetpayWsMethod($data, $this->BASE_URL."/check");

   
	if ( $flux_json == false)
	throw new Exception("Un probleme est survenu lors de l'appel du WS !"); 
	
	$StatusPayment = json_decode($flux_json, true);

	if(is_array($StatusPayment))
	{
	  if(empty($StatusPayment['data']))
	  {
		$message = 'Une erreur est survenue, Code: ' . $StatusPayment['code'] . ', Message: ' . $StatusPayment['message'] . ', Description: ' . $StatusPayment['description'];

		throw new Exception($message);
	  }
	  
	}
	$this->chk_payment_date = $StatusPayment['data']['payment_date'];
	$this->chk_operator_id = $StatusPayment['data']['operator_id'];
	$this->chk_payment_method = $StatusPayment['data']['payment_method'];
	$this->chk_amount = $StatusPayment['data']['amount'];
	$this->chk_currency = $StatusPayment['data']['currency'];
	$this->chk_code = $StatusPayment['code'];
	$this->chk_message = $StatusPayment['message'];
	$this->chk_api_response_id = $StatusPayment['api_response_id'];
	$this->chk_description = $StatusPayment['data']['description'];
	$this->chk_metadata = $StatusPayment['data']['metadata'];
  }
  private function getPayStatusArray($id_transaction,$site_id)
   {
	  return $dataArray = array(
		'apikey' => $this->apikey,
		'site_id' => $site_id,
		'transaction_id' => $id_transaction);

   }
  //generate transId
  /**
   * @return int
   */
  public function generateTransId()
  {
	$timestamp = time();
	$parts = explode(' ', microtime());
	$id = ($timestamp + $parts[0] - strtotime('today 00:00')) * 10;
	$id = "SDK-PHP".sprintf('%06d', $id) . mt_rand(100, 9999);

	return $id;
  }
  /**
   * @param $id
   * @return $this
   */
  public function setTransId($id)
  {
	  $this->transaction_id = $id;
	  return $this;
  }


}



//
class CinetPayCallbackController extends Controller
{
	
	
    public function __construct()
    {
        // $this->middleware('auth');
    }
	
	
	public function guidv4($data = null) {
		
		//personalisée
		$data = (strlen($data) == 16 )? $data : random_bytes(16) ;
		
		// Set version to 0100
		$data[6] = chr(ord($data[6]) & 0x0f | 0x40);
		// Set bits 6-7 to 10
		$data[8] = chr(ord($data[8]) & 0x3f | 0x80);

		// Output the 36 character UUID.
		return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
		
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
	public function CheckTransactionStatus($transaction_id, $token)
    {
		
		$API_KEY 			= '1114703932630f91ed741316.24658063';
		$SITE_ID 			= '391516';
		
		$status = '';
		$montant = '';

		$params = array(
					"transaction_id"=>$transaction_id,
					"apikey"=>$API_KEY,
					"site_id"=>$SITE_ID
				);
		

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
		  CURLOPT_POSTFIELDS =>json_encode($params),
		  CURLOPT_HTTPHEADER => array(
			'content-type:application/json'
		  ),
		));

		$response = curl_exec($curl);
		
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
		  dd('err: '.$err);
		} 
		else{
			
			$res = json_decode($response);
			
			$code = $res->code;
			$message = $res->message;
			$montant = $res->data->amount;
			$status = $res->data->status;
			
			$checkout_session = CheckoutSession::where(['payment_token'=>$token])->first();
			
			
			if(!empty($checkout_session)){
				
				if($status == 'ACCEPTED'){
					
					return view('paiement_reussie', ['status'=>$status, 'montant'=>$montant]);//pay non abouti
					
					return redirect()->route('mescommandes');
					
				}
				
			}
			
			
		} 
		
		return view('paiement_echoue', ['status'=>$status, 'montant'=>$montant]);//pay non abouti
	
	}
	
	
	//Check transaction status
	public function getTransactionStatus($transaction_id, $site_id)
    {
		
		$API_KEY 			= '1114703932630f91ed741316.24658063';
		$SITE_ID 			= $site_id;
		
		$status = '';
		$montant = '';

		$params = array(
					"transaction_id"=>$transaction_id,
					"apikey"=>$API_KEY,
					"site_id"=>$SITE_ID
				);
		

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
		  CURLOPT_POSTFIELDS =>json_encode($params),
		  CURLOPT_HTTPHEADER => array(
			'content-type:application/json'
		  ),
		));

		$response = curl_exec($curl);
		
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
		  dd('err: '.$err);
		} 
		else{
			
			$result = json_decode($response);
			
			// $code = $res->code;
			// $message = $res->message;
			// $montant = $res->data->amount;
			// $status = $res->data->status;
			
			return $result;
			
			
		}
		
	}
	
	
	public function notify(Request $request)
    {
		
		//TEST POUR VOIR SI LES NOTIFICATIONS ARRIVENT
		$ipn = new IPN();
		$ipn->ipn_data = 'Notify Events '.json_encode(['cpm_trans_id'=>$_POST['cpm_trans_id'], 'cpm_site_id'=>$_POST['cpm_site_id'], 'remote_addr'=>$_SERVER['REMOTE_ADDR']]);
		$ipn->ipn_date = gmdate('Y-m-d H:i:s');
		$ipn->save();
		
		$API_KEY 			= '1114703932630f91ed741316.24658063';
		$SITE_ID 			= '391516';
		
		//
		if(isset($_POST['cpm_trans_id'])) {
		  
			try {
			
				// require_once __DIR__ . '/../src/new-guichet.php';
				// require_once __DIR__ . '/../commande.php';
				// require_once __DIR__ . '/../marchand.php';

				//Création d'un fichier log pour s'assurer que les éléments sont bien exécuté
				$log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
				"TransId:".$_POST['cpm_trans_id'].PHP_EOL.
				"SiteId: ".$_POST['cpm_site_id'].PHP_EOL.
				"-------------------------".PHP_EOL;
				//Save string to log, use FILE_APPEND to append.
				file_put_contents('./log_'.gmdate("Y-m-d H:i:s").'.log', $log, FILE_APPEND);

				//La classe commande correspond à votre colonne qui gère les transactions dans votre base de données
				
				// Initialisation de CinetPay et Identification du paiement
				$id_transaction = $_POST['cpm_trans_id'];
				// apiKey
				$apikey = $API_KEY;


				// siteId
				$site_id = $_POST['cpm_site_id'];


				// $CinetPay = new CinetPay($site_id, $apikey);
				//On recupère le statut de la transaction dans la base de donnée
				/* $commande->set_transactionId($id_transaction);
					 //Il faut s'assurer que la transaction existe dans notre base de donnée
				 * $commande->getCommandeByTransId();
				 */

				// On verifie que la commande n'a pas encore été traité
				$checkout_session = CheckoutSession::where(['transaction_id'=>$id_transaction, 'checkout_session_statut_traitement'=>'NON TRAITE'])->first();
				
				if(!empty($checkout_session)){
					
					// Dans le cas contrait, on verifie l'état de la transaction en cas de tentative de paiement sur CinetPay
					
					// $CinetPay->getPayStatus($id_transaction, $site_id);
					$transationData = $this->getTransactionStatus($id_transaction, $site_id);	
					
					//Save string to log, use FILE_APPEND to append.
					file_put_contents('./log_transationData'.gmdate("Y-m-d H:i:s").'.log', json_encode($transationData), FILE_APPEND);
					
					$code = $transationData->code;
					$message  = $transationData->message;
					$status = $transationData->data->status;
					$amount = $transationData->data->amount;
					$currency = $transationData->data->currency;
					$metadata = $transationData->data->metadata;
					
					$checkout_session->payment_status = $status;
					
					//Something to write to txt log
					$log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.gmdate("Y-m-d H:i:s").PHP_EOL.
						"Code:".$code.PHP_EOL.
						"Message: ".$message.PHP_EOL.
						"Amount: ".$amount.PHP_EOL.
						"currency: ".$currency.PHP_EOL.
						"-------------------------".PHP_EOL;
					//Save string to log, use FILE_APPEND to append.
					file_put_contents('./log_'.gmdate("Y-m-d H:i:s").'.log', $log, FILE_APPEND);

					// On verifie que le montant payé chez CinetPay correspond à notre montant en base de données pour cette transaction
					if ($code == '00' && $amount == $checkout_session->amount) {
						// correct, on delivre le service
						$output = 'Felicitation, votre paiement a été effectué avec succès';
						echo $output;
						
						//mettre à jour la facture
						$facture = Facture::find($checkout_session->facture_id);
						$facture->facture_statut_paiement = 'PAYE';
						$facture->exists = true;
						$facture->save();
						
						//
						$checkout_session->checkout_session_statut_traitement = 'TRAITE';
						$checkout_session->checkout_session_commentaire = $output;
						
						//Save string to log, use FILE_APPEND to append.
						file_put_contents('./log_on_success'.gmdate("Y-m-d H:i:s").'.log', $output, FILE_APPEND);
						
						
						//Added on 10092022::send notification mail
						// Email data
						$email_data = array(
							'amount' => $amount,
							'currency' => $currency,
							'transaction_id' => $id_transaction,
							'transaction_date' => gmdate("Y-m-d H:i:s"),
							'nom' => $metadata,
							'prenoms' => $metadata,
							'email' => $checkout_session->user()->email,
						);
						
						//Envoie des paramètres du mail
						/*Mail::send('emails.recu_paiement', $email_data, function ($message) use ($email_data){
						$message->to($email_data['email'] ,$email_data['nom'] ,$email_data['prenoms'])
							->subject('Reçu de paiement pour formation à UTECHNOPOLE')
							->from('noreply@utechnopole.com' ,'UTECHNOPOLE');
						});*/
						
						
						
					} else {
						// transaction n'est pas valide
						$output = 'Echec, votre paiement a échoué pour cause : ' .$message;
						echo $output;
						
						$checkout_session->checkout_session_commentaire = $status;
						
						//Save string to log, use FILE_APPEND to append.
						file_put_contents('./log_on_failed'.gmdate("Y-m-d H:i:s").'.log', $output, FILE_APPEND);
						
					}
					// mise à jour des transactions dans la base de donnée
					/*  $commande->update(); */
					
					$checkout_session->checkout_session_date_traitement = gmdate('Y-m-d H:i:s');
					$checkout_session->save();
					
					
				}else{
					$output = 'Transaction innexisatante ou déjà traitée';
					
					echo $output;
					
					file_put_contents('./log_transaction_not_found'.gmdate("Y-m-d H:i:s").'.log', $output, FILE_APPEND);	
				}
				
			} catch (Exception $e) {
				
				echo "Erreur :" . $e->getMessage();
				
				$output = "Erreur";
				
				//Save string to log, use FILE_APPEND to append.
				file_put_contents('./log_on_failed'.gmdate("Y-m-d H:i:s").'.log', $output, FILE_APPEND);
				
			}
			
		} else {
			// direct acces on IPN
			echo "cpm_trans_id non fourni";
			
			$log = "cpm_trans_id non fourni";
			file_put_contents('./log_'.gmdate("Y-m-d H:i:s").'.log', $log, FILE_APPEND);
			
		}
		
    }
	
	
	public function retour(Request $request)
    {
		
		$token = $request->token;
		$transaction_id = $request->transaction_id;
		
		# REDIRIGER POUR ATTENDRE LA CONFIRMATION DU PAIEMENT, ET L'INVITER À COMPOSER *133# POUR VALIDER LE PAIEMENT';
		$ipn = new IPN();
		$ipn->ipn_data = 'retour Events '. json_encode($request);
		$ipn->ipn_date = gmdate('Y-m-d H:i:s');
		$ipn->save();
		
		return $this->CheckTransactionStatus($transaction_id, $token);
		
		// return redirect()->route('PaiementAConfirmer');
		
    }
	
	
	public function paiement_reussie(Request $request)
    {
		return 'paiement_reussie';
		return view('paiement_reussie');//pay non abouti
		
    }
	
	
	public function paiement_echoue(Request $request)
    {
		return 'paiement_echoue';
		return view('paiement_echoue');//pay non abouti
		
    }
	
	
	
}
