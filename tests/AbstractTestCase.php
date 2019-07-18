<?php

namespace AvtoDev\Sentry\Tests;

use AvtoDev\AppVersion\ServiceProvider as AppVersionServiceProvider;
use AvtoDev\Sentry\ServiceProvider;
use Illuminate\Contracts\Console\Kernel;
use Sentry\Laravel\ServiceProvider as SentryLaravelServiceProvider;

abstract class AbstractTestCase extends \Illuminate\Foundation\Testing\TestCase
{
    /**
     * Returns array of default service providers classes.
     *
     * @return string[]
     */
    public static function getDefaultServiceProviders(): array
    {
        return [
            SentryLaravelServiceProvider::class,
            AppVersionServiceProvider::class,
            ServiceProvider::class,
        ];
    }

    /**
     * Creates the application.
     *
     * @param string ...$service_providers
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        /** @var \Illuminate\Foundation\Application $app */
        $app = require __DIR__ . '/../vendor/laravel/laravel/bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        $service_providers = \func_num_args() >= 1
            ? \func_get_args()
            : self::getDefaultServiceProviders();

        foreach ($service_providers as $service_provider) {
            $app->register($service_provider);
        }

        return $app;
    }
}
