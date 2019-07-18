<?php

declare(strict_types = 1);

namespace AvtoDev\Sentry\Tests;

/**
 * @coversNothing
 */
class ConfigFileTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function testConfigStructure(): void
    {
        $config = require __DIR__ . '/../config/sentry.php';

        $this->assertInternalType('string', $config['dsn']);
        $this->assertNotEmpty($config['dsn']);

        $this->assertSame(\gethostname(), $config['server_name']);
    }

    /**
     * @return void
     */
    public function testServerNameReadsFromEnvironment(): void
    {
        putenv('SERVER_NAME=foo_bar_123');

        $config = require __DIR__ . '/../config/sentry.php';

        $this->assertSame('foo_bar_123', $config['server_name']);
    }
}
