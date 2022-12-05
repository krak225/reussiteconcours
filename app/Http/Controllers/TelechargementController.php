<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Livre;
use App\Models\DetailCommande;

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
								->where(['commande.user_id'=>Auth::user()->id, 'commande_statut_paiement'=>'PAYE', 'detail_commande_statut_telechargement'=>'AUTORISE'])
								->get();
								
		
        return view('shop.telechargements', ['livres_achetes'=>$livres_achetes]);
		
	}
	
	
    public function telecharger($id)
    {
		
		if(is_numeric($id)){
			
			$livre = Livre::join('detail_commande','detail_commande.livre_id','livre.livre_id')
								->join('commande','commande.commande_id','detail_commande.commande_id')
								->where(['livre.livre_id'=>$id, 'commande.user_id'=>Auth::user()->id, 'commande_statut_paiement'=>'PAYE', 'detail_commande_statut_telechargement'=>'AUTORISE'])
								->first();
			
			// dd($livre);
			
			if(!empty($livre)){
				
				$filename_to_download = $livre->livre_fichier_complet;
				$filename_downloaded  = $livre->livre_nom.'.pdf';
				
				/*//SI LE FICHIER EST ENREGISTRÉ EN BINAIRE DANS LA BASE DE DONNÉES
				$content 	= base64_decode($livre->livre_contenu);
				
				
				$headers = [
					'Content-type'        => 'application/pdf',
					'Content-Disposition' => 'attachment; filename="'.$filename_downloaded.'"',
				];
				
				
				//download file
				return \Response::make($content, 200, $headers);
				*/
				
				
				//SI LE FICHIER EST DANS UN REPERTOIRE DU SITE
				$chemin = 'protected/livres/pdf'.sha1('pdf').'/'  . $filename_to_download;
				
				if(file_exists($chemin) && strpos($filename_to_download, '/') === FALSE && strpos($filename_to_download, '.') !== 0)
				{
					
					//incrémenter le compteur de téléchargement
					$detail_commande = DetailCommande::find($livre->detail_commande_id);
					$detail_commande->increment('detail_commande_nombre_telechargement');
					
					header('Content-Description: File Transfer');
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename='. basename($filename_downloaded));
					header('Content-Transfer-Encoding: binary');
					header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
					header('Content-Length: ' . filesize($chemin));
					readfile($chemin);
					// exit; 
					
					//FICHIER TÉLÉCHARGÉ AVEC SUCCÈS
					
				}else{
					
					return back()->with('warning', 'ERREUR LORS DU TELECHARGEMENT');
				  
				}
				
			}else{
				
				return back()->with('warning','FICHIER INTROUVABLE');
				
			}
			
		}else{
			
			return back()->with('warning','FICHIER INTROUVABLE');
			
		}
		
    }
	
	
	function download($dossier_base, $fichier){
		
		$chemin = $dossier_base . $fichier;
		if(file_exists($chemin) && strpos($fichier, '/') === FALSE && strpos($fichier, '.') !== 0)
		{
			
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			// header('Content-Disposition: attachment; filename='. basename($chemin));
			header('Content-Disposition: attachment; filename='.'livre.pdf');
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header('Content-Length: ' . filesize($chemin));
			readfile($chemin);
			// exit; 
			
			// return back()->with('message', 'FICHIER TÉLÉCHARGÉ AVEC SUCCÈS !');
			
		}else{
			die('ERREUR LORS DU TELECHARGEMENT');
			return back()->with('warning', 'ERREUR LORS DU TELECHARGEMENT');
		  
		}
		
	}
	
	
}
