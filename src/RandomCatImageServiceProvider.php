<?php

namespace Alexwarman\RandomCatImage;

use Illuminate\Support\ServiceProvider;

class RandomCatImageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/random-cat-image.php',
            'random-cat-image'
        );

        $this->app->singleton('random-cat-image', function ($app) {
            return new RandomCatImage();
        });

        $this->app->alias('random-cat-image', RandomCatImage::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/random-cat-image.php' => config_path('random-cat-image.php'),
            ], 'random-cat-image-config');
        }
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return ['random-cat-image'];
    }
}
