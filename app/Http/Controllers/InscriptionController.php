<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormRequest;
use Illuminate\Http\Request;
use Auth;
use Mail;
use Illuminate\Mail\Mailer;
use Stdfn;


class InscriptionController extends Controller
{
  
    public function __construct()
    {
        $this->middleware('guest');
    }

	////////// Inscription ///
	
	public function inscription(){
			
		return view('inscription');
		
	}
	
	
	public function SaveInscription(UserFormRequest $request)
    {
	
		$password 	= trim($request->password);
		
		$user = new User();
		$user->nom 						= trim($request->nom);
		$user->prenoms 					= trim($request->prenoms);
		$user->telephone 				= trim($request->telephone);
		$user->email 					= trim($request->email);
		$user->password 				= bcrypt(trim($password));
		
		//Sauvegarder 
		$user->save();

		
		
		//ENVOYER UN MAIL DE NOTIFICATION
		
		//Notification par Mail
		// Stdfn::SendMailNotificationDemandeur($demandeur);
		
		
		
		//le connecter 
		$email 		= $request->email;
		$password 	= $request->password;
		
		$this->signin($request, $email, $password);
		
		
		//
		return back()
				->with('message', "VOTRE COMPTE A ÉTÉ ENREGISTRÉ AVEC SUCCÈS.");
		
		
    }
	
	
	public function signin(Request $request, $email, $password)
    {
		
		if (Auth::attempt(['email' => $email, 'password' => $password, 'statut' => 'VALIDE'])) {
			
			// Authentication was successful...

            $request->session()->regenerate();
 
            return redirect()->intended('home');
			
        }
 
        return back()->withErrors([
            'email' => 'Login ou mot de passe erroné.',
        ])->onlyInput('email');
    }
	
}
