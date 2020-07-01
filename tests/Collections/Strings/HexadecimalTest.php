<?php
declare( strict_types = 1 );

namespace PHP\Tests\Collections\Strings;

use PHP\Collections\ByteArray;
use PHP\Collections\Strings\Hexadecimal;
use PHP\Interfaces\IStringable;
use PHP\ObjectClass;
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
}
