<?php
declare( strict_types = 1 );

namespace PHP\Tests;

use PHP\Byte;
use PHP\Interfaces\IIntegerable;
use PHP\Interfaces\IStringable;
use PHP\ObjectClass;
use PHPUnit\Framework\TestCase;

/**
 * Tests Byte
 */
class ByteTest extends TestCase
{




    /*******************************************************************************************************************
    *                                                    INHERITANCE
    *******************************************************************************************************************/


    /**
     * Test inheritance
     * 
     * @dataProvider getInheritanceTestData
     */
    public function testInheritance( string $expectedParent )
    {
        $this->assertInstanceOf(
            $expectedParent,
            new Byte( 0 ),
            "Byte is not of type \\{$expectedParent}."
        );
    }

    public function getInheritanceTestData(): array
    {
        return [
            ObjectClass::class  => [ ObjectClass::class ],
            IIntegerable::class => [ IIntegerable::class ],
            IStringable::class  => [ IStringable::class ]
        ];
    }
}