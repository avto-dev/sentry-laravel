<?php

namespace AvtoDev\Sentry\Tests\Traits;

use AvtoDev\Sentry\SentryServiceProvider;
use AvtoDev\Sentry\Tests\Bootstrap\TestsBootstraper;
use Illuminate\Contracts\Console\Kernel;

trait CreatesApplicationTrait
{
    /**
     * Returns array of default service providers classes.
     *
     * @return string[]
     */
    public static function getDefaultServiceProviders()
    {
        return [
            SentryServiceProvider::class,
        ];
    }

    /**
     * Creates the application.
     *
     * @param string[]|object[]|string|object|null $service_providers
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication($service_providers = [])
    {
        /** @var \Illuminate\Foundation\Application $app */
        $app = require __DIR__ . '/../../vendor/laravel/laravel/bootstrap/app.php';

        $app->useStoragePath(TestsBootstraper::getStorageDirectoryPath());
        $app->configPath(TestsBootstraper::getStorageDirectoryPath());

        $app->make(Kernel::class)->bootstrap();

        if (! is_null($service_providers)) {
            $service_providers = empty($service_providers)
                ? static::getDefaultServiceProviders()
                : $service_providers;

            foreach ((array) $service_providers as $service_provider) {
                $app->register($service_provider);
            }
        }


        return $app;
    }
}
