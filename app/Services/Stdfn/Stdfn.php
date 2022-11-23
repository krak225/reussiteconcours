<?php

namespace App\Services\Stdfn;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailer;
use App\Models\ExerciceComptable;
use App\Models\NotificationMail;
use App\Mail\MailDemandeATraiter;
use DB;
use Auth;

class Stdfn
{
	
	protected $author;
	protected const APP_STATUT_MAINTENANCE = 1;
	
	
	//indique si le site est ouvert 1 ou pas 0
	public static function getAppstatut(){
		return Self::APP_STATUT_MAINTENANCE;
	}
	
	
	public static function guidv4($data = null) {
		
		
		// Generate 16 bytes (128 bits) of random data or use the data passed into the function.
		// $data = $data ?? random_bytes(16);
		// assert(strlen($data) == 16);
		
		//personalisée
		$data = (strlen($data) == 16 )? $data : random_bytes(16) ;
		
		
		// Set version to 0100
		$data[6] = chr(ord($data[6]) & 0x0f | 0x40);
		// Set bits 6-7 to 10
		$data[8] = chr(ord($data[8]) & 0x3f | 0x80);

		// Output the 36 character UUID.
		return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
		
		
	}
	
	
		
	//Added on 01042021::cryptage de données
	private static $key1 = 'pOhC4mk38fnkeXj1OAWPEemnqgP1h+S+PMvLjE=';
	private static $key2 = 'ktKjX+qvZNt++qZIh6LtB5x+ramFa1c5f7hIFrvn5c9qacpei3r3rHUTqNhL7A0amd17Z1AfN0Z04I4HskEGKJUShIQ==';

	public static function KHLOE_CRYPT($data){

		$first_key = base64_decode(Self::$key1);
		$second_key = base64_decode(Self::$key2);   
		   
		$method = "aes-256-cbc";   
		$iv_length = openssl_cipher_iv_length($method);
		$iv = openssl_random_pseudo_bytes($iv_length);
		       
		$first_encrypted = openssl_encrypt($data,$method,$first_key, OPENSSL_RAW_DATA ,$iv);   
		$second_encrypted = hash_hmac('sha3-512', $first_encrypted, $second_key, TRUE);
		           
		$output = base64_encode($iv.$second_encrypted.$first_encrypted);   

		return $output;       

		
	}	
		

	public static function KHLOE_DECRYPT($input){

		$first_key = base64_decode(Self::$key1);
		$second_key = base64_decode(Self::$key2);           
		$mix = base64_decode($input);
		       
		$method = "aes-256-cbc";   
		$iv_length = openssl_cipher_iv_length($method);
		           
		$iv = substr($mix,0,$iv_length);
		$second_encrypted = substr($mix,$iv_length,64);
		$first_encrypted = substr($mix,$iv_length+64);
		           
		$data = openssl_decrypt($first_encrypted,$method,$first_key,OPENSSL_RAW_DATA,$iv);
		$second_encrypted_new = hash_hmac('sha3-512', $first_encrypted, $second_key, TRUE);
		   
		if (hash_equals($second_encrypted,$second_encrypted_new))
		return $data;
		   
		return false;

	}
	
	

