<?php
declare( strict_types = 1 );

namespace PHP\Tests\Collections;

use PHP\Byte;
use PHP\Collections\ByteArray;
use PHP\Collections\IArrayable;
use PHP\Collections\IReadOnlyCollection;
use PHP\Collections\Iteration\ArrayableIterator;
use PHP\Interfaces\ICloneable;
use PHP\Interfaces\IIntegerable;
use PHP\Interfaces\IStringable;
use PHP\ObjectClass;
use PHP\Tests\Interfaces\IEquatableTestTrait;
use PHPUnit\Framework\TestCase;

/**
 * Tests ByteArray
 */
class ByteArrayTest extends TestCase
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
            new ByteArray( '' ),
            "ByteArray is not of type \\{$expectedParent}."
        );
    }

    public function getInheritanceTestData(): array
    {
        return [
            ObjectClass::class          => [ ObjectClass::class ],
            IArrayable::class           => [ IArrayable::class ],
            ICloneable::class           => [ ICloneable::class ],
            IIntegerable::class         => [ IIntegerable::class ],
            IReadOnlyCollection::class  => [ IReadOnlyCollection::class ],
            IStringable::class          => [ IStringable::class ]
        ];
    }





    /*******************************************************************************************************************
    *                                            __construct() and __toString()
    *
    * All other tests are built with the assumption these methods work correctly.
    * 
    * The reason these two functions are being tested together is that there should be a x:1 correlation between
    * __construct() and __toString(). Namely, __construct() should convert the x number of parameters it supports to a
    * string, and __toString() should return that string.
    *******************************************************************************************************************/


    /**
     * Test __construct() exceptions
     * 
     * @dataProvider getConstructorExceptionsTestData
     */
    public function testConstructExceptions( array $constructorArgs, string $expectedException )
    {
        $this->expectException( $expectedException );
        new ByteArray( ...$constructorArgs );
    }

    public function getConstructorExceptionsTestData(): array
    {
        return [
            '__construct( null )' => [
                [ null ],
                \InvalidArgumentException::class
            ],
            '__construct( [ 65 ] )' => [
                [ [ 65 ] ],
                \InvalidArgumentException::class
            ],
            '__construct( 1.5, -1 ) throws DomainException' => [
                [ 1.5, -1 ],
                \DomainException::class
            ],
            '__construct( 65, -1 ) throws DomainException' => [
                [ 65, -1 ],
                \DomainException::class
            ]
        ];
    }


    /**
     * Test __construct( Byte[] )
     * 
     * @dataProvider getByteArrayConstructorTestData
     */
    public function testByteArrayConstructor( array $intByteArray, string $expectedString )
    {
        // Convert integer bytes into Byte instances
        $byteArray = [];
        foreach ( $intByteArray as $i => $intByte ) {
            $byteArray[] = new Byte( $intByte );
        }

        // Run test
        $this->assertEquals(
            $expectedString,
            ( new ByteArray( $byteArray ) )->__toString(),
            '( new ByteArray( Byte[] ) )->__toString() did not return the expected string.'
        );
    }

    public function getByteArrayConstructorTestData(): array
    {
        return [
            '[]' => [
                [],
                ''
            ],
            '[ 65 ]' => [
                [ 65 ],
                'A'
            ],
            '[ 65, 66 ]' => [
                [ 65, 66 ],
                'AB'
            ],
            '[ 65, 66, 67 ]' => [
                [ 65, 66, 67 ],
                'ABC'
            ],
            '[ 65, 66, 67, 0 ]' => [
                [ 65, 66, 67, 0 ],
                'ABC' . self::getNullChar()
            ],
            '[ 65, 66, 67, 0, 97, 98, 99 ]' => [
                [ 65, 66, 67, 0, 97, 98, 99 ],
                'ABC' . self::getNullChar() . 'abc'
            ]
        ];
    }


    /**
     * Test __construct( float )
     * 
     * @dataProvider getIntegerConstructorTestData
     */
    public function testFloatConstructor( int $intBytes, int $byteSize, string $expectedString )
    {
        $floatBytes = unpack( 'd', pack( 'q', $intBytes ))[ 1 ];

        $this->assertEquals(
            $expectedString,
            ( new ByteArray( $floatBytes, $byteSize ))->__toString(),
            '( new ByteArray( float, int ) )->__toString() did not return the expected string.'
        );
    }


    /**
     * Test __construct( int )
     * 
     * @dataProvider getIntegerConstructorTestData
     */
    public function testIntegerConstructor( int $bytes, int $byteSize, string $expectedString )
    {
        $this->assertEquals(
            $expectedString,
            ( new ByteArray( $bytes, $byteSize ))->__toString(),
            '( new ByteArray( int, int ) )->__toString() did not return the expected string.'
        );
    }


    /**
     * Retrieves __construct() test data of int $bytes, int $byteSize, and string $expectedString
     *  
     * @todo Remove nullChar tests by implementing a String class with a type of fix(int length, string pad) function
     * @return array
     */
    public function getIntegerConstructorTestData(): array
    {
        // A null-byte string (0x00-string equivalent)
        $nullChar = self::getNullChar();

        // 32-bit integer equivalent of ABCD
        $int32 = 0x44434241;

        // 32-bit tests
        $data = [
            '0, Byte Size = 1'      => [ 0,      1, $nullChar ],
            '32-Bit, Byte Size = 0' => [ $int32, 0, '' ],
            '32-Bit, Byte Size = 1' => [ $int32, 1, 'A' ],
            '32-Bit, Byte Size = 2' => [ $int32, 2, 'AB' ],
            '32-Bit, Byte Size = 3' => [ $int32, 3, 'ABC' ],
            '32-Bit, Byte Size = 4' => [ $int32, 4, 'ABCD' ],
            '32-Bit, Byte Size = 5' => [ $int32, 5, 'ABCD' . $nullChar ],
            '32-Bit, Byte Size = 6' => [ $int32, 6, 'ABCD' . $nullChar . $nullChar ],
            '32-Bit, Byte Size = 7' => [ $int32, 7, 'ABCD' . $nullChar . $nullChar . $nullChar ],
            '32-Bit, Byte Size = 8' => [ $int32, 8, 'ABCD' . $nullChar . $nullChar . $nullChar . $nullChar ]
        ];

        // 64-bit architecture
        if ( 8 === PHP_INT_SIZE )
        {
            // 64-bit integer equivalent of ABCDEFGH
            $int64 = 0x4847464500000000 + $int32;

            // 64-bit tests
            $data = array_merge(
                $data,
                [
                    '64-Bit, Byte Size = 5'  => [ $int64, 5,  'ABCDE' ],
                    '64-Bit, Byte Size = 6'  => [ $int64, 6,  'ABCDEF' ],
                    '64-Bit, Byte Size = 7'  => [ $int64, 7,  'ABCDEFG' ],
                    '64-Bit, Byte Size = 8'  => [ $int64, 8,  'ABCDEFGH' ],
                    '64-Bit, Byte Size = 9'  => [ $int64, 9,  'ABCDEFGH' . $nullChar ],
                    '64-Bit, Byte Size = 10' => [ $int64, 10, 'ABCDEFGH' . $nullChar . $nullChar ],
                    '64-Bit, Byte Size = 11' => [ $int64, 11, 'ABCDEFGH' . $nullChar . $nullChar . $nullChar ],
                    '64-Bit, Byte Size = 12' => [ $int64, 12, 'ABCDEFGH' . $nullChar . $nullChar . $nullChar . $nullChar ]
                ]
            );
        }

        return $data;
    }


    /**
     * Test __construct( string )
     * 
     * @dataProvider getStringConstructorTestData
     */
    public function testStringConstructor( string $bytes, string $expectedString )
    {
        $this->assertEquals(
            $expectedString,
            ( new ByteArray( $bytes ))->__toString(),
            '( new ByteArray( string ) )->__toString() did not return the expected string.'
        );
    }

    public function getStringConstructorTestData(): array
    {
        return [
            ''    => [ '',    '' ],
            'ABC' => [ 'ABC', 'ABC' ]
        ];
    }





    /*******************************************************************************************************************
    *                                                        clone()
    *******************************************************************************************************************/


    /**
     * Ensure clone() the exact same ByteArray
     * 
     * @dataProvider getCloneTestData()
     */
    public function testClone( ByteArray $byteArray )
    {
        $this->assertEquals(
            $byteArray->__toString(),
            $byteArray->clone()->__toString(),
            'ByteArray->clone() did not return the expected value.'
        );
    }

    public function getCloneTestData(): array
    {
        return [
            '0' => [
                new ByteArray( 0 )
            ],
            '1' => [
                new ByteArray( 1 )
            ],
            'A' => [
                new ByteArray( 'A' )
            ],
            'XYZ' => [
                new ByteArray( 'XYZ' )
            ]
        ];
    }





    /*******************************************************************************************************************
    *                                                     count()
    *******************************************************************************************************************/


    /**
     * Test count return value
     * 
     * @dataProvider getCountTestData
     */
    public function testCount( $bytes, int $expected )
    {
        $this->assertEquals(
            $expected,
            ( new ByteArray( $bytes ))->count(),
            'ByteArray->count() did not return the expected result.'
        );
    }

    public function getCountTestData(): array
    {
        return [
            '' => [
                '',
                0
            ],
            'ABC' => [
                'ABC',
                3
            ],
            'foobar' => [
                'foobar',
                6
            ],

            // Hash algorithm count = bit size / bits per byte
            'md5' => [
                hash( 'md5', 'foobar', true ),
                ( 128 / 8 )
            ],
            'sha1' => [
                hash( 'sha1', 'foobar', true ),
                ( 160 / 8 )
            ],
            'sha256' => [
                hash( 'sha256', 'foobar', true ),
                ( 256 / 8 )
            ]
        ];
    }





    /*******************************************************************************************************************
    *                                                   IEquatable Tests
    *******************************************************************************************************************/

    use IEquatableTestTrait;


    public function getEqualsTestData(): array
    {
        $byteArray0 = new ByteArray(0);
        return [
            'ByteArray(0)->equals(0)'                  => [ $byteArray0,                 0,                       false ],
            'ByteArray(0)->equals(itself)'             => [ $byteArray0,                 $byteArray0,             true ],
            'ByteArray(0)->equals(ByteArray(0))'       => [ $byteArray0,                 new ByteArray(0),  true ],
            'ByteArray(255, 1)->equals(ByteArray(""))' => [ new ByteArray(255, 1), new ByteArray(''), false ],
            'ByteArray(255, 0)->equals(ByteArray(""))' => [ new ByteArray(255, 0), new ByteArray(''), true ]
        ];
    }


    public function getHashTestData(): array
    {
        $byteArray1 = new ByteArray(1);
        $byteArray2 = new ByteArray(2);
        return [
            'ByteArray(1)->hash() === ByteArray(0)' => [ $byteArray1, new ByteArray(0), false ],
            'ByteArray(1)->hash() === ByteArray(1)' => [ $byteArray1, new ByteArray(1), true ],
            'ByteArray(2)->hash() === ByteArray(1)' => [ $byteArray2, new ByteArray(1), false ],
            'ByteArray(2)->hash() === ByteArray(2)' => [ $byteArray2, new ByteArray(2), true ]
        ];
    }


    public function getEqualsAndHashConsistencyTestData(): array
    {
        $byteArray1 = new ByteArray(1);
        $byteArray2 = new ByteArray(2);
        return [
            'ByteArray(1), itself'       => [ $byteArray1, $byteArray1 ],
            'ByteArray(1), ByteArray(1)' => [ $byteArray1, new ByteArray(1) ],
            'ByteArray(2), itself'       => [ $byteArray2, $byteArray2 ],
            'ByteArray(2), ByteArray(2)' => [ $byteArray2, new ByteArray(2) ]
        ];
    }





    /*******************************************************************************************************************
    *                                                    getIterator()
    *******************************************************************************************************************/


    /**
     * Ensure ByteArray->getIterator() returns an ArrayableIterator
     */
    public function testGetIterator()
    {
        $this->assertInstanceOf(
            ArrayableIterator::class,
            ( new ByteArray( 'ABC' ) )->getIterator(),
            'ByteArray->getIterator() did not return an ArrayableIterator instance.'
        );
    }





    /*******************************************************************************************************************
    *                                                     toArray()
    *******************************************************************************************************************/


    /**
     * Test toArray return value
     * 
     * @dataProvider getToArrayTestData
     */
    public function testToArray( $bytes, array $expected )
    {
        $this->assertEquals(
            $expected,
            ( new ByteArray( $bytes ))->toArray(),
            'ByteArray->toArray() did not return the expected array.'
        );
    }

    public function getToArrayTestData(): array
    {
        return [
            '' => [
                '',
                []
            ],
            'ABC' => [
                'ABC',
                [
                    new Byte( 65 ),
                    new Byte( 66 ),
                    new Byte( 67 )
                ]
            ],
            'abc' => [
                'abc',
                [
                    new Byte( 97 ),
                    new Byte( 98 ),
                    new Byte( 99 )
                ]
            ]
        ];
    }





    /*******************************************************************************************************************
    *                                                        toInt()
    *******************************************************************************************************************/


    /**
     * Ensure toInt() returns the expected value
     * 
     * @dataProvider getToIntTestData()
     */
    public function testToInt( ByteArray $byteArray, int $expected )
    {
        $this->assertEquals(
            $expected,
            $byteArray->toInt(),
            'ByteArray->toInt() did not return the expected value.'
        );
    }

    public function getToIntTestData(): array
    {
        return [
            '0' => [
                new ByteArray( 0 ),
                0
            ],
            '1' => [
                new ByteArray( 1 ),
                1
            ],
            '2' => [
                new ByteArray( 2 ),
                2
            ],
            '3' => [
                new ByteArray( 3 ),
                3
            ],
            'A' => [
                new ByteArray( 'A' ),
                0x00000041
            ],
            'XYZ' => [
                new ByteArray( 'XYZ' ),
                0x005A5958
            ]
        ];
    }





    /*******************************************************************************************************************
    *                                                       UTILITIES
    *******************************************************************************************************************/


    /**
     * Retrieve the null character
     * 
     * @return string
     */
    private static function getNullChar(): string
    {
        static $nullChar = null;
        if ( null === $nullChar ) {
            $nullChar = pack( 'x' );
        }
        return $nullChar;
    }
}