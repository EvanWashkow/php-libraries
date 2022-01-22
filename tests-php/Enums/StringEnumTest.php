<?php

declare(strict_types=1);

namespace PHP\Tests\Enums;

use PHP\Interfaces\IStringable;
use PHP\Tests\Enums\TestEnumDefinitions\GoodStringEnum;
use PHPUnit\Framework\TestCase;

/**
 * Test the StringEnum class.
 *
 * @internal
 * @coversNothing
 */
class StringEnumTest extends TestCase
{
    /**
     * Ensure that StringEnum is IStringable.
     */
    public function testIsIStringable(): void
    {
        $this->assertInstanceOf(
            IStringable::class,
            new GoodStringEnum(GoodStringEnum::ONE),
            'StringEnum is not IStringable.'
        );
    }

    // getValue()

    /**
     * Test getValue() to ensure that finalizing it did not break the base implementation.
     */
    public function testGetValue()
    {
        $this->assertEquals(
            GoodStringEnum::ONE,
            (new GoodStringEnum(GoodStringEnum::ONE))->getValue(),
            'StringEnum->getValue() did not return the expected value'
        );
    }

    /**
     * Ensure that StringEnum->__toString() returns the current value.
     */
    public function testToString(): void
    {
        $this->assertTrue(
            GoodStringEnum::ONE === (string) ( new GoodStringEnum(GoodStringEnum::ONE)),
            'StringEnum->__toString() did not return the current value.'
        );
    }
}
