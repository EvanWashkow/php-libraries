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




    /*******************************************************************************************************************
    *                                                   __construct()
    *******************************************************************************************************************/


    /**
     * Test __construct() exceptions
     * 
     * @dataProvider getConstructorExceptionsTestData
     */
    public function testConstructorExceptions( $constructorArg, string $exceptionName )
    {
        $this->expectException( $exceptionName );
        new Byte( $constructorArg );
    }

    public function getConstructorExceptionsTestData(): array
    {
        return [
            '1.5'         => [ 1.5,         \InvalidArgumentException::class ],
            '[ 1, 2, 3 ]' => [ [ 1, 2, 3 ], \InvalidArgumentException::class ],
            '-1'          => [ -1,          \RangeException::class ],
            '256'         => [ 256,         \RangeException::class ]
        ];
    }
}