<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Concours extends Model
{
    //
	protected $table = 'concours';
	protected $primaryKey = 'concours_id';
	public $timestamps = false;
	
	
	public function livres(){
		return $this->hasMany(Livre::class, 'concours_id');	
	}
	
}
