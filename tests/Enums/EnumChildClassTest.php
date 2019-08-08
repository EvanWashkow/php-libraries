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




    /***************************************************************************
    *                                    getValue()
    ***************************************************************************/


    /**
     * Test getting Enum values
     * 
     * @dataProvider getGetValueData()
     */
    public function testGetValue( Enum $enum, $value )
    {
        $this->assertTrue(
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
               GoodIntegerEnum::ONE
            ],

            // StringEnum
            'new GoodStringEnum( GoodStringEnum::A )' => [
                new GoodStringEnum( GoodStringEnum::A ),
               GoodStringEnum::A
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
            $newValue === $enum->setValue( $newValue )->getValue(),
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
            $enum === $enum->setValue( $newValue ),
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
                new GoodStringEnum( GoodStringEnum::A ),
                GoodStringEnum::B
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
                    ( new GoodStringEnum( GoodStringEnum::A ))->setValue( 'dummy' );
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
                    ( new GoodStringEnum( GoodStringEnum::A ))->setValue( 1 );
                }
            ]
        ];
    }
}