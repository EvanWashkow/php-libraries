<?php
declare(strict_types=1);

namespace PHP\Tests\Enums;

use PHP\Collections\Dictionary;
use PHP\Enums\Enum;
use PHP\Enums\IntegerEnum;
use PHP\ObjectClass;
use PHP\Tests\Enums\TestEnumDefinitions\GoodBitMapEnum;
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
     * Test the construction of Enums
     * 
     * @dataProvider getEnumTypeData()
     */
    public function testEnumType( Enum $enum, string $enumClass )
    {
        $this->assertInstanceOf(
            $enumClass,
            $enum,
            'Enum Parent Type was not correct'
        );
    }


    public function getEnumTypeData(): array
    {
        return [
            'new GoodEnum( GoodEnum::STRING )' => [
                new GoodEnum( GoodEnum::STRING ),
                ObjectClass::class
            ],
            'new GoodIntegerEnum( GoodIntegerEnum::ONE )' => [
                new GoodIntegerEnum( GoodIntegerEnum::ONE ),
                Enum::class
            ],
            'new GoodStringEnum( GoodStringEnum::ONE )' => [
                new GoodStringEnum( GoodStringEnum::ONE ),
                Enum::class
            ],
            'new GoodBitMapEnum( GoodBitMapEnum::ONE )' => [
                new GoodBitMapEnum( GoodBitMapEnum::ONE ),
                IntegerEnum::class
            ]
        ];
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
            ],
            'GoodBitMapEnum' => [
                GoodBitMapEnum::getConstants(),
                [
                    'ONE' => GoodBitMapEnum::ONE,
                    'TWO' => GoodBitMapEnum::TWO,
                    'FOUR' => GoodBitMapEnum::FOUR
                ]
            ]
        ];
    }




    /*******************************************************************************************************************
    *                                                  __construct()
    *******************************************************************************************************************/


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
            }],
            'new GoodBitMapEnum( 8 )' => [function() {
                return new GoodBitMapEnum( 8 );
            }],
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
            'new GoodEnum( STRING )->equals( STRING )' => [
                new GoodEnum( GoodEnum::STRING ),
                GoodEnum::STRING,
                true
            ],
            'new GoodEnum( STRING )->equals( <same enum> )' => [
                new GoodEnum( GoodEnum::STRING ),
                new GoodEnum( GoodEnum::STRING ),
                true
            ],
            'new GoodEnum( STRING )->equals( (int) STRING )' => [
                new GoodEnum( GoodEnum::STRING ),
                intval( GoodEnum::STRING ),
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
            ],

            // BitMapEnum
            'new GoodBitMapEnum( GoodBitMapEnum::ONE ) === <value>' => [
                new GoodBitMapEnum( GoodBitMapEnum::ONE ),
                GoodBitMapEnum::ONE,
                true
            ],
            'new GoodBitMapEnum( GoodBitMapEnum::TWO ) === <value>' => [
                new GoodBitMapEnum( GoodBitMapEnum::TWO ),
                GoodBitMapEnum::TWO,
                true
            ],
            'new GoodBitMapEnum( GoodBitMapEnum::FOUR ) === <value>' => [
                new GoodBitMapEnum( GoodBitMapEnum::FOUR ),
                GoodBitMapEnum::FOUR,
                true
            ],
            'new GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::TWO ) === <value>' => [
                new GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::TWO ),
                GoodBitMapEnum::ONE | GoodBitMapEnum::TWO,
                true
            ],
            'new GoodBitMapEnum( GoodBitMapEnum::TWO | GoodBitMapEnum::FOUR ) === <value>' => [
                new GoodBitMapEnum( GoodBitMapEnum::TWO | GoodBitMapEnum::FOUR ),
                GoodBitMapEnum::TWO | GoodBitMapEnum::FOUR,
                true
            ],
            'new GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR ) === <value>' => [
                new GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR ),
                GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR,
                true
            ],
            'new GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::TWO | GoodBitMapEnum::FOUR ) === <value>' => [
                new GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::TWO | GoodBitMapEnum::FOUR ),
                GoodBitMapEnum::ONE | GoodBitMapEnum::TWO | GoodBitMapEnum::FOUR,
                true
            ],
            'new GoodBitMapEnum( GoodBitMapEnum::ONE ) === ( string ) <value>' => [
                new GoodBitMapEnum( GoodBitMapEnum::ONE ),
                '' . GoodBitMapEnum::ONE,
                false
            ],
            'new GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR ) === ( string ) <value>' => [
                new GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR ),
                '' . ( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR ),
                false
            ],
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
            'GoodEnum::NUMBERS === GoodEnum::NUMBERS' => [
                new GoodEnum( GoodEnum::NUMBERS ),
                GoodEnum::NUMBERS,
                true
            ],
            'GoodEnum::NUMBERS === (string) GoodEnum::NUMBERS' => [
                new GoodEnum( GoodEnum::NUMBERS ),
                '' . GoodEnum::NUMBERS,
                false
            ],
            'GoodEnum::STRING === GoodEnum::STRING' => [
                new GoodEnum( GoodEnum::STRING ),
                GoodEnum::STRING,
                true
            ],
            'GoodEnum::STRING === (int) GoodEnum::STRING' => [
                new GoodEnum( GoodEnum::STRING ),
                intval( GoodEnum::STRING ),
                false
            ],
            'GoodEnum::ARRAY === GoodEnum::ARRAY' => [
                new GoodEnum( GoodEnum::ARRAY ),
                GoodEnum::ARRAY,
                true
            ],
            'GoodEnum::ARRAY === GoodEnum::GetStringArray()' => [
                new GoodEnum( GoodEnum::ARRAY ),
                GoodEnum::GetStringArray(),
                false
            ],
            'GoodIntegerEnum::ONE === GoodIntegerEnum::ONE' => [
                new GoodIntegerEnum( GoodIntegerEnum::ONE ),
                GoodIntegerEnum::ONE,
                true
            ],
            'GoodIntegerEnum::ONE === GoodStringEnum::ONE' => [
                new GoodIntegerEnum( GoodIntegerEnum::ONE ),
                GoodStringEnum::ONE,
                false
            ],
            'GoodStringEnum::ONE === GoodStringEnum::ONE' => [
                new GoodStringEnum( GoodStringEnum::ONE ),
                GoodStringEnum::ONE,
                true
            ],
            'GoodStringEnum::ONE === GoodIntegerEnum::ONE' => [
                new GoodStringEnum( GoodStringEnum::ONE ),
                GoodIntegerEnum::ONE,
                false
            ]
        ];
    }
}