<?php
declare(strict_types=1);

namespace PHP\Tests\Enums;

use PHP\Interfaces\Stringable;
use PHP\Tests\Enums\TestEnumDefinitions\GoodStringEnum;
use PHPUnit\Framework\TestCase;

/**
 * Test the StringEnum class
 */
class StringEnumTest extends TestCase
{


    /**
     * Ensure that StringEnum is Stringable
     * 
     * @return void
     */
    public function testIsStringable(): void
    {
        $this->assertInstanceOf(
            Stringable::class,
            new GoodStringEnum( GoodStringEnum::ONE ),
            'StringEnum is not Stringable.'
        );
    }


    /**
     * Ensure that StringEnum->__toString() returns the current value
     * 
     * @return void
     */
    public function testToString(): void
    {
        $this->assertTrue(
            ( string )( new GoodStringEnum( GoodStringEnum::ONE )) === GoodStringEnum::ONE,
            'StringEnum->__toString() did not return the current value.'
        );
    }
}
