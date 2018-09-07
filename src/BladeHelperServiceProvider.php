<?php

namespace BhuVidya\BladeHelper;

use Illuminate\Support\ServiceProvider;
use BhuVidya\BladeHelper\Blade\Helper as BladeHelper;
use BhuVidya\BladeHelper\Facades\HelperFacade as BladeHelperFacade;


class BladeHelperServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // config file
        if ($this->app->runningInConsole()) {
            $source = realpath(__DIR__ . '/../config/blade_helper.php');
            $this->publishes([ $source => config_path('blade_helper.php') ], 'config');
        }
    }

    /**
     * Register the service.
     *
     * @return void
     */
    public function register()
    {
        $source = realpath(__DIR__ . '/../config/blade_helper.php');
        $this->mergeConfigFrom($source, 'blade_helper');

        $this->app->singleton(config('blade_helper.instance'), function () {
            return new BladeHelper();
        });

        if ($cls = config('blade_helper.facade')) {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias($cls, BladeHelperFacade::class);
        }
    }
}
