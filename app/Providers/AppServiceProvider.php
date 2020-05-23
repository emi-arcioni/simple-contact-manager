<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use App\Contact;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Interfaces\PeopleServiceInterface::class, \App\Services\PeopleService::class);
        $this->app->bind(\App\Interfaces\TrackServiceInterface::class, \App\Services\TrackService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $menu = [
                [
                    'text' => 'Contacts',
                    'url'  => 'contacts',
                    'icon' => 'fas fa-fw fa-users',
                    'label' => Contact::count(),
                    'label_color' => 'success'
                ],
                [
                    'text' => 'Track',
                    'url'  => 'track',
                    'icon' => 'fas fa-fw fa-wave-square',
                ],
                [
                    'text' => 'Settings',
                    'url'  => 'settings',
                    'icon' => 'fas fa-fw fa-cog',
                ]
            ];
            $event->menu->add(...$menu);
        });
    }
}
