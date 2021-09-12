<?php

namespace Magutti\MaguttiSpatial;

use Illuminate\Support\ServiceProvider;

class MaguttiSpatialServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/magutti-spatial.php' => config_path('magutti-spatial.php'),
            ], 'config');


        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/magutti-spatial.php', 'magutti-spatial');
    }
}
