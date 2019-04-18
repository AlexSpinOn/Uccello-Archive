<?php

namespace Spinon\UccelloArchive\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * App Service Provider
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    public function boot()
    {
        // Views
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'uccello-archive');

        // Translations
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'uccello-archive');

        // Migrations
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        // Publish assets
        $this->publishes([
            __DIR__ . '/../../public' => public_path('vendor/spinon/uccello-archive'),
        ], 'assets'); // CSS

        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
    }

    public function register()
    {

    }
}