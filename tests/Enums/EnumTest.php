<?php
declare( strict_types = 1 );

namespace PHP\Tests\Enums;

use PHP\Enums\Enum;
use PHP\ObjectClass;
use PHP\Tests\Enums\EnumTest\MixedEnum;
use PHPUnit\Framework\TestCase;

/**
 * Test Enum class
 */
class EnumTest extends TestCase
{

    /***************************************************************************
    *                              __construct()
    ***************************************************************************/


    /**
     * Test class inheritance
     */
    public function testIsObjectClass()
    {
        $this->assertInstanceOf(
            ObjectClass::class,
            new MixedEnum( MixedEnum::NUMBERS ),
            'Enum is not an ObjectClass'
        );
    }


    /**
     * Test the construction of Enums
     * 
     * @dataProvider getConstructorData()
     */
    public function testConstructor( \Closure $callback )
    {
        $this->assertInstanceOf(
            Enum::class,
            $callback(),
            'Enum Constructor failed unexpectedly'
        );
    }

    public function getConstructorData(): array
    {
        return [
            'new MixedEnum( MixedEnum::STRING )' => [function() {
                return new MixedEnum( MixedEnum::STRING );
            }],
            'new MixedEnum( MixedEnum::NUMBERS )' => [function() {
                return new MixedEnum( MixedEnum::NUMBERS );
            }],
            'new MixedEnum( MixedEnum::ARRAY )' => [function() {
                return new MixedEnum( MixedEnum::ARRAY );
            }]
        ];
    }


    /**
     * Test the DomainException when constructing an Enum
     * 
     * @dataProvider getConstructorExceptionData()
     * @expectedException \DomainException
     */
    public function testConstructorException( \Closure $callback )
    {
        $callback();
    }

    public function getConstructorExceptionData(): array
    {
        return [
            'new MixedEnum( MixedEnum::NUMBERS )' => [function() {
                return new MixedEnum( "MixedEnum::NUMBERS" );
            }],
            'new MixedEnum( MixedEnum::ARRAY )' => [function() {
                $stringArray = [];
                foreach ( MixedEnum::ARRAY as $value ) {
                    $stringArray[] = "$value";
                }
                return new MixedEnum( $stringArray );
            }]
        ];
    }




    /***************************************************************************
    *                                    equals()
    ***************************************************************************/

    /**
     * Test Enum->equals()
     * 
     * @dataProvider getEqualsData
     */
    public function testEquals( Enum $enum, $value, bool $expected )
    {
        $this->assertEquals(
            $expected,
            $enum->equals( $value ),
            'Enum->equals() did not return the correct result'
        );
    }

    public function getEqualsData(): array
    {
        $stringArray = [];
        foreach ( MixedEnum::ARRAY as $value ) {
            $stringArray[] = "$value";
        }

        return [
            'new MixedEnum( NUMBERS )->equals( NUMBERS )' => [
                new MixedEnum( MixedEnum::NUMBERS ),
                MixedEnum::NUMBERS,
                true
            ],
            'new MixedEnum( NUMBERS )->equals( <same enum> )' => [
                new MixedEnum( MixedEnum::NUMBERS ),
                new MixedEnum( MixedEnum::NUMBERS ),
                true
            ],
            'new MixedEnum( NUMBERS )->equals( (string) NUMBERS )' => [
                new MixedEnum( MixedEnum::NUMBERS ),
                '' . MixedEnum::NUMBERS,
                false
            ],
            'new MixedEnum( ARRAY )->equals( ARRAY )' => [
                new MixedEnum( MixedEnum::ARRAY ),
                MixedEnum::ARRAY,
                true
            ],
            'new MixedEnum( ARRAY )->equals( <same enum> )' => [
                new MixedEnum( MixedEnum::ARRAY ),
                new MixedEnum( MixedEnum::ARRAY ),
                true
            ],
            'new MixedEnum( ARRAY )->equals( (string) ARRAY )' => [
                new MixedEnum( MixedEnum::ARRAY ),
                $stringArray,
                false
            ]
        ];
    }




    /***************************************************************************
    *                                    getValue()
    ***************************************************************************/


    /**
     * Test the construction of Enums
     * 
     * @dataProvider getGetValueData()
     */
    public function testGetValue( Enum $enum, $value )
    {
        $this->assertEquals(
            $value,
            $enum->getValue(),
            'Enum->getValue() did not return the expected value'
        );
    }

    public function getGetValueData(): array
    {
        return [
            'new MixedEnum( MixedEnum::STRING )' => [
                new MixedEnum( MixedEnum::STRING ),
                MixedEnum::STRING
            ],
            'new MixedEnum( MixedEnum::NUMBERS )' => [
                new MixedEnum( MixedEnum::NUMBERS ),
                MixedEnum::NUMBERS
            ],
            'new MixedEnum( MixedEnum::ARRAY )' => [
                new MixedEnum( MixedEnum::ARRAY ),
                MixedEnum::ARRAY
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
        $enum = new MixedEnum( MixedEnum::NUMBERS );
        $enum->setValue( MixedEnum::STRING );
        $this->assertEquals(
            MixedEnum::STRING,
            $enum->getValue(),
            'Enum->setValue() did not set'
        );
    }

    /**
     * Test that setting a value returns the value
     */
    public function testSetValueReturn()
    {
        $enum = new MixedEnum( MixedEnum::NUMBERS );
        $this->assertEquals(
            MixedEnum::STRING,
            $enum->setValue( MixedEnum::STRING ),
            'Enum->setValue() did not return the value that was set'
        );
    }

    /**
     * Test that setting a value throws an exception
     * 
     * @expectedException \DomainException
     */
    public function testSetValueDomainException()
    {
        ( new MixedEnum( MixedEnum::NUMBERS ))->setValue( 'dummy' );
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
            ( new MixedEnum( MixedEnum::NUMBERS ))->getConstants()->getKeyType()->getName(),
            "Enum constant dictionary key type was not a string."
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
            '*',
            ( new MixedEnum( MixedEnum::NUMBERS ))->getConstants()->getValueType()->getName(),
            "Enum constant dictionary value type was not anonymous."
        );
    }
}