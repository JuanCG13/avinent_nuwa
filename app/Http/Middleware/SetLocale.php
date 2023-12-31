<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        App::setLocale(config('app.locale'));
        
        if(session()->has('locale')) {
            App::setLocale(session('locale'));
        }
 
        return $next($request);
    }
}