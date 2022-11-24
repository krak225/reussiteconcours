<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
		'http://reussiteconcours.com/notify',
		'http://reussiteconcours.com/notify/',
		'https://reussiteconcours.com/notify',
		'https://reussiteconcours.com/notify/',
		'http://localhost/reussiteconcours/public/notify',
    ];
	
}
