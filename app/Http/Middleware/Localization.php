<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class Localization
{
    public function handle($request, Closure $next)
    {
        /*
        //$locale = $request->session()->get('locale', config('app.locale'));
        //$locale = Session::get('locale');
        
        $locale = session()->get('locale');
        Log::channel('customlog')->info("locale is ".$locale);
        // Set the application locale
        //$request->session()->put('locale', $locale);
        //App::setLocale($locale);
        if (session()->get('locale')) {
            
            app()->setLocale($locale);
        }

        return $next($request);
        */
        Log::channel('customlog')->info("locale is ".Session::get('locale'));
        if ($request->header('lang')) {
            App::setLocale($request->header('lang'));
        }
        return $next($request);
    }
}
