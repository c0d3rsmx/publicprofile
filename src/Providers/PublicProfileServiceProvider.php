<?php

namespace So2platform\Publicprofile\Providers;

use Illuminate\Support\ServiceProvider;

class PublicProfileServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__.'/../routes/routes.php';
        $this->publishes([
            __DIR__.'/../views' => base_path('resources/views/so2platform/publicprofile'),
            __DIR__.'/../database/migrations' => base_path('database/migrations'),
        ]);
        $this->loadViewsFrom(__DIR__.'/../views', 'publicprofile');
//        $this->loadViewsFrom(base_path('resources/views/so2platform/messaging'), 'messaging');

    }


    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
