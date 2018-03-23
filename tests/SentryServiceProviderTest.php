<?php

namespace AvtoDev\Sentry\Tests;

use Raven_Client;
use AvtoDev\Sentry\SentryServiceProvider;
use AvtoDev\AppVersion\AppVersionServiceProvider;
use Sentry\SentryLaravel\SentryLaravelServiceProvider;
use AvtoDev\AppVersion\Contracts\AppVersionManagerContract;

/**
 * Class SentryServiceProviderTest.
 */
class SentryServiceProviderTest extends AbstractTestCase
{
    /**
     * Test that service providers is loaded (automatic).
     *
     * @return void
     */
    public function testServiceProviderRegistered()
    {
        $loaded_providers = $this->app->getLoadedProviders();

        foreach ([
                     SentryServiceProvider::class,
                     AppVersionServiceProvider::class,
                     SentryLaravelServiceProvider::class,
                 ] as $class_name) {
            $this->assertContains($class_name, $loaded_providers);
        }
    }

    /**
     * Exception test with unloaded service-provider for package 'sentry/sentry-laravel'.
     *
     * @return void
     */
    public function testWithNotLoadedServiceProviderForSentry()
    {
        $app = $this->createApplication([
            AppVersionServiceProvider::class,
            SentryServiceProvider::class,
        ]);

        $this->assertInstanceOf(Raven_Client::class, $app->make('sentry'));
        $this->assertInstanceOf(AppVersionManagerContract::class, $app->make('app.version.manager'));
    }

    /**
     * Exception test with unloaded service-provider for package 'avto-dev/app-version-laravel'.
     *
     * @return void
     */
    public function testWithNotLoadedServiceProviderForAppVersion()
    {
        $app = $this->createApplication([
            SentryLaravelServiceProvider::class,
            SentryServiceProvider::class,
        ]);

        $this->assertInstanceOf(Raven_Client::class, $app->make('sentry'));
        $this->assertInstanceOf(AppVersionManagerContract::class, $app->make('app.version.manager'));
    }

    /**
     * Test that release version isset.
     */
    public function testReleaseIsset()
    {
        /** @var Raven_Client $sentry */
        $sentry = $this->app->make('sentry');
        /** @var AppVersionManagerContract $version */
        $version = $this->app->make('app.version.manager');

        $this->assertEquals($version->formatted(), $sentry->getRelease());
    }
}
