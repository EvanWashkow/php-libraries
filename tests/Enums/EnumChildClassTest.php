<?php
declare( strict_types = 1 );

namespace PHP\Tests\Enums;

use PHP\Enums\Enum;
use PHP\Tests\Enums\IntegerEnumTest\GoodIntegerEnum;
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
     * @dataProvider getTestIsEnumData
     */
    public function testIsEnum( Enum $enum )
    {
        $this->assertInstanceOf(
            Enum::class,
            $enum,
            'Enum child class is not an Enum'
        );
    }

    public function getTestIsEnumData(): array
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
}