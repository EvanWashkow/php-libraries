<?php
declare( strict_types = 1 );

namespace PHP\Tests\Collections;

use PHP\Byte;
use PHP\Collections\ByteArray;
use PHP\Collections\IArrayable;
use PHP\Collections\IReadOnlyCollection;
use PHP\Collections\Iteration\ArrayableIterator;
use PHP\Interfaces\IStringable;
use PHP\ObjectClass;
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
            ObjectClass::class         => [ ObjectClass::class ],
            IArrayable::class          => [ IArrayable::class ],
            IReadOnlyCollection::class => [ IReadOnlyCollection::class ],
            IStringable::class         => [ IStringable::class ]
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
            \InvalidArgumentException::class => [
                [ 1.5 ], \InvalidArgumentException::class
            ],
            '__construct( 65, 0 ) throws DomainException' => [
                [ 65, 0 ], \DomainException::class
            ],
            '__construct( 65, 9 ) throws DomainException' => [
                [ 65, 9 ], \DomainException::class
            ]
        ];
    }


    /**
     * Test __construct( int )
     * 
     * @dataProvider getIntegerConstructorTestData
     */
    public function testIntegerConstructor( int $bytes, ?int $byteLength, string $expectedString )
    {
        $this->assertEquals(
            $expectedString,
            ( new ByteArray( $bytes ))->__toString(),
            'ByteArray->__toString() did not return the expected string.'
        );
    }

    public function getIntegerConstructorTestData(): array
    {
        return [
            '(int)A' => [ 65, 1, 'A' ],
            '(int)B' => [ 66, 1, 'B' ],
            '(int)C' => [ 67, 1, 'C' ]
        ];
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
            'ByteArray->__toString() did not return the expected string.'
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
}