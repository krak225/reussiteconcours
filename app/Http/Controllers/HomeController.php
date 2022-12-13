<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livre;
use App\Models\Concours;
use App\Models\DetailCommande;
use Auth;
use DB;
use Stdfn;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        // $this->middleware('auth');		
    }

	
    public function index()
    {
		
		$concours = Concours::where(['concours_statut'=>'VALIDE'])->get()->sortBy('id');
		$livres = Livre::where(['livre_statut'=>'VALIDE'])->get();
		
        return view('home', ['concours'=>$concours, 'livres'=>$livres]);
		
    }
	
    public function details_livre($livre_id)
    {
		
		$livre = Livre::where(['livre_id'=>$livre_id, 'livre_statut'=>'VALIDE'])->first();
		$autres_livres = Livre::where('livre_id','<>',$livre_id)->where(['livre_statut'=>'VALIDE'])->get();
		
		return !empty($livre)? view('shop.details_livre', ['livre'=>$livre, 'autres_livres'=>$autres_livres]) : redirect()->route('home');
		
    }
	
	
    public function panier()
    {
		
		// $livres = Livre::where(['livre_statut'=>'VALIDE'])->get();
		$livres = [];
		
		return view('shop.panier', ['livres'=>$livres]);
		
    }
	
}
