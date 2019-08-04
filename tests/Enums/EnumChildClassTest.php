<?php
declare( strict_types = 1 );

namespace PHP\Tests\Enums;

use PHP\Enums\Enum;
use PHP\Tests\Enums\IntegerEnumTest\BadIntegerEnum;
use PHP\Tests\Enums\IntegerEnumTest\GoodIntegerEnum;
use PHP\Tests\Enums\StringEnumTest\BadStringEnum;
use PHP\Tests\Enums\StringEnumTest\GoodStringEnum;
use PHPUnit\Framework\TestCase;

/**
 * Ensures consistent behavior for all Enum child classes
 */
class EnumChildClassTest extends TestCase
{

    /***************************************************************************
    *                              __construct()
    ***************************************************************************/


    /**
     * Test class inheritance
     * 
     * @dataProvider getIsEnumData
     */
    public function testIsEnum( Enum $enum )
    {
        $this->assertInstanceOf(
            Enum::class,
            $enum,
            'Enum child class is not an Enum'
        );
    }

    public function getIsEnumData(): array
    {
        return [
            'IntegerEnum' => [
                new GoodIntegerEnum( GoodIntegerEnum::ONE )
            ],
            'StringEnum' => [
                new GoodStringEnum( GoodStringEnum::A )
            ]
        ];
    }


    /**
     * Test bad constant exception
     * 
     * @dataProvider      getBadConstantException
     * @expectedException \DomainException
     */
    public function testBadConstantException( \Closure $callback )
    {
        $callback();
    }

    public function getBadConstantException(): array
    {
        return [
            'IntegerEnum' => [
                function() { new BadIntegerEnum( BadIntegerEnum::A ); }
            ],
            'StringEnum' => [
                function() { new BadStringEnum( BadStringEnum::A ); }
            ]
        ];
    }
}