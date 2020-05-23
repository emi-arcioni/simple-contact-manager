<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Setting;
use Illuminate\Support\Facades\View;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class KlaviyoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('GuzzleHttp\Client', function($api) {
            return new Client([
                'base_uri' => env('KLAVIYO_URL')
            ]);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        
        // 
    }
}