	public static function myHashHmac($declaration_id, $user_id) {
		
		// $hmacKey    	= '30911337928580013';
		$hmacKey    	= '@kd1orol@and#';

		$merchantId 	= $user_id;
		$refno      	= $declaration_id;
		$date_systeme   = date('Y-m-d H:i:s');

		// HMAC Hex to byte
		// $secret     = hex2bin("$hmacKey");
		$secret     = $hmacKey;
		
		// die($secret);
		
		// Concat infos
		$string     = $merchantId . $date_systeme . $refno;

		// generate SIGN
		// $sign       = bin2hex(hash_hmac('sha256', $string, $secret)); 
		
		$sign       = hash_hmac('sha256', $string, $secret); 
		
		
		return $sign;
		
	}
	
	
	public static function convertToLetter($number) {
		$convert = explode('.', $number);    
		$num[17] = array('zero', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit',
						 'neuf', 'dix', 'onze', 'douze', 'treize', 'quatorze', 'quinze', 'seize');
						  
		$num[100] = array(20 => 'vingt', 30 => 'trente', 40 => 'quarante', 50 => 'cinquante',
						  60 => 'soixante', 70 => 'soixante-dix', 80 => 'quatre-vingt', 90 => 'quatre-vingt-dix');
										  
		if (isset($convert[1]) && $convert[1] != '') {
		  
		  if($convert[1][0] == 0 || strlen($convert[1]) > 1){
			$convert[1] = (int) $convert[1];    
		  }else{
			$convert[1] = (int) ($convert[1].'0');   
		  }
	
		  return self::convertToLetter($convert[0]).'$$$'.self::convertToLetter( $convert[1]);
		}
		if ($number < 0) return 'moins '.self::convertToLetter(-$number);
		if ($number < 17) {
		  return $num[17][$number];
		}
		elseif ($number < 20) {
		  return 'dix-'.self::convertToLetter($number-10);
		}
		elseif ($number < 100) {
		  if ($number%10 == 0) {
			return $num[100][$number];
		  }
		  elseif (substr($number, -1) == 1) {
			if( ((int)($number/10)*10)<70 ){
			  return self::convertToLetter((int)($number/10)*10).'-et-un';
			}
			elseif ($number == 71) {
			  return 'soixante-et-onze';
			}
			elseif ($number == 81) {
			  return 'quatre-vingt-un';
			}
			elseif ($number == 91) {
			  return 'quatre-vingt-onze';
			}
		  }
		  elseif ($number < 70) {
			return self::convertToLetter($number-$number%10).'-'.self::convertToLetter($number%10);
		  }
		  elseif ($number < 80) {
			return self::convertToLetter(60).'-'.self::convertToLetter($number%20);
		  }
		  else {
			return self::convertToLetter(80).'-'.self::convertToLetter($number%20);
		  }
		}
		elseif ($number == 100) {
		  return 'cent';
		}
		elseif ($number < 200) {
		  return self::convertToLetter(100).' '.self::convertToLetter($number%100);
		}
		elseif ($number < 1000) {
		  return self::convertToLetter((int)($number/100)).' '.self::convertToLetter(100).($number%100 > 0 ? ' '.self::convertToLetter($number%100): '');
		}
		elseif ($number == 1000){
		  return 'mille';
		}
		elseif ($number < 2000) {
		  return self::convertToLetter(1000).' '.self::convertToLetter($number%1000).' ';
		}
		elseif ($number < 1000000) {
		  return self::convertToLetter((int)($number/1000)).' '.self::convertToLetter(1000).($number%1000 > 0 ? ' '.self::convertToLetter($number%1000): '');
		}
		elseif ($number == 1000000) {
		  return '1 millions';//1 added on 05072022::rich il affichait just million
		}
		elseif ($number < 2000000) {
		  return self::convertToLetter(1000000).' '.self::convertToLetter($number%1000000);
		}
		elseif ($number < 1000000000) {
		  return self::convertToLetter((int)($number/1000000)).' '.self::convertToLetter(1000000).($number%1000000 > 0 ? ' '.self::convertToLetter($number%1000000): '');
		}
	}
	
	//Renvoi une chaine sur un nombre de caractère défini	
	public static function truncate($text, $n){
		
		$strlen = strlen($text);
		
		if ($strlen == $n) {
			
			$text = $text;
			
		}elseif($strlen > $n){
		
			$text = substr($text,0,$n);
		
		}elseif($strlen < $n){
			
			$diff = $n - $strlen;
		
			for($i = 0; $i < $diff; $i++){
				
				$text.=' ';
			
			}
			
		}
		
		return $text;
		
	}

	//pour les nombre a précéder de x zéro (0000...)
	public static function truncateN($text, $n){
		
		$strlen = strlen($text);
		
		if ($strlen == $n) {
			
			$text = $text;
			
		}elseif($strlen > $n){
		
			$text = substr($text,0,$n);
		
		}elseif($strlen < $n){
			
			$diff = $n - $strlen;
			$zero = '';
			
			for($i = 0; $i < $diff; $i++){
				
				$zero.='0';
			
			}
			
			$text = $zero.$text;
			
		}
		
		return $text;
		
	}

	
	
	
	public static function debug($chaine){
		
		print '<pre>';print_r($chaine);print '</pre>';
		
	}
					
	public static function random_color_part() {
		return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
	}

