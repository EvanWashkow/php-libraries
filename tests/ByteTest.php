<?php
declare( strict_types = 1 );

namespace PHP\Tests;

use PHP\Byte;
use PHP\Collections\ByteArray;
use PHP\Interfaces\IIntegerable;
use PHP\ObjectClass;
use PHP\Tests\Interfaces\IEquatableTestTrait;
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
            '-1'  => [ -1,  \DomainException::class ],
            '256' => [ 256, \DomainException::class ]
        ];
    }




    /*******************************************************************************************************************
    *                                                   IEquatable Tests
    *******************************************************************************************************************/

    use IEquatableTestTrait;


    public function getEqualsTestData(): array
    {
        // Test data
        $data = [];

        // Append Byte Integers as true
        foreach ( $this->getByteIntegers() as $value ) {
            $intByte = $value[ 0 ];
            $byte    = new Byte( $intByte );
            $data[ "Byte( {$intByte} ), Byte( {$intByte} ), true" ] = [ $byte, $byte,    true ];
            $data[ "Byte( {$intByte} ), {$intByte},         true" ] = [ $byte, $intByte, true ];
        }

        // Bytes
        $b0   = new Byte( 0 );
        $b254 = new Byte( 254 );

        // Append false
        $data = array_merge(
            $data,
            [
                'Byte( 0 ),   Byte( 1 ),   false' => [ $b0,   new Byte( 1 ),   false ],
                'Byte( 0 ),   1,           false' => [ $b0,   1,               false ],
                'Byte( 254 ), Byte( 255 ), false' => [ $b254, new Byte( 255 ), false ],
                'Byte( 254 ), 255,         false' => [ $b254, 255,             false ]
            ]
        );

        return $data;
    }


    public function getHashTestData(): array
    {
        $b0   = new Byte( 0 );
        $b255 = new Byte( 255 );
        return [
            'Byte( 0 )'    => [ $b0,   new ByteArray([ $b0 ]),   true ],
            '!Byte( 0 )'   => [ $b0,   new ByteArray([ $b255 ]), false ],
            'Byte( 255 )'  => [ $b255, new ByteArray([ $b255 ]), true ],
            '!Byte( 255 )' => [ $b255, new ByteArray([ $b0 ]),   false ]
        ];
    }


    public function getEqualsAndHashConsistencyTestData(): array
    {
        return [
            'Byte( 0 ),   Byte( 0 )'   => [ new Byte( 0 ),   new Byte( 0 ) ],
            'Byte( 255 ), Byte( 255 )' => [ new Byte( 255 ), new Byte( 255 ) ]
        ];
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