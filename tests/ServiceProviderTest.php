<?php

declare(strict_types = 1);

namespace AvtoDev\Sentry\Tests;

use Sentry\Client;
use Sentry\State\Hub;
use AvtoDev\Sentry\ServiceProvider;
use AvtoDev\AppVersion\Contracts\AppVersionManagerContract;
use Sentry\Laravel\ServiceProvider as SentryLaravelServiceProvider;

/**
 * @covers \AvtoDev\Sentry\ServiceProvider
 */
class ServiceProviderTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function testReleaseSet(): void
    {
        /** @var Hub $sentry */
        $sentry = $this->app->make('sentry');

        $this->assertInstanceOf(Client::class, $sentry->getClient());

        $this->assertSame(
            $this->app->make(AppVersionManagerContract::class)->formatted(),
            $sentry->getClient()->getOptions()->getRelease()
        );
    }

    /**
     * @return void
     */
    public function testPublisherRegistered(): void
    {
        $found = false;

        foreach (ServiceProvider::$publishes as $provider_class => $publishes) {
            if ($provider_class === ServiceProvider::class) {
                foreach ($publishes as $file_from => $publish) {
                    if (
                        config_path('sentry.php')
                        && \realpath($file_from) === \realpath(__DIR__ . '/../config/sentry.php')
                    ) {
                        $found = true;

                        break;
                    }
                }
            }
        }

        $this->assertTrue($found);
    }

    /**
     * @return void
     */
    public function testReleaseNotSetWithoutVersionManagerRegistered(): void
    {
        $this->app = $this->createApplication(SentryLaravelServiceProvider::class, ServiceProvider::class);

        /** @var Hub $sentry */
        $sentry = $this->app->make('sentry');

        $this->assertNull(
            $sentry->getClient()->getOptions()->getRelease()
        );
    }
}
