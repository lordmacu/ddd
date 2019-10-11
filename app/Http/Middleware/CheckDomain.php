<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Session;
    use Illuminate\Support\Facades\Config;

class CheckDomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        
       $domain = array_first(explode('.', \Request::getHost()));
       
       if($domain=="chile"){
            Session::put('country_id', '2');
             
            $config=config('country.'.Session::get('country_id'));

            Session::put('fromMoney', $config["from"]);
            Session::put('toMoney',  $config["to"]);
            Session::put('currency',  $config["currency"]);
            Session::put('currencyName', $config["currencyName"]);

            Config::set('services.facebook.redirect', url("/")."/callbackFacebookLogin" );
            Config::set('services.google.redirect', url("/")."/callbackGoogleLogin" );

            
            
       }else
       if($domain=="es"){
            Session::put('country_id', '3');
            
            $config=config('country.'.Session::get('country_id'));

            Session::put('fromMoney', $config["from"]);
            Session::put('toMoney',  $config["to"]);
            Session::put('currency',  $config["currency"]);
            Session::put('currencyName', $config["currencyName"]);
            
            Config::set('services.facebook.redirect', url("/")."/callbackFacebookLogin" );
            Config::set('services.google.redirect', url("/")."/callbackGoogleLogin" );
       }else{
                Session::put('country_id', '1');
            $config=config('country.'.Session::get('country_id'));

            Session::put('fromMoney', $config["from"]);
            Session::put('toMoney',  $config["to"]);
            
            Session::put('currency',  $config["currency"]);
            Session::put('currencyName', $config["currencyName"]);
            
             
            Config::set('services.facebook.redirect', url("/")."/callbackFacebookLogin" );
            Config::set('services.google.redirect', url("/")."/callbackGoogleLogin" );
       }
        
        return $next($request);
    }
}
