<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livre;
use App\Models\Concours;
use App\Models\Commande;
use App\Models\DetailCommande;
use DB;
use Auth;
use Session;
use Stdfn;

class CommandeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('auth');
		
    }

    public function SaveCommande()
    {
		
		$COOKIE_cartArticles = $_COOKIE["cartArticles"];
		$removebase64 = base64_decode($COOKIE_cartArticles);
		$cartArticles = json_decode($removebase64, true);
		
		if(!empty($cartArticles)){
			
			$commande = new Commande();
			$commande->user_id = Auth::user()->id;
			$commande->commande_numero = Stdfn::guidv4();
			$commande->commande_date_creation = gmdate('Y-m-d H:i:s');
			$commande->save();
			
			$montant_total = 0;
			$nombre_article = 0;
			foreach($cartArticles as $livre){
				
				$livre = (Object) $livre;
				
				$detail_commande 								= new DetailCommande();
				$detail_commande->commande_id 					= $commande->commande_id;
				$detail_commande->livre_id 						= $livre->id;
				$detail_commande->detail_commande_prix 			= $livre->price;
				$detail_commande->detail_commande_quantite 		= 1;
				$detail_commande->detail_commande_date_creation = gmdate('Y-m-d H:i:s');
				$detail_commande->save();
				
				$montant_total += $detail_commande->detail_commande_prix;
				$nombre_article ++;
				
			}
			
			$commande->commande_montant_total = $montant_total;
			$commande->commande_nombre_article = $nombre_article;
			$commande->exists = true;
			$commande->save();
			
		}
		
		//Supprimer le panier: Set the expiration date to one hour ago
		setcookie("cartArticles", "", time() - 3600);

		
		session(['commande_id' => $commande->commande_id]);
		
		dd(['commande_id' => $commande->commande_id]);
		
		return redirect()->route('checkout');
		
    }
	
	
    public function checkout(Request $request)
    {
		
		$commande_id = session('commande_id');
		
		$commande = Commande::where(['commande_id'=>$commande_id])->first();
		
		$livres_commandes = DetailCommande::join('livre','livre.livre_id','detail_commande.livre_id')->where(['commande_id'=>$commande_id])->get();
		
        return view('shop.checkout', ['commande'=>$commande, 'livres_commandes'=>$livres_commandes]);
		
    }
	
    public function initPaiementCinetPay(Request $request)
    {
		$commande_id = $request->commande_id;
		
		$commande = Commande::where(['commande_id'=>$commande_id])->first();
		
		//APPELER L'API DE CINETPAY
		if(!empty($commande)){
			
			//call cinetpay
			$commande->commande_statut_paiement = 'PAYE';
			$commande->exists = true;
			$commande->save();
			
			
			return redirect()->route('telechargements');
			
			// dd('VEUILLEZ CONFIRMER VOTRE PAIEMENT SUR VOTRE TELEPHONE');
			
		}else{
			return back()->with('warning', 'Commande introuvable');
		}
		
    }
	
	
	
}
