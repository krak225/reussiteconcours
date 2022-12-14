<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\CheckoutSession;
use App\Models\IPN;
use App\Models\Commande;
use App\Models\DetailCommande;
use Stdfn;


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
	
	
	//Check transaction status
	public function getTransactionStatus($transaction_id, $site_id)
    {
		
		$API_KEY 			= '2782059835fd0aabd4be567.60280545';
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
		// die("TEST POUR VOIR SI LES NOTIFICATIONS ARRIVENT");
		//TEST POUR VOIR SI LES NOTIFICATIONS ARRIVENT
		$ipn = new IPN();
		$ipn->ipn_data = 'Notify Events '.json_encode(['cpm_trans_id'=>$request->cpm_trans_id, 'cpm_site_id'=>$request->cpm_site_id, 'remote_addr'=>$_SERVER['REMOTE_ADDR']]);
		$ipn->ipn_date = gmdate('Y-m-d H:i:s');
		$ipn->save();
		
		$API_KEY 			= '2782059835fd0aabd4be567.60280545';
		$SITE_ID 			= '391516';
		
		//
		// if(isset($_POST['cpm_trans_id'])) {
		if(isset($request->cpm_trans_id)) {
		  
			try {
			
				// require_once __DIR__ . '/../src/new-guichet.php';
				// require_once __DIR__ . '/../commande.php';
				// require_once __DIR__ . '/../marchand.php';

				//Création d'un fichier log pour s'assurer que les éléments sont bien exécuté
				// $log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
				// "TransId:".$_POST['cpm_trans_id'].PHP_EOL.
				// "SiteId: ".$_POST['cpm_site_id'].PHP_EOL.
				// "-------------------------".PHP_EOL;
				//Save string to log, use FILE_APPEND to append.
				// $fp = fopen('log_'.gmdate("Y-m-d H:i:s").'.log', 'a+');
				// fputs($fp, $log);
				// fclose($fp);
				
				//La classe commande correspond à votre colonne qui gère les transactions dans votre base de données
				
				// Initialisation de CinetPay et Identification du paiement
				// $id_transaction = $_POST['cpm_trans_id'];
				$id_transaction = $request->cpm_trans_id;
				// apiKey
				$apikey = $API_KEY;


				// siteId
				// $site_id = $_POST['cpm_site_id'];
				$site_id = $request->cpm_site_id;


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
					
					// Stdfn::debug($transationData);
					
					//Save string to log, use FILE_APPEND to append.
					// $fp = fopen('log_transationData'.gmdate("Y-m-d H:i:s").'.log', 'a+');
					// fputs($fp, json_encode($transationData));
					// fclose($fp);
					
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
					// $fp = fopen('log_'.gmdate("Y-m-d H:i:s").'.log', 'a+');
					// fputs($fp, json_encode($log));
					// fclose($fp);
					
					// Stdfn::debug($transationData);
					// Stdfn::debug($message);
					
					// On verifie que le montant payé chez CinetPay correspond à notre montant en base de données pour cette transaction
					if ($code == '00' && $amount == $checkout_session->amount) {
					// if ($amount == $checkout_session->amount) { // pour test
						// correct, on delivre le service
						$output = 'Felicitation, votre paiement a été effectué avec succès';
						echo $output;
						
						//mettre à jour la commande pour autoriser le téléchargement des livres acheté
						$commande = Commande::find($checkout_session->commande_id);
						$commande->commande_statut_paiement = 'PAYE';
						$commande->exists = true;
						$commande->save();
						
						$detail_commande = DetailCommande::find($checkout_session->commande_id);
						$detail_commande->detail_commande_statut_telechargement = 'AUTORISE';
						$detail_commande->exists = true;
						$detail_commande->save();
						
						
						
						//
						$checkout_session->checkout_session_statut_traitement = 'TRAITE';//désactiver pour test
						$checkout_session->checkout_session_commentaire = $output;
						
						//Save string to log, use FILE_APPEND to append.
						// $fp = fopen('log_on_success'.gmdate("Y-m-d H:i:s").'.log', 'a+');
						// fputs($fp, $output);
						// fclose($fp);
						
						$user = User::find($checkout_session->user_id);
						// Stdfn::debug($user);
						
						//Added on 10092022::send notification mail
						// Email data
						// $email_data = array(
							// 'amount' => $amount,
							// 'currency' => $currency,
							// 'transaction_id' => $id_transaction,
							// 'transaction_date' => gmdate("Y-m-d H:i:s"),
							// 'nom' => $metadata,
							// 'prenoms' => $metadata,
							// 'email' => $checkout_session->user()->email,
						// );
						
						
						//Envoie des paramètres du mail
						/*Mail::send('emails.recu_paiement', $email_data, function ($message) use ($email_data){
						$message->to($email_data['email'] ,$email_data['nom'] ,$email_data['prenoms'])
							->subject('Reçu de paiement pour formation à UTECHNOPOLE')
							->from('noreply@utechnopole.com' ,'UTECHNOPOLE');
						});*/
						
						
						
					} else {
						// transaction n'est pas valide
						// $output = 'Echec, votre paiement a échoué pour cause : ' .$message;
						$output = 'Paiement non effectué : ' .$message;
						echo $output;
						
						$checkout_session->checkout_session_commentaire = $status;
						
						//Save string to log, use FILE_APPEND to append.
						// $fp = fopen('log_on_failed'.gmdate("Y-m-d H:i:s").'.log', 'a+');
						// fputs($fp, $output);
						// fclose($fp);
						
						
					}
					// mise à jour des transactions dans la base de donnée
					/*  $commande->update(); */
					
					$checkout_session->checkout_session_date_traitement = gmdate('Y-m-d H:i:s');
					$checkout_session->save();
					
					
				}else{
					$output = 'Transaction innexisatante ou déjà traitée';
					
					echo $output;
					
					// file_put_contents('./log_transaction_not_found'.gmdate("Y-m-d H:i:s").'.log', $output, FILE_APPEND);	
				}
				
			} catch (Exception $e) {
				
				echo "Erreur :" . $e->getMessage();
				
				$output = "Erreur";
				
				//Save string to log, use FILE_APPEND to append.
				// $fp = fopen('log_on_exception'.gmdate("Y-m-d H:i:s").'.log', 'a+');
				// fputs($fp, $output);
				// fclose($fp);
			}
			
		} else {
			// direct acces on IPN
			echo "cpm_trans_id non fourni";
			
			$log = "cpm_trans_id non fourni";
			// $fp = fopen('log_'.gmdate("Y-m-d H:i:s").'.log', 'w+');
			// fputs($fp, $output);
			// fclose($fp);
			
		}
		
    }
	
	
}
