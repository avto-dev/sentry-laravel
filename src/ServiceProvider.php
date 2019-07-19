<?php

declare(strict_types = 1);

namespace AvtoDev\Sentry;

use Sentry\State\Hub;
use Illuminate\Container\Container;
use AvtoDev\AppVersion\Contracts\AppVersionManagerContract;
use Sentry\Laravel\ServiceProvider as SentryServiceProvider;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap the service provider.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->app->extend(SentryServiceProvider::$abstract, function (Hub $hub, Container $container): Hub {
            $client = $hub::getCurrent()->getClient();

            if ($client instanceof \Sentry\Client) {
                $client->getOptions()->setRelease($this->getApplicationVersion($container));
            }

            return $hub;
        });

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/sentry.php' => config_path(SentryServiceProvider::$abstract . '.php'),
            ], 'sentry-config');
        }
    }

    /**
     * Get application version value.
     *
     * @param Container $container
     *
     * @return string|null
     */
    protected function getApplicationVersion(Container $container): ?string
    {
        // Install package 'avto-dev/app-version-laravel' for release version providing
        if ($container->bound(AppVersionManagerContract::class)) {
            /** @var AppVersionManagerContract $manager */
            $manager = $container->make(AppVersionManagerContract::class);

            return $manager->formatted();
        }

        return null;
    }
}
