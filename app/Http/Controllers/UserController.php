<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\UserFormRequest;
use App\Http\Requests\UpdatePasswordFormRequest;
use App\Models\User;
use App\Models\Bureau;
use Hash;


class UserController extends Controller
{
    //
	public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('admin');
		
    }
	
	public function index(){
		
		
	}
	
	
	public function profile(){
		
		$user = User::join('tb_profil','tb_users.profil_id','tb_profil.profil_id')
					->join('tb_service','tb_users.service_id','tb_service.service_id')
					->join('tb_direction','tb_service.direction_id','tb_direction.direction_id')
					->where('id',Auth::user()->id)
					->first();
		
		// dd($user);
		
		return view('profile',[
			'user'=>$user
		]);
		
	}
	
	
	
	
	public function update_password(){
		
		return view('auth/passwords/update');

	}
	
	
	
	
	public function UpdatePassword(UpdatePasswordFormRequest $request){
		
        $user  = Auth::user();
		
		if (Hash::check($request->current_password, Auth::user()->password)){	
			$user->password = Hash::make($request->new_password);
			$user->statut_password = 'PERSONNEL';
		
			$user->save();
		
			return \Redirect::route('updatePassword')
				->with('message', "VOTRE MOT DE PASSE A ÉTÉ MIS À JOUR");

		}else{
			
			return \Redirect::route('updatePassword')
				->with('authFailed', "MOT DE PASSE ACTUEL INCORRECTE");

		}
					
	}
	
	
	
	
	public function update_photo(){
		
		return view('update_photo');

	}
	
	
	public function UpdatePhoto(Request $request){
		
		$image = $request->file('file');
        $avatarName = 'ph'.Auth::user()->id.'_'.$image->getClientOriginalName();
        $image->move(public_path('images'),$avatarName);
		
		$user = User::find(Auth::user()->id);
		
		$user->photo = $avatarName;
		$user->exists = true;
		$user->save();
		
		return $avatarName;
	

	}
	
	
	
	public function uploadImage(Request $request){
		
		$image = $request->image;


		list($type, $image) = explode(';', $image);

		list(, $image)      = explode(',', $image);

		$image = base64_decode($image);

		$image_name= time().'.png';

		$path = public_path('images/'.$image_name);


		file_put_contents($path, $image);
	
		return 1;

	}
	
	public function upload_image(Request $request)
    {

        $folderPath = public_path('images/');


        $image_parts = explode(";base64,", $request->image);

        $image_type_aux = explode("image/", $image_parts[0]);

        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);

		$avatarName=Auth::user()->id . '.png';
		
        $file = $folderPath . $avatarName;

        file_put_contents($file, $image_base64);
		
		
		$user = User::find(Auth::user()->id);
		
		$user->photo = $avatarName;
		$user->exists = true;
		$user->save();
		
		return 1;



		return 1;

    }

	
	
}
