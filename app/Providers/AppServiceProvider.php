<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // webhoost return 
        // $this -> app -> bind('path.public', function()
        // {
        //     return base_path('public');
        // });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {   
        //hot fix untuk ngrok terbaru
        if( env('APP_ENV') == 'production'  || 
            env('APP_ENV') == 'testing'     || 
            isset($_SERVER['HTTPS'])        && 
            ($_SERVER['HTTPS'] == 'on'      || 
            $_SERVER['HTTPS'] == 1)         || 
            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&  
            $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') 
        {
            \URL::forceScheme('https');
        }
    }
}
