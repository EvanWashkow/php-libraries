<?php
declare(strict_types=1);

namespace PHP\Tests\Enums;

use PHP\Collections\Dictionary;
use PHP\Enums\Enum;
use PHP\ObjectClass;
use PHP\Tests\Enums\TestEnumDefinitions\BadIntegerEnum;
use PHP\Tests\Enums\TestEnumDefinitions\BadStringEnum;
use PHP\Tests\Enums\TestEnumDefinitions\GoodIntegerEnum;
use PHP\Tests\Enums\TestEnumDefinitions\GoodStringEnum;
use PHP\Tests\Enums\TestEnumDefinitions\MixedEnum;
use PHPUnit\Framework\TestCase;

/**
 * Test Enum class
 */
class EnumTest extends TestCase
{




    /*******************************************************************************************************************
    *                                                  INHERITANCE
    *******************************************************************************************************************/


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




    /*******************************************************************************************************************
    *                                                  getConstants()
    *******************************************************************************************************************/


    /**
     * Test the results of getConstants()
     * 
     * @dataProvider getConstantsData()
     */
    public function testGetConstants( Dictionary $constants, array $expected )
    {
        $this->assertEquals(
            $expected,
            $constants->toArray(),
            'Enum::getConstants() did not return the expected results.'
        );
    }


    public function getConstantsData(): array
    {
        return [

            /**
             * Test good enums
             * 
             * Note: private constants should NOT be returned.
             */
            'MixedEnum' => [
                MixedEnum::getConstants(),
                [
                    'STRING'  => MixedEnum::STRING,
                    'NUMBERS' => MixedEnum::NUMBERS,
                    'ARRAY'   => MixedEnum::ARRAY
                ]
            ],
            'GoodIntegerEnum' => [
                GoodIntegerEnum::getConstants(),
                [
                    'ONE' => GoodIntegerEnum::ONE,
                    'TWO' => GoodIntegerEnum::TWO,
                    'FOUR' => GoodIntegerEnum::FOUR
                ]
            ],
            'GoodStringEnum' => [
                GoodStringEnum::getConstants(),
                [
                    'ONE' => GoodStringEnum::ONE,
                    'TWO' => GoodStringEnum::TWO,
                    'FOUR' => GoodStringEnum::FOUR
                ]
            ],

            // Test bad enums (yes, these should work)
            'BadIntegerEnum' => [
                BadIntegerEnum::getConstants(),
                [
                    'A' => BadIntegerEnum::A,
                    'NUMBERS' => BadIntegerEnum::NUMBERS
                ]
            ],
            'BadStringEnum' => [
                BadStringEnum::getConstants(),
                [
                    'A' => BadStringEnum::A,
                    'NUMBERS' => BadStringEnum::NUMBERS
                ]
            ]
        ];
    }




    /*******************************************************************************************************************
    *                                                  __construct()
    *******************************************************************************************************************/


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
                $numbers = MixedEnum::NUMBERS;
                return new MixedEnum( "$numbers" );
            }],
            'new MixedEnum( MixedEnum::ARRAY )' => [function() {
                return new MixedEnum( MixedEnum::GetStringArray() );
            }]
        ];
    }




    /*******************************************************************************************************************
    *                                                    equals()
    *******************************************************************************************************************/

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
        return [

            // MixedEnum
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
                MixedEnum::GetStringArray(),
                false
            ],


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




    /*******************************************************************************************************************
    *                                                     getValue()
    *******************************************************************************************************************/


    /**
     * Test the construction of Enums
     * 
     * @dataProvider getGetValueData()
     */
    public function testGetValue( Enum $enum, $value, bool $expected )
    {
        $this->assertEquals(
            $expected,
            $enum->getValue() === $value,
            'Enum->getValue() did not return the expected value'
        );
    }

    public function getGetValueData(): array
    {
        return [
            'MixedEnum::ARRAY' => [
                new MixedEnum( MixedEnum::ARRAY ),
                MixedEnum::ARRAY,
                true
            ],
            'MixedEnum::GetStringArray()' => [
                new MixedEnum( MixedEnum::ARRAY ),
                MixedEnum::GetStringArray(),
                false
            ]
        ];
    }
}