<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use function Termwind\render;

class RouteValidation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {   
        
        $uri  = '/'.$request->route()->uri();
        // return $next($request);
        $arr_menu = (session()->get('arr_menu'));

        //find uri in arr_menu
        $find = (string)array_search($uri, $arr_menu);
        
        if($find == "" && $uri != '//'){
            //render no_power view

            return redirect('no_power');
            
        }else{
            return $next($request);
        }
    }
}
