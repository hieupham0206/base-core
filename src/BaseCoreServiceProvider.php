<?php

namespace Cloudteam\BaseCore;

use App\Console\Commands\RefreshVersionJsCommand;
use Cloudteam\BaseCore\Console\Commands\CrudControllerCommand;
use Cloudteam\BaseCore\Console\Commands\CrudMakeCommand;
use Cloudteam\BaseCore\Console\Commands\CrudTableCommand;
use Cloudteam\BaseCore\Console\Commands\CrudTestCommand;
use Cloudteam\BaseCore\Console\Commands\CrudViewCommand;
use Illuminate\Support\ServiceProvider;

class BaseCoreServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'cloudteam');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'cloudteam');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        // Load the helpers in app/Http/helpers.php
//        if (file_exists($file = app_path('Http/helpers.php')))
//        {
//            /** @noinspection PhpIncludeInspection */
//            require $file;
//        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/basecore.php', 'basecore');

        // Register the service the package provides.
        $this->app->singleton('basecore', static function () {
            return new BaseCore;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['basecore'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/basecore.php' => config_path('basecore.php'),
        ], 'basecore.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/cloudteam'),
        ], 'basecore.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/cloudteam'),
        ], 'basecore.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/cloudteam'),
        ], 'basecore.views');*/

        // Registering package commands.
        $this->commands([
            CrudMakeCommand::class,
            CrudControllerCommand::class,
            CrudTableCommand::class,
            CrudViewCommand::class,
            CrudTestCommand::class,
            RefreshVersionJsCommand::class
        ]);
    }
}
