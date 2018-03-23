<?php

namespace AvtoDev\Sentry\Tests\Commands;

use Mockery as m;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Console\Kernel;
use AvtoDev\Sentry\Commands\SentryInitCommand;
use AvtoDev\AppVersion\Contracts\AppVersionManagerContract;

/**
 * Class SentryInitCommandTest.
 */
class SentryInitCommandTest extends AbstractCommandTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $stubs_path = $this->getStubConfigsDirectoryPath();

        foreach (['sentry.php', 'sentry.php.bak'] as $file_name) {
            if (file_exists($file_path = $stubs_path . '/' . $file_name)) {
                $this->assertTrue(unlink($file_path));
            }
        }
    }

    /**
     * Test command execution.
     *
     * @return void
     */
    public function testExecution()
    {
        $configs_dir = $this->getStubConfigsDirectoryPath();

        $this->assertFileNotExists($configs_dir . '/sentry.php');
        $this->assertFileNotExists($configs_dir . '/sentry.php.bak');

        $this->assertZero($this->artisan($this->getCommandSignature(), [
            '--configs-path' => $configs_dir,
        ]));
        $out = Str::lower($this->console()->output());

        $this->assertFileExists($sentry_config_path = $configs_dir . '/sentry.php');
        $this->assertFileNotExists($configs_dir . '/sentry.php.bak');
        $this->assertNotContains('previous config file already exists', $out);
        $this->assertContains('updated successfully', $out);
        $this->assertContains('sentry configuration', Str::lower(file_get_contents($sentry_config_path)));
        $this->assertIsArray($config_content = require $sentry_config_path);
        $this->assertTrue($config_content['user_context']);
        $this->assertEmpty($config_content['dsn']);

        // Patch new config file (LOL below)
        $config_content['dsn'] = ($new_dsn = 'https://foo:bar@some.io/1/');
        file_put_contents($sentry_config_path, sprintf('<?php return %s;', var_export($config_content, true)));

        // With 'force' flag
        $this->assertZero($this->artisan($this->getCommandSignature(), [
            '--configs-path' => $configs_dir,
            '--force'        => true,
        ]));
        $out = Str::lower($this->console()->output());

        $this->assertFileExists($configs_dir . '/sentry.php');
        $this->assertFileExists($configs_dir . '/sentry.php.bak');
        $this->assertNotContains('previous config file already exists', $out);
        $this->assertContains('updated successfully', $out);
        $this->assertContains('sentry configuration', Str::lower(file_get_contents($sentry_config_path)));
        $this->assertIsArray($config_content = require $sentry_config_path);
        $this->assertEquals($new_dsn, $config_content['dsn']);

        // Again, but without 'force' flag
        $command = m::mock(sprintf('%s[%s]', SentryInitCommand::class, $what = 'confirm'), [
            new Filesystem,
            $this->app->make(AppVersionManagerContract::class),
        ]);
        $command->shouldReceive($what)->once()->andReturn(true);
        $this->app->make(Kernel::class)->registerCommand($command);

        $this->assertZero($this->artisan($this->getCommandSignature(), [
            '--configs-path' => $configs_dir,
        ]));
        $out = Str::lower($this->console()->output());

        $this->assertFileExists($configs_dir . '/sentry.php');
        $this->assertFileExists($configs_dir . '/sentry.php.bak');
        $this->assertNotContains('previous config file already exists', $out);
        $this->assertContains('updated successfully', $out);
        $this->assertContains('removed', $out);
        $this->assertContains('sentry configuration', Str::lower(file_get_contents($sentry_config_path)));
        $this->assertIsArray($config_content = require $sentry_config_path);
        $this->assertEquals($new_dsn, $config_content['dsn']);

        $command = m::mock(sprintf('%s[%s]', SentryInitCommand::class, $what = 'confirm'), [
            new Filesystem,
            $this->app->make(AppVersionManagerContract::class),
        ]);
        $command->shouldReceive($what)->once()->andReturn(false);
        $this->app->make(Kernel::class)->registerCommand($command);

        $this->assertNotZero($this->artisan($this->getCommandSignature(), [
            '--configs-path' => $configs_dir,
        ]));
    }

    /**
     * {@inheritdoc}
     */
    protected function getCommandSignature()
    {
        return 'sentry:init';
    }

    /**
     * Get config stubs directory path.
     *
     * @return string
     */
    protected function getStubConfigsDirectoryPath()
    {
        return realpath(__DIR__ . '/../stubs/config');
    }
}
