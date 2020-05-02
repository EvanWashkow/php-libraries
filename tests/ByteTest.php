<?php
declare( strict_types = 1 );

namespace PHP\Tests;

use PHP\Byte;
use PHP\Interfaces\IIntegerable;
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
            IIntegerable::class => [ IIntegerable::class ]
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
            '-1'  => [ -1,  \RangeException::class ],
            '256' => [ 256, \RangeException::class ]
        ];
    }




    /*******************************************************************************************************************
    *                                                        toInt()
    *******************************************************************************************************************/


    /**
     * Test toInt() exceptions
     * 
     * @dataProvider getByteIntegers
     */
    public function testToInt( int $byte )
    {
        $this->assertEquals(
            $byte,
            ( new Byte( $byte ))->toInt(),
            "Byte->toInt() did not return the Byte's integer value"
        );
    }




    /*******************************************************************************************************************
    *                                                 SHARED DATA PROVIDERS
    *******************************************************************************************************************/

    /**
     * Retrieve a list of Bytes represented as an Integer
     */
    public function getByteIntegers(): array
    {
        return [
            '0'   => [ 0 ],
            '255' => [ 255 ]
        ];
    }
}