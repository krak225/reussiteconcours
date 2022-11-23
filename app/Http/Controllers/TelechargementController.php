<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Livre;

class TelechargementController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
	
	
    public function telechargements()
    {
		
		$livres_achetes = Livre::join('detail_commande','detail_commande.livre_id','livre.livre_id')
								->join('commande','commande.commande_id','detail_commande.commande_id')
								->where(['commande.user_id'=>Auth::user()->id, 'commande_statut_paiement'=>'PAYE'])
								->get();
								
		
        return view('shop.telechargements', ['livres_achetes'=>$livres_achetes]);
		
	}
	
	
    public function telecharger($id)
    {
		
		if(is_numeric($id)){
			
			$livre = Livre::find($id);
			
			if(!empty($livre)){
					
				$content 	= base64_decode($livre->courrier_fichier_contenu);
				$mimetype 	= $livre->courrier_fichier_mimetype;
				$filename 	= $livre->courrier_fichier_nom;
				
				$headers = [
					'Content-type'        => 'application/pdf',
					'Content-Disposition' => 'attachment; filename="'.$filename.'"',
				];
				
				
				//download image
				return \Response::make($content, 200, $headers);
				
				
				
			}else{
				
				return back()->with('warning','FICHIER INTROUVABLE');
				
			}
			
		}else{
			
			return back()->with('warning','FICHIER INTROUVABLE');
			
		}
		
    }
	
	
	
}
