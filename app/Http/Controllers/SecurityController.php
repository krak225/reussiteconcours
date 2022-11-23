<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\RequestData;

class SecurityController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
		
    }

	
    public function SaveRoutes($data, Request $request)
    {
		
		$rd 	  					= new RequestData();
		$rd->request_url 			= $request->url();
		$rd->request_querystring 	= $data;
		// $rd->save();
		
		return redirect('home')->with('warning','PAGE INTROUVABLE');
		
		// return back()->with('warning','PAGE INTROUVABLE');
		
		// return view('php_exception');
	
    }
	
}
