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
                function() { new BadIntegerEnum( BadIntegerEnum::A ); }
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
    *                                    setValue()
    ***************************************************************************/

    /**
     * Test that setting a value works
     * 
     * @dataProvider getSetValueData
     */
    public function testSetValue( Enum $enum, $newValue )
    {
        $this->assertTrue(
            $enum->setValue( $newValue )->getValue() === $newValue,
            'Enum child class ->setValue() did not set'
        );
    }


    /**
     * Test that setting a value returns the value
     * 
     * @dataProvider getSetValueData
     */
    public function testSetValueReturn( Enum $enum, $newValue )
    {
        $this->assertTrue(
            $enum->setValue( $newValue ) === $enum,
            'Enum child class ->setValue() did not return its own value'
        );
    }


    /**
     * Shared setValue() data provider
     */
    public function getSetValueData(): array
    {
        return [
            'IntegerEnum' => [
                new GoodIntegerEnum( GoodIntegerEnum::ONE ),
                GoodIntegerEnum::TWO
            ],
            'StringEnum' => [
                new GoodStringEnum( GoodStringEnum::ONE ),
                GoodStringEnum::ONE
            ]
        ];
    }


    /**
     * Test that setting a value throws an exception
     * 
     * @dataProvider getSetValueDomainExceptionData
     * @expectedException \DomainException
     */
    public function testSetValueDomainException( \Closure $callback )
    {
        $callback();
    }

    public function getSetValueDomainExceptionData(): array
    {
        return [
            'IntegerEnum' => [
                function() {
                    ( new GoodIntegerEnum( GoodIntegerEnum::ONE ))->setValue( 3 );
                }
            ],
            'StringEnum' => [
                function() {
                    ( new GoodStringEnum( GoodStringEnum::ONE ))->setValue( 'dummy' );
                }
            ]
        ];
    }


    /**
     * Test that setting a value throws an invalid argument exception
     * 
     * @dataProvider getSetValueInvalidArgumentExceptionData
     * @expectedException \InvalidArgumentException
     */
    public function testSetValueInvalidArgumentException( \Closure $callback )
    {
        $callback();
    }

    public function getSetValueInvalidArgumentExceptionData(): array
    {
        return [
            'IntegerEnum' => [
                function() {
                    ( new GoodIntegerEnum( GoodIntegerEnum::ONE ))->setValue( 'string' );
                }
            ],
            'StringEnum' => [
                function() {
                    ( new GoodStringEnum( GoodStringEnum::ONE ))->setValue( 1 );
                }
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