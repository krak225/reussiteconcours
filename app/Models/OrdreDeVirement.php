<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class OrdreDeVirement extends Model
{
    //
	protected $table = 'ordredevirement';
	protected $primaryKey = 'ordredevirement_id';
	public $timestamps = false;
	
	
	public function virements(){
		return $this->hasMany(Virement::class, 'ordredevirement_id');	
	}
	
	
}
