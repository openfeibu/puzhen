<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // Load view
        $this->loadViewsFrom('', 'menu');

        // Call pblish redources function
        $this->publishResources();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('menu', function ($app) {
            return $this->app->make('App\Menu');
        });

        // Bind Menu to repository
        $this->app->bind(
            'App\Repositories\Eloquent\MenuRepositoryInterface',
            \App\Repositories\Eloquent\MenuRepository::class
        );
                
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['menu'];
    }

    /**
     * Publish resources.
     *
     * @return void
     */
    private function publishResources()
    {

    }
}
