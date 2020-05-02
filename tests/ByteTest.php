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
    *                                                        equals()
    *******************************************************************************************************************/


    /**
     * Test equals( Byte ) result
     * 
     * @dataProvider getEqualsTestData
     */
    public function testEqualsByte( int $byteA, int $byteB, bool $expected )
    {
        $this->assertEquals(
            $expected,
            ( new Byte( $byteA ) )->equals( new Byte( $byteB )),
            'Byte->equals( Byte ) did not return the expected result'
        );
    }


    /**
     * Test equals( int ) result
     * 
     * @dataProvider getEqualsTestData
     */
    public function testEqualsInt( int $byteA, int $byteB, bool $expected )
    {
        $this->assertEquals(
            $expected,
            ( new Byte( $byteA ) )->equals( $byteB ),
            'Byte->equals( int ) did not return the expected result'
        );
    }


    /**
     * Test equals( wrong_type ) result
     */
    public function testEqualsWrongType()
    {
        $this->assertEquals(
            false,
            ( new Byte( 1 ) )->equals( '1' ),
            'Byte->equals( wrong_type ) did not return the expected result'
        );
    }


    /**
     * Retrieve equals() test data
     * 
     * @return array
     */
    public function getEqualsTestData(): array
    {
        // Test data
        $data = [];

        // Append Byte Integers as true
        foreach ( $this->getByteIntegers() as $value ) {
            $byte = $value[ 0 ];
            $data[ "{$byte}, {$byte}, true" ] = [ $byte, $byte, true ];
        }

        // Append false
        $data = array_merge(
            $data,
            [
                '0,   1,   false' => [ 0,   1,   false ],
                '254, 255, false' => [ 254, 255, false ]
            ]
        );

        return $data;
    }




    /*******************************************************************************************************************
    *                                                        toInt()
    *******************************************************************************************************************/


    /**
     * Test toInt() return value
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