<?php
declare( strict_types = 1 );

namespace PHP\Tests\Enums;

use PHP\Enums\Enum;
use PHP\Tests\Enums\TestEnumDefinitions\GoodIntegerEnum;
use PHP\Tests\Enums\TestEnumDefinitions\GoodStringEnum;
use PHPUnit\Framework\TestCase;

/**
 * Ensures consistent behavior for all Enum child classes
 */
class EnumChildClassTest extends TestCase
{




    /*******************************************************************************************************************
    *                                                 INHERITANCE
    *******************************************************************************************************************/


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
                new GoodStringEnum( GoodStringEnum::ONE )
            ]
        ];
    }
}