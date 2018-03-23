<?php

namespace AvtoDev\Sentry\Tests\Traits;

use PHPUnit\Framework\AssertionFailedError;

/**
 * Trait AdditionalAssertsTrait.
 *
 * Trait with additional asserts methods.
 */
trait AdditionalAssertsTrait
{
    /**
     * Assert that value is array.
     *
     * @param $value
     *
     * @throws AssertionFailedError
     */
    public function assertIsArray($value)
    {
        $this->assertTrue(is_array($value), 'Must be an array');
    }

    /**
     * Assert that value is'n empty string.
     *
     * @param $value
     *
     * @throws AssertionFailedError
     */
    public function assertIsNotEmptyString($value)
    {
        $this->assertIsString($value);
        $this->assertNotEmpty($value);
    }

    /**
     * Assert that value is string.
     *
     * @param $value
     *
     * @throws AssertionFailedError
     */
    public function assertIsString($value)
    {
        $this->assertTrue(is_string($value), 'Must be string');
    }

    /**
     * Assert that value is zero.
     *
     * @param $value
     *
     * @throws AssertionFailedError
     */
    public function assertZero($value)
    {
        $this->assertEquals(0 , $value , 'Must be zero');
    }

    /**
     * Assert that value is NOT zero.
     *
     * @param $value
     *
     * @throws AssertionFailedError
     */
    public function assertNotZero($value)
    {
        $this->assertNotEquals(0 , $value , 'Must not equals zero');
    }
}
