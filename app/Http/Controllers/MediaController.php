<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\CourrierFichier;
use App\Models\TacheFichier;
use App\Models\Fichier;
use finfo;

class MediaController extends Controller
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
	

    public function telecharger_livre($id)
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
