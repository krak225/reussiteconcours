<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class DetailCommande extends Model
{
    //
	protected $table = 'detail_commande';
	protected $primaryKey = 'detail_commande_id';
	public $timestamps = false;
	
	
}
