<?php
declare( strict_types = 1 );

namespace PHP\Tests\Collections;

use PHP\Collections\ByteArray;
use PHP\Collections\IArrayable;
use PHP\Collections\IReadOnlyCollection;
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
    *                                                    __toString()
    *******************************************************************************************************************/


    /**
     * Test __toString return value
     * 
     * @dataProvider getToStringTestData
     */
    public function testToString( string $string )
    {
        $this->assertEquals(
            $string,
            ( new ByteArray( $string ))->__toString(),
            'ByteArray->__toString() did not return the constructed string.'
        );
    }

    public function getToStringTestData(): array
    {
        return [
            ''       => [ '' ],
            'foobar' => [ 'foobar' ],
            'abc'    => [ 'abc' ]
        ];
    }
}