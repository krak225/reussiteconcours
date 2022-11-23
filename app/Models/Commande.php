<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Commande extends Model
{
    //
	protected $table = 'commande';
	protected $primaryKey = 'commande_id';
	public $timestamps = false;
	
	
	public function livres(){
		return $this->hasMany(DetailCommande::class, 'commande_id');	
	}
	
}
