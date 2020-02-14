<?php

declare(strict_types = 1);

namespace AvtoDev\Sentry;

use Sentry\State\Hub;
use Illuminate\Container\Container;
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
                \dirname(__DIR__) . '/config/sentry.php' => config_path(SentryServiceProvider::$abstract . '.php'),
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

        // @link: <https://github.com/avto-dev/app-version-laravel/blob/v2.1.0/src/Contracts/AppVersionManagerContract.php>
        if (\interface_exists($v2 = 'AvtoDev\\AppVersion\\Contracts\\AppVersionManagerContract')) {
            if ($container->bound($v2)) {
                return $container->make($v2)->formatted();
            }
        }

        // @link: <https://github.com/avto-dev/app-version-laravel/blob/v3.0.0/src/AppVersionManagerInterface.php>
        if (\interface_exists($v3 = 'AvtoDev\\AppVersion\\AppVersionManagerInterface')) {
            if ($container->bound($v3)) {
                return $container->make($v3)->version();
            }
        }

        return null;
    }
}
