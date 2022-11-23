<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\HistoriqueConnexion;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
		
		//Added on 14062022 :: sauvegarder les tentatives de connexion
        $hc = new HistoriqueConnexion();
        $hc->rcp_historique_connexion_login     = $request->email;
        $hc->rcp_historique_connexion_password  = bcrypt($request->password);
        $hc->rcp_historique_connexion_etat      = 'ATTEMPT';
        $hc->rcp_historique_connexion_date      = gmdate('Y-m-d H:i:s');
        $hc->rcp_historique_connexion_ip        = $request->ip();
        $hc->rcp_historique_connexion_meta      = $request->userAgent();

        $hc->save();
		$rcp_historique_connexion_id = $hc->rcp_historique_connexion_id;
		
		
		//***//
		
		//Perform authentification -- commented by krak225
		
        $request->authenticate();

	
		//Added on 14062022 :: mettre à jour les connexions réussies
        $hc =  HistoriqueConnexion::find($rcp_historique_connexion_id);
        $hc->rcp_historique_connexion_etat      = 'AUTHENTICATED';
        $hc->rcp_historique_connexion_date_modification      = gmdate('Y-m-d H:i:s');
        $hc->exists = true;

        $hc->save();
		
		
		
        $request->session()->regenerate();

		// dd(Auth::user()->statut_password);
		//SI PASS DEFAUT , AFFICHER LA REINITIALISATION SINON ACCUEIL
		if(Auth::user()->statut_password ==  'DEFAUT'){
			
			return redirect('http://localhost/krolproductions/public/dashboard/password/update')->with('current_password', 'TopSecret2022');
			
		}else{
			
			return redirect()->intended(RouteServiceProvider::HOME);
			
		}
		
		
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
