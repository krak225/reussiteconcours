<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Livre extends Model
{
    //
	protected $table = 'livre';
	protected $primaryKey = 'livre_id';
	public $timestamps = false;
	
	
}
