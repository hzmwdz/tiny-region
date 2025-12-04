<?php

namespace Hzmwdz\TinyRegion;

use Illuminate\Support\ServiceProvider;

class TinyRegionServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(dirname(__DIR__) . '/database/migrations');

        $this->loadTranslationsFrom(dirname(__DIR__) . '/resources/lang', 'tiny-region');

        $this->publishes([
            dirname(__DIR__) . '/database/migrations' => $this->app->databasePath('migrations')
        ], 'tiny-region-migrations');

        $this->publishes([
            dirname(__DIR__) . '/database/sql' => $this->app->databasePath('sql')
        ], 'tiny-region-sql');

        $this->publishes([
            dirname(__DIR__) . '/resources/lang' => $this->app->resourcePath('lang/vendor/tiny-region'),
        ], 'tiny-region-lang');
    }
}
