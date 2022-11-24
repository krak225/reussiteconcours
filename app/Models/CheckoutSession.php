<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class CheckoutSession extends Model
{
    //
	protected $table = 'checkout_session';
	protected $primaryKey = 'checkout_session_id';
	public $timestamps = false;
	
	
	public function user(){

        return $this->belongsTo(User::class, 'user_id');

    }
	
}
