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




    /***************************************************************************
    *                                    setValue()
    ***************************************************************************/

    /**
     * Test that setting a value works
     */
    public function testSetValue()
    {
        $enum = new GoodStringEnum( GoodStringEnum::A );
        $enum->setValue( GoodStringEnum::B );
        $this->assertEquals(
            GoodStringEnum::B,
            $enum->getValue(),
            'StringEnum->setValue() did not set'
        );
    }

    /**
     * Test that setting a value returns the value
     */
    public function testSetValueReturn()
    {
        $enum = new GoodStringEnum( GoodStringEnum::A );
        $this->assertEquals(
            GoodStringEnum::B,
            $enum->setValue( GoodStringEnum::B ),
            'StringEnum->setValue() did not return the value that was set'
        );
    }

    /**
     * Test that setting a value throws an exception
     * 
     * @expectedException \DomainException
     */
    public function testSetValueDomainException()
    {
        ( new GoodStringEnum( GoodStringEnum::A ))->setValue( 'dummy' );
    }

    /**
     * Test that setting a value throws an invalid argument exception
     * 
     * @expectedException \InvalidArgumentException
     */
    public function testSetValueInvalidArgumentException()
    {
        ( new GoodStringEnum( GoodStringEnum::A ))->setValue( 1 );
    }




    /***************************************************************************
    *                                    getConstants()
    ***************************************************************************/


    /**
     * Test get constants key type
     * 
     * If constants were broken, other tests would prove the same
     */
    public function testGetConstantsKeyType()
    {
        $this->assertEquals(
            'string',
            ( new GoodStringEnum( GoodStringEnum::A ))->getConstants()->getKeyType()->getName(),
            "StringEnum constant dictionary key type was not a string."
        );
    }


    /**
     * Test get constants value type
     * 
     * If constants were broken, other tests would prove the same
     */
    public function testGetConstantsValueType()
    {
        $this->assertEquals(
            'string',
            ( new GoodStringEnum( GoodStringEnum::A ))->getConstants()->getValueType()->getName(),
            "StringEnum constant dictionary value type was not a string."
        );
    }
}