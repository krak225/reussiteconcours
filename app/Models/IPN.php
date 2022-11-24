<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class IPN extends Model
{
    //
	protected $table = 'ipn';
	protected $primaryKey = 'ipn_id';
	public $timestamps = false;
	
	
}
