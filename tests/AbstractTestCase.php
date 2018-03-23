<?php

namespace AvtoDev\Sentry\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/**
 * Class AbstractTestCase.
 */
abstract class AbstractTestCase extends BaseTestCase
{
    use Traits\CreatesApplicationTrait,
        Traits\AdditionalAssertsTrait;
}