	public static function RandomColor() {
		return '#'.Stdfn::random_color_part() . Stdfn::random_color_part() . Stdfn::random_color_part();
	}
	
			
	public static function generer_id(){
		
		srand((double)microtime()*1000000); 
		$id ="ID-".strtoupper(substr(md5(uniqid(rand())),0,7)); 

		return $id;
		
	}
		
		
	//fn pour convertir les dates
	public static function dateToDB($date){
		$date = str_replace('-','/',$date);
		sscanf($date, "%2s/%2s/%4s", $jj, $mm, $aaaa);
		$dbdate= !empty($aaaa) ?$aaaa.'-'.$mm.'-'.$jj : null;
		
		return $dbdate;
	}
	
	public static function dateFromDB($date){
		$date = str_replace('/','-',$date);
		sscanf($date, "%4s-%2s-%2s", $aaaa, $mm, $jj);
		$outdate=!empty($aaaa) ? $jj.'/'.$mm.'/'.$aaaa : null;
		return $outdate;
	}
	
	public static function dateTimeFromDB($date){
		$date = str_replace('/','-',$date);
		sscanf($date, "%4s-%2s-%2s %2s:%2s:%2s", $aaaa, $mm, $jj,$hh,$ii,$ss);
		$outdate=!empty($aaaa) ? $jj.'/'.$mm.'/'.$aaaa.' à '.$hh.':'.$ii : null;
		return $outdate;
	}
	
	public static function timeFromDB($date){
		$date = str_replace('/','-',$date);
		sscanf($date, "%4s-%2s-%2s %2s:%2s:%2s", $aaaa, $mm, $jj,$hh,$ii,$ss);
		$outdate=!empty($hh) ? $hh.':'.$ii : null;
		return $outdate;
	}
	
	public static function date($date){
		$date = str_replace('/','-',$date);
		sscanf($date, "%4s-%2s-%2s %2s:%2s:%2s", $aaaa, $mm, $jj,$hh,$ii,$ss);
		$outdate=!empty($aaaa) ? $aaaa.'-'.$mm.'-'.$jj : null;
		
		
		return $outdate;
	}
	
	
	
	public static function ApiSendSMS_SMSECO($smsID,$expediteur,$destinataires){
		
		/*
		
		$wsdl = "http://www.smseco.com/api/soap/wsdl/";
		
		$server = "http://www.smseco.com/api/soap/server/";
		
		$options = array("location" =>$server, "trace"=>true, 'style'=> SOAP_DOCUMENT, 'use'=> SOAP_LITERAL);
		
		$api = new SoapClient($wsdl, $options);
		
		$smsdatas = array("login"=>"krak225@gmail.com", "password"=>"123456", "msgid"=>$smsID, "msg"=>$message, "expediteur"=>$expediteur, "datesend"=>date('Y-m-d H:i:s'), "to"=>$destinataires);
		
		$resultat = $api->Sendsms($smsdatas);
		
		*/
		
		
		//
		
		$uri = "http://www.smseco.com/api/json/sendsms/";
		
		$data = "JSON={\"compte\":{\"login\":\"krak225@gmail.com\",\"password\":\"rtechno\"},\"message\":{\"expediteur\":\"PDCI\",\"msgid\":\"15\",\"msg\":\"Juste un est\"},\"destinataires\":[{\"numero\":\"04783689\"}, {\"numero\":\"08779408\"}]}";
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL,$uri);
		
		curl_setopt($ch, CURLOPT_HTTPHEADER,array("Accept: application/json","Accept: application/json","Content-Type: application/json", "Content-Length: ". strlen($data)));
		
		curl_setopt($ch, CURLOPT_POST, true);
		
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$output = curl_exec ($ch);
		
		curl_close ($ch); // close curl handle

		
		return $output;
		
		
		
	}
	
	
	
	
	public static function ApiSendSMS($smsID,$expediteur,$destinataires,$message){
		
		$curl = curl_init();

		curl_setopt_array($curl, [
			CURLOPT_URL => 'https://portal.bulkgate.com/api/1.0/simple/promotional',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => json_encode([
				'application_id' => '1447',
				'application_token' => '9YeX9gTXrmpmABJW1KC8vwNzOOFL7ddRPHCwXyJtoHAlwNos16',
				'number' => implode(';', $destinataires),
				'text' => $message,
				'sender_id' => 'SMS'.$smsID,
				'sender_id_value' => $expediteur
			]),
			CURLOPT_HTTPHEADER => [
				'Content-Type: application/json'
			],
		]);

		$response = curl_exec($curl);

		if($error = curl_error($curl))
		{
			echo $error;
		}
		else
		{
			$response = json_decode($response);

			var_dump($response);
		}
		
		curl_close($curl);
		

		return $response;

		
	}
	
	
}