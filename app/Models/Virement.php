<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Virement extends Model
{
    //
	protected $table = 'virement';
	protected $primaryKey = 'virement_id';
	public $timestamps = false;
	
}
