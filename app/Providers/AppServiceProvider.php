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
        $this->app->bind(\App\Repositories\RoverRepository\RoverRepositoryInterface::class, \App\Repositories\RoverRepository\RoverRepository::class);
        $this->app->bind(\App\Repositories\PlanetRepository\PlanetRepositoryInterface::class, \App\Repositories\PlanetRepository\PlanetRepository::class);
        
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
