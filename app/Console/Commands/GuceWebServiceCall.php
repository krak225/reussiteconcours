<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;


//Added on 17062022 : krak225@gmail.com
use Illuminate\Http\Request;
use Auth;
use App\Models\IPN;
use App\Models\Pays;
use App\Models\Materiel;
use App\Models\Declaration;
use App\Models\DeclarationMateriel;
use Stdfn;


class GuceWebServiceCall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'GuceWebServiceCall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Récupération automatique des déclarations liquidée dans le système douanier à travers le webservice de GUCE';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
		
		$ipn = new IPN();
		$ipn->ipn_data = 'GuceWebServiceCall called as Hourly task';
		$ipn->ipn_date = gmdate('Y-m-d H:i:s');
		$ipn->save();
		
		$this->getDeclarationFromGUCE();
	  
        return Command::SUCCESS;
    }
	
	
	public function getDeclarationFromGUCE(Request $request)
    {
		
		$url = 'http://rcp.buridaci.com/xml/risk_xml_sample.xml';
		
		$context = stream_context_create( array( 'http' => array( 'follow_location' => false ) ) ); 
		$content = file_get_contents($url, false, $context); 
		
		$sxe = new \SimpleXMLElement($content);
		
		$sxe->registerXPathNamespace('com', 'http://rcp.buridaci.com');
		
		//Informations générales
		$numero_declaration 		= $sxe->xpath('//com:document_no')[0];
		$document_date 				= $sxe->xpath('//com:document_date')[0];
		$declarant_code 			= $sxe->xpath('//com:declarant_code')[0];
		$declarant_name_address		= $sxe->xpath('//com:declarant_name_address')[0];
		$company_code 				= $sxe->xpath('//com:company_code')[0];
		$other_company 				= $sxe->xpath('//com:other_company')[0];
		$bureau_dedouanement_tab 	= explode('-', $numero_declaration);
		$bureau_dedouanement 		= $bureau_dedouanement_tab[1];
		
		//Récupérer l'importateur à partir du code importateur (declarant_code ) : à vérifier
		$declarant = User::where(['code_importateur'=>$company_code])->first();
		
		//Si importateur déjà existant dans notre base, le récupérer sinon le créer 
		if(!empty($declarant)){
			
			$user_id_declarant = $declarant->id;
		
		}else{
			
			//
			$user = new User();
			$user->nom 						= $other_company;
			$user->prenoms 					= "";
			$user->societe 					= trim($request->societe);
			$user->code_importateur 		= $company_code;
			// $user->adresse_email 			= trim($email);
			$user->email 					= $company_code;
			$user->password 				= bcrypt($this->default_password);
			// $user->date_naissance 			= $request->date_naissance ;
			// $user->lieu_naissance 			= trim($request->lieu_naissance);
			$user->adresse_postale 			= $declarant_name_address;
			// $user->situation_geographique 	= trim($request->situation_geographique);
			// $user->telephone 				= trim(str_replace(' ','',$request->telephone_mobile));
			// $user->telephone_fixe 			= trim(str_replace(' ','',$request->telephone_bureau));
			// $user->pays_id 					= trim($request->pays_origine;
			// $user->nature_piece_id 			= trim($request->nature_piece);
			$user->profil_id 				= 4;//IMPORTATEUR/FABRICANT
			$user->service_id 				= 3;//autres arbitraire, juste pour pouvoir afficher son compte
			$user->type_personnel_id 		= 2;//arbitraire
			$user->type_personne_id 		= 2;//arbitraire
			$user->type_declarant_id 		= 3;//arbitraire, importateur et fabricant
			// $user->numero_piece 			= trim($request->numero_piece);
			// $user->numero_compte_contribuable = trim($request->numero_compte_contribuable);
			// $user->numero_registre_commerce = trim($request->numero_registre_commerce);

			
			$user->save();
			
			
			$user_id_declarant = $user->id;
			
		}
		
		
		//Enregistrer les informations sur la déclaration
		$declaration 								= new Declaration();
		$declaration->user_id_declarant				= $user_id_declarant;//Auth::user()->id;
		$declaration->user_id_saisie				= $user_id_declarant;//Auth::user()->id;
		$declaration->declaration_numero			= trim($numero_declaration);
		$declaration->declaration_hmac_hash			= Stdfn::myHashHmac($declaration->declaration_numero, $declaration->user_id_declarant);
		$declaration->bureau_dedouanement			= trim($bureau_dedouanement);
		$declaration->declaration_libelle			= 'Données de GUCE du ' . gmdate('Y-m-d H:i:s');
		$declaration->declaration_code_transitaire	= trim($declarant_code);
		$declaration->declaration_nom_transitaire	= trim($other_company);
		$declaration->declaration_date 				= $document_date;
		$declaration->declaration_date_creation 	= gmdate('Y-m-d H:i:s');
		
		$declaration->save();
		
		
		$declaration_id = $declaration->declaration_id;
		
		
		//Les marchandises importées
		$items = $sxe->xpath('//com:items/com:item');
		
		// echo '<table><legend><b>Déclaration N° '.$numero_declaration.'</b></legend>';
		// echo '<tr><td>Code HS</td><td>Désignation</td><td>Quantité</td><td>Valeur CAF</td></tr>';
		
		
		$i = 0;
		foreach ($items as $item) {
			
			$hs_code 			= $sxe->xpath('//com:hs_code')[$i];
			$commercial_desc 	= $sxe->xpath('//com:commercial_desc')[$i];
			$marks_and_no 		= $sxe->xpath('//com:marks_and_no')[$i];
			$poids 				= $sxe->xpath('//com:item_net_mass')[$i];
			$quantite 			= $sxe->xpath('//com:item_number')[$i];
			$valeur_caf 		= $sxe->xpath('//com:cost_insurance_freight_amount')[$i];
			
			
			// $declaration = Declaration::find($dm->declaration_id);
			$materiel 	 = Materiel::where(['materiel_code'=>$hs_code])->first();
			
			if(!empty($materiel)){
			
				$dm 											= new DeclarationMateriel();
				$dm->user_id									= 1;//Auth::user()->id;
				$dm->declaration_id								= $declaration_id;
				$dm->materiel_id								= $materiel->materiel_id;
				$dm->declaration_materiel_quantite 				= $quantite;
				$dm->declaration_materiel_poids 				= $poids;
				// $dm->declaration_materiel_capacite 				= str_replace(' ','',$request->capacite);
				// $dm->declaration_materiel_duree_enregistrement 	= str_replace(' ','',$request->duree_enregistrement);
				$dm->declaration_materiel_valeur_douane 		= $valeur_caf;
				$dm->declaration_materiel_redevance_rcp 		= $materiel->materiel_taux_rcp/100 * $dm->declaration_materiel_valeur_douane;
				
				
				$dm->declaration_materiel_date_creation 		= gmdate('Y-m-d H:i:s');
				
				
				$dm->save();
				
				
				//maj montant dans la declaration	
				$declaration->declaration_montant_redevance_rcp = $declaration->declaration_montant_redevance_rcp + $dm->declaration_materiel_redevance_rcp;
				$declaration->declaration_facture_solde 		= $declaration->declaration_montant_redevance_rcp;
				$declaration->exists = true;
				$declaration->save();
				
				
			}else{
				
				//Enregistrer dans un fichier log les erreurs d'importation
				
				dd('Code HS '. $hs_code .' non trouvé dans la liste des matériels et supports assujetis à la RCP-RRR !');
				
			}
			
			// echo '<tr><td>'.$hs_code.'</td><td>'.$marks_and_no.'</td><td>'.$quantite.'</td><td>'.$valeur_caf.'</td></tr>';
			
			$i++;
		   
		}
		
		
		// echo '</table>';
		
		echo 'DONNEES DE GUCE CI IMPORTEES AVEC SUCCES ';
		
		
    }
	
}
