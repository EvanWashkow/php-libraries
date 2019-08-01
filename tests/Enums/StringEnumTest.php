<?php
declare( strict_types = 1 );

namespace PHP\Tests\Enums;

use PHP\Enums\Enum;
use PHP\Enums\StringEnum;
use PHP\Tests\Enums\StringEnumTest\BadStringEnum;
use PHP\Tests\Enums\StringEnumTest\GoodStringEnum;
use PHPUnit\Framework\TestCase;

/**
 * Test Enum class
 */
class StringEnumTest extends TestCase
{

    /***************************************************************************
    *                              __construct()
    ***************************************************************************/


    /**
     * Test class inheritance
     */
    public function testIsEnum()
    {
        $this->assertInstanceOf(
            Enum::class,
            new GoodStringEnum( GoodStringEnum::A ),
            'StringEnum is not an Enum'
        );
    }


    /**
     * Test bad constant exception
     * 
     * @expectedException \DomainException
     */
    public function testBadConstantException()
    {
        new BadStringEnum( BadStringEnum::A );
    }




    /***************************************************************************
    *                                    getValue()
    ***************************************************************************/


    /**
     * Test the construction of Enums
     * 
     * @dataProvider getGetValueData()
     */
    public function testGetValue( StringEnum $enum, $value )
    {
        $this->assertEquals(
            $value,
            $enum->getValue(),
            'StringEnum->getValue() did not return the expected value'
        );
    }

    public function getGetValueData(): array
    {
        return [
            'new GoodStringEnum( GoodStringEnum::A )' => [
                new GoodStringEnum( GoodStringEnum::A ),
               GoodStringEnum::A
            ],
            'new GoodStringEnum( GoodStringEnum::B )' => [
                new GoodStringEnum( GoodStringEnum::B ),
               GoodStringEnum::B
            ],
            'new GoodStringEnum( GoodStringEnum::C )' => [
                new GoodStringEnum( GoodStringEnum::C ),
               GoodStringEnum::C
            ]
        ];
    }
}