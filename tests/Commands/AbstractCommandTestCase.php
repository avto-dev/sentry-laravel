<?php

namespace AvtoDev\Sentry\Tests\Commands;

use Illuminate\Contracts\Console\Kernel;
use AvtoDev\Sentry\Tests\AbstractTestCase;

/**
 * Class AbstractCommandTestCase.
 */
abstract class AbstractCommandTestCase extends AbstractTestCase
{
    /**
     * Basic command test.
     *
     * @return void
     */
    public function testHelpCommand()
    {
        $this->assertNotFalse(
            $this->artisan($signature = $this->getCommandSignature(), ['--help']),
            sprintf('Command "%s" does not return help message', $signature)
        );
    }

    /**
     * @return Kernel|\App\Console\Kernel
     */
    public function console()
    {
        return $this->app->make(Kernel::class);
    }

    /**
     * Command signature.
     *
     * @return string
     */
    abstract protected function getCommandSignature();
}
