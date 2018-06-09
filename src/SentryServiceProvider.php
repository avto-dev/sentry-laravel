<?php

namespace AvtoDev\Sentry;

use AvtoDev\AppVersion\AppVersionServiceProvider;
use Sentry\SentryLaravel\SentryLaravelServiceProvider;
use AvtoDev\AppVersion\Contracts\AppVersionManagerContract;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class SentryServiceProvider extends IlluminateServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @param AppVersionManagerContract $manager
     *
     * @return void
     */
    public function boot(AppVersionManagerContract $manager)
    {
        // Set application release version
        $this->app->make(SentryLaravelServiceProvider::$abstract)->setRelease($manager->formatted());
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (! $this->serviceProviderForSentryIsLoaded()) {
            $this->registerServiceProviderForSentry();
        }

        if (! $this->serviceProviderForAppVersionIsLoaded()) {
            $this->registerServiceProviderForAppVersion();
        }

        if ($this->app->runningInConsole()) {
            $this->registerArtisanCommands();
        }
    }

    /**
     * Register artisan commands.
     *
     * @return void
     */
    protected function registerArtisanCommands()
    {
        $this->commands([
            Commands\SentryInitCommand::class,
        ]);
    }

    /**
     * Make check - service provider for package 'sentry/sentry-laravel' is loaded?
     *
     * @return bool
     */
    protected function serviceProviderForSentryIsLoaded()
    {
        return $this->app->bound(SentryLaravelServiceProvider::$abstract) === true;
    }

    /**
     * Register service provider for a package 'sentry/sentry-laravel'.
     *
     * @return void
     */
    protected function registerServiceProviderForSentry()
    {
        $this->app->register(SentryLaravelServiceProvider::class);
    }

    /**
     * Make check - service provider for package 'avto-dev/app-version-laravel' is loaded?
     *
     * @return bool
     */
    protected function serviceProviderForAppVersionIsLoaded()
    {
        return $this->app->bound(AppVersionServiceProvider::VERSION_MANAGER_ALIAS) === true;
    }

    /**
     * Register service provider for a package 'avto-dev/app-version-laravel'.
     *
     * @return void
     */
    protected function registerServiceProviderForAppVersion()
    {
        $this->app->register(AppVersionServiceProvider::class);
    }
}
