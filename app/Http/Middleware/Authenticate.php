<?php

namespace App\Http\Middleware;

use Closure;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\URL;


class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    // protected function redirectTo($request)
    // {   
        
    //     if (! $request->expectsJson()) {
    //         return route('login');
    //     }
        
    // }

    public function handle($request, Closure $next, ...$guards)
    {
        // $guards = empty($guards) ? [null] : $guards;

        // foreach ($guards as $guard) {
        //     if (Auth::guard($guard)->check()) {
        //         return redirect(RouteServiceProvider::HOME);
        //     }
        // }

        $path = $request->path();
        if(strpos($path, 'api') !== false){
            $is_login = true;
            $token_header = $request->header('token');
        }else{
            $is_login = session()->get('is_login') == true;
            $token_header = session()->get('_token');
        }   

        $data_user = DB::table('users')->where('_token', $token_header)->first();
        
        $isApi = strpos($path, 'api');

        if( !$is_login == true || $data_user == null){
            
            //if $path contain 'api' then return to next request
            if($isApi !== false){
                return response()->json(['response' => 'Token tidak ditemukan', 'metadata' => ['status' => 410, 'message' => 'Token tidak ditemukan']], 410);
            }else{
                return redirect()->route('login');
                dd($data_user);
            }
        }

        if($isApi !== false){
            //add data_user to request header
            $request->headers->set('data_user', json_encode($data_user));
            return $next($request);
        }else{
            return $next($request);
        }
    }
}
