<?php
declare( strict_types = 1 );

namespace PHP\Tests\Enums;

use PHP\Enums\Enum;
use PHP\Tests\Enums\TestEnumDefinitions\BadIntegerEnum;
use PHP\Tests\Enums\TestEnumDefinitions\GoodIntegerEnum;
use PHP\Tests\Enums\TestEnumDefinitions\BadStringEnum;
use PHP\Tests\Enums\TestEnumDefinitions\GoodStringEnum;
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
                new GoodStringEnum( GoodStringEnum::ONE )
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
                function() { new BadIntegerEnum( BadIntegerEnum::NUMBERS ); }
            ],
            'StringEnum' => [
                function() { new BadStringEnum( BadStringEnum::A ); }
            ]
        ];
    }




    /***************************************************************************
    *                                    getValue()
    ***************************************************************************/


    /**
     * Test getting Enum values
     * 
     * @dataProvider getGetValueData()
     */
    public function testGetValue( Enum $enum, $value, bool $expected )
    {
        $this->assertEquals(
            $expected,
            $enum->getValue() === $value,
            '<Enum child class>->getValue() did not return the expected value'
        );
    }

    public function getGetValueData(): array
    {
        return [

            // IntegerEnum
            'new GoodIntegerEnum( GoodIntegerEnum::ONE )' => [
                new GoodIntegerEnum( GoodIntegerEnum::ONE ),
               GoodIntegerEnum::ONE,
               true
            ],
            'new GoodIntegerEnum( GoodIntegerEnum::ONE )' => [
                new GoodIntegerEnum( GoodIntegerEnum::ONE ),
               GoodStringEnum::ONE,
               false
            ],

            // StringEnum
            'new GoodStringEnum( GoodStringEnum::ONE )' => [
                new GoodStringEnum( GoodStringEnum::ONE ),
               GoodStringEnum::ONE,
               true
            ],
            'new GoodStringEnum( GoodStringEnum::ONE )' => [
                new GoodStringEnum( GoodStringEnum::ONE ),
               GoodIntegerEnum::ONE,
               false
            ]
        ];
    }




    /***************************************************************************
    *                                    getConstants()
    ***************************************************************************/


    /**
     * Test get constants key type
     * 
     * If constants were broken, other tests would prove the same
     * 
     * @dataProvider getConstantsKeyTypeData
     */
    public function testGetConstantsKeyType( Enum $enum )
    {
        $this->assertEquals(
            'string',
            $enum->getConstants()->getKeyType()->getName(),
            "Enum child class constant dictionary key type was not a string."
        );
    }

    public function getConstantsKeyTypeData(): array
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


    /**
     * Test get constants value type
     * 
     * If constants were broken, other tests would prove the same
     * 
     * @dataProvider getConstantsValueTypeData
     */
    public function testGetConstantsValueType( Enum $enum, string $type )
    {
        $this->assertEquals(
            $type,
            $enum->getConstants()->getValueType()->getName(),
            "Enum child class constant dictionary value type was not the expected type."
        );
    }

    public function getConstantsValueTypeData(): array
    {
        return [
            'IntegerEnum' => [
                new GoodIntegerEnum( GoodIntegerEnum::ONE ),
                'int'
            ],
            'StringEnum' => [
                new GoodStringEnum( GoodStringEnum::ONE ),
                'string'
            ]
        ];
    }
}