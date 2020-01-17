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




    /*******************************************************************************************************************
    *                                                  INHERITANCE
    *******************************************************************************************************************/


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
}
