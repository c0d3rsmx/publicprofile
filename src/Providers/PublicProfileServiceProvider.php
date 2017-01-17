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
        include __DIR__.'/../routes/publicprofile.php';
        $this->publishes([
            __DIR__.'/../views' => base_path('resources/views/so2platform/publicprofile'),
            __DIR__.'/../database/migrations' => base_path('database/migrations'),
            __DIR__.'/../routes' => base_path('routes'),
            __DIR__.'/../Controllers' => base_path('app/Http/Controllers'),
        ]);
        $this->loadViewsFrom(__DIR__.'/../views', 'publicprofile');
//        $this->loadViewsFrom(base_path('resources/views/so2platform/publicprofile'), 'publicprofile');
        if(file_exists(base_path('routes/publicprofile.php'))) {
            $this->loadRoutesFrom(base_path('routes/publicprofile.php'));
        }
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
