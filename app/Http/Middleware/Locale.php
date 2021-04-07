<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class Locale{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next){
    	$locale = $request->route('locale', 'en');
    	App::setLocale($locale);
		$request->route()->forgetParameter('locale');
        return $next($request);
    }
}
