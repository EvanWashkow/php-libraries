<?php
declare( strict_types = 1 );

namespace PHP\Tests\Collections\Strings;

use PHP\Collections\ByteArray;
use PHP\Collections\Strings\Hexadecimal;
use PHP\Interfaces\IStringable;
use PHP\ObjectClass;
use PHP\Tests\Interfaces\IEquatableTestTrait;
use PHPUnit\Framework\TestCase;

class HexadecimalTest extends TestCase
{


    /**
     * Ensure Hexadecimal is of  the expected parent types
     * 
     * @dataProvider getInheritanceTestData
     */
    public function testInheritance( string $typeName )
    {
        $this->assertInstanceOf(
            $typeName,
            new Hexadecimal( new ByteArray( 'ABC' ) ),
            Hexadecimal::class . " is not of type {$typeName}"
        );
    }

    public function getInheritanceTestData(): array
    {
        return [
            ObjectClass::class => [ ObjectClass::class ],
            IStringable::class => [ IStringable::class ]
        ];
    }


    /**
     * Test __toString()
     * 
     * @dataProvider getToStringTestData
     */
    public function testToString( ByteArray $byteArray, string $expected )
    {
        $this->assertEquals(
            $expected,
            ( new Hexadecimal( $byteArray ))->__toString(),
            'Hexadecimal->__toString() did not return the expected hexadecimal string'
        );
    }

    public function getToStringTestData(): array
    {
        return [
            'A' => [
                new ByteArray( 'A' ),
                '41'
            ],
            'B' => [
                new ByteArray( 'B' ),
                '42'
            ],
            'C' => [
                new ByteArray( 'C' ),
                '43'
            ],
            ':' => [
                new ByteArray( ':' ),
                '3a'
            ],
            ';' => [
                new ByteArray( ';' ),
                '3b'
            ],
            '?' => [
                new ByteArray( '?' ),
                '3f'
            ],
            'ABC:;?' => [
                new ByteArray( 'ABC:;?' ),
                '4142433a3b3f'
            ],
            0x6e617645 => [
                new ByteArray( 0x6e617645, 4 ), // Hexadecimal notation is little-endian
                '4576616e'                      // Hexadecimal strings are big-endian
            ],
            0x4100 => [
                new ByteArray( 0x4100, 2 ),
                '0041'
            ],
            0x0041 => [
                new ByteArray( 0x0041, 2 ),
                '4100'
            ],
            0x41 => [
                new ByteArray( 0x41, 4 ),
                '41000000'
            ]
        ];
    }





    /*******************************************************************************************************************
     *                                                   IEquatable Tests
     *******************************************************************************************************************/

    use IEquatableTestTrait;


    public function getEqualsTestData(): array
    {
        return [
        ];
    }


    public function getHashTestData(): array
    {
        return [
        ];
    }


    public function getEqualsAndHashConsistencyTestData(): array
    {
        return [
        ];
    }
}
