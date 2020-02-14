<?php

declare(strict_types = 1);

namespace AvtoDev\Sentry\Tests;

use Sentry\Client;
use Sentry\State\Hub;
use AvtoDev\Sentry\ServiceProvider;
use Sentry\Laravel\ServiceProvider as SentryLaravelServiceProvider;
use AvtoDev\AppVersion\AppVersionManagerInterface as AppVersionManagerV3;
use AvtoDev\AppVersion\Contracts\AppVersionManagerContract as AppVersionManagerV2;

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

        if (\interface_exists(AppVersionManagerV2::class)) {
            $this->assertSame(
                $this->app->make(AppVersionManagerV2::class)->formatted(),
                $sentry->getClient()->getOptions()->getRelease()
            );
        } else {
            $this->assertSame(
                $this->app->make(AppVersionManagerV3::class)->formatted(),
                $sentry->getClient()->getOptions()->getRelease()
            );
        }
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

    /**
     * @return void
     */
    public function testRegisterConfigs(): void
    {
        $package_config_src    = \realpath(__DIR__ . '/../config/sentry.php');
        $package_config_target = $this->app->configPath('sentry.php');

        $this->assertSame(
            $package_config_target,
            ServiceProvider::$publishes[ServiceProvider::class][$package_config_src]
        );

        $this->assertSame(
            $package_config_target,
            ServiceProvider::$publishGroups['sentry-config'][$package_config_src],
            "Publishing group value {$package_config_target} was not found"
        );
    }
}
