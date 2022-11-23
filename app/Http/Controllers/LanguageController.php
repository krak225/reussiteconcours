<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use session;

use Auth;

use App;

use App\Models\User;


class LanguageController  extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
		
    }

	
	public function language(String $locale)
    {
		
		$conversion = [
		  'fr' => 'fr_FR',
		  'en' => 'en_US',
		];
		
		// $locale = $conversion[$locale];
		
		session(['locale' => $locale]);
		
		App::setLocale($locale);
	
		//dd(App::getLocale());

        return back();
		
		
    }
	
	
	
	
}
