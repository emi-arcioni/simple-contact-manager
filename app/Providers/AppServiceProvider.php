<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Interfaces\PeopleServiceInterface;
use App\Services\PeopleService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PeopleServiceInterface::class, PeopleService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
