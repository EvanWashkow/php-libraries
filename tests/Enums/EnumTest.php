<?php
declare(strict_types=1);

namespace PHP\Tests\Enums;

use PHP\Collections\Dictionary;
use PHP\Enums\Enum;
use PHP\ObjectClass;
use PHP\Tests\Enums\TestEnumDefinitions\MaltypedIntegerEnum;
use PHP\Tests\Enums\TestEnumDefinitions\MaltypedStringEnum;
use PHP\Tests\Enums\TestEnumDefinitions\GoodIntegerEnum;
use PHP\Tests\Enums\TestEnumDefinitions\GoodStringEnum;
use PHP\Tests\Enums\TestEnumDefinitions\GoodEnum;
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
            new GoodEnum( GoodEnum::NUMBERS ),
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
            'GoodEnum' => [
                GoodEnum::getConstants(),
                [
                    'STRING'  => GoodEnum::STRING,
                    'NUMBERS' => GoodEnum::NUMBERS,
                    'ARRAY'   => GoodEnum::ARRAY
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
            'new GoodEnum( GoodEnum::STRING )' => [function() {
                return new GoodEnum( GoodEnum::STRING );
            }],
            'new GoodEnum( GoodEnum::NUMBERS )' => [function() {
                return new GoodEnum( GoodEnum::NUMBERS );
            }],
            'new GoodEnum( GoodEnum::ARRAY )' => [function() {
                return new GoodEnum( GoodEnum::ARRAY );
            }],
            'new GoodIntegerEnum( GoodIntegerEnum::ONE )' => [function() {
                return new GoodIntegerEnum( GoodIntegerEnum::ONE );
            }],
            'new GoodStringEnum( GoodStringEnum::ONE )' => [function() {
                return new GoodStringEnum( GoodStringEnum::ONE );
            }]
        ];
    }


    /**
     * Test the DomainException when constructing an Enum
     * 
     * @dataProvider getConstructorDomainExceptionData()
     * @expectedException \DomainException
     */
    public function testConstructorDomainException( \Closure $callback )
    {
        $callback();
    }

    public function getConstructorDomainExceptionData(): array
    {
        return [
            'new GoodEnum( GoodEnum::NUMBERS )' => [function() {
                $numbers = GoodEnum::NUMBERS;
                return new GoodEnum( "$numbers" );
            }],
            'new GoodEnum( GoodEnum::ARRAY )' => [function() {
                return new GoodEnum( GoodEnum::GetStringArray() );
            }],
            'new GoodIntegerEnum( 100 )' => [function() {
                return new GoodIntegerEnum( 100 );
            }],
            'new GoodStringEnum( \'stryng\' )' => [function() {
                return new GoodStringEnum( 'stryng' );
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

            // GoodEnum
            'new GoodEnum( NUMBERS )->equals( NUMBERS )' => [
                new GoodEnum( GoodEnum::NUMBERS ),
                GoodEnum::NUMBERS,
                true
            ],
            'new GoodEnum( NUMBERS )->equals( <same enum> )' => [
                new GoodEnum( GoodEnum::NUMBERS ),
                new GoodEnum( GoodEnum::NUMBERS ),
                true
            ],
            'new GoodEnum( NUMBERS )->equals( (string) NUMBERS )' => [
                new GoodEnum( GoodEnum::NUMBERS ),
                '' . GoodEnum::NUMBERS,
                false
            ],
            'new GoodEnum( ARRAY )->equals( ARRAY )' => [
                new GoodEnum( GoodEnum::ARRAY ),
                GoodEnum::ARRAY,
                true
            ],
            'new GoodEnum( ARRAY )->equals( <same enum> )' => [
                new GoodEnum( GoodEnum::ARRAY ),
                new GoodEnum( GoodEnum::ARRAY ),
                true
            ],
            'new GoodEnum( ARRAY )->equals( (string) ARRAY )' => [
                new GoodEnum( GoodEnum::ARRAY ),
                GoodEnum::GetStringArray(),
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
            'GoodEnum::ARRAY' => [
                new GoodEnum( GoodEnum::ARRAY ),
                GoodEnum::ARRAY,
                true
            ],
            'GoodEnum::GetStringArray()' => [
                new GoodEnum( GoodEnum::ARRAY ),
                GoodEnum::GetStringArray(),
                false
            ]
        ];
    }
}