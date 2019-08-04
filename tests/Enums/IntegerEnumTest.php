<?php
declare( strict_types = 1 );

namespace PHP\Tests\Enums;

use PHP\Enums\Enum;
use PHP\Enums\IntegerEnum;
use PHP\Tests\Enums\IntegerEnumTest\BadIntegerEnum;
use PHP\Tests\Enums\IntegerEnumTest\GoodIntegerEnum;
use PHPUnit\Framework\TestCase;

/**
 * Test Enum class
 */
class IntegerEnumTest extends TestCase
{

    /***************************************************************************
    *                              __construct()
    ***************************************************************************/


    /**
     * Test bad constant exception
     * 
     * @expectedException \DomainException
     */
    public function testBadConstantException()
    {
        new BadIntegerEnum( BadIntegerEnum::A );
    }




    /***************************************************************************
    *                                    getValue()
    ***************************************************************************/


    /**
     * Test the construction of Enums
     * 
     * @dataProvider getGetValueData()
     */
    public function testGetValue( IntegerEnum $enum, $value )
    {
        $this->assertEquals(
            $value,
            $enum->getValue(),
            'IntegerEnum->getValue() did not return the expected value'
        );
    }

    public function getGetValueData(): array
    {
        return [
            'new GoodIntegerEnum( GoodIntegerEnum::ONE )' => [
                new GoodIntegerEnum( GoodIntegerEnum::ONE ),
               GoodIntegerEnum::ONE
            ],
            'new GoodIntegerEnum( GoodIntegerEnum::TWO )' => [
                new GoodIntegerEnum( GoodIntegerEnum::TWO ),
               GoodIntegerEnum::TWO
            ],
            'new GoodIntegerEnum( GoodIntegerEnum::FOUR )' => [
                new GoodIntegerEnum( GoodIntegerEnum::FOUR ),
               GoodIntegerEnum::FOUR
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
        $enum = new GoodIntegerEnum( GoodIntegerEnum::ONE );
        $enum->setValue( GoodIntegerEnum::TWO );
        $this->assertEquals(
            GoodIntegerEnum::TWO,
            $enum->getValue(),
            'IntegerEnum->setValue() did not set'
        );
    }

    /**
     * Test that setting a value returns the value
     */
    public function testSetValueReturn()
    {
        $enum = new GoodIntegerEnum( GoodIntegerEnum::ONE );
        $this->assertEquals(
            GoodIntegerEnum::TWO,
            $enum->setValue( GoodIntegerEnum::TWO ),
            'IntegerEnum->setValue() did not return the value that was set'
        );
    }

    /**
     * Test that setting a value throws an exception
     * 
     * @expectedException \DomainException
     */
    public function testSetValueDomainException()
    {
        ( new GoodIntegerEnum( GoodIntegerEnum::ONE ))->setValue( 3 );
    }

    /**
     * Test that setting a value throws an invalid argument exception
     * 
     * @expectedException \InvalidArgumentException
     */
    public function testSetValueInvalidArgumentException()
    {
        ( new GoodIntegerEnum( GoodIntegerEnum::ONE ))->setValue( 'string' );
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
            ( new GoodIntegerEnum( GoodIntegerEnum::ONE ))->getConstants()->getKeyType()->getName(),
            "IntegerEnum constant dictionary key type was not a string."
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
            'int',
            ( new GoodIntegerEnum( GoodIntegerEnum::ONE ))->getConstants()->getValueType()->getName(),
            "IntegerEnum constant dictionary value type was not a string."
        );
    }
}