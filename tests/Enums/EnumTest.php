<?php
declare(strict_types=1);

namespace PHP\Tests\Enums;

use PHP\Collections\Dictionary;
use PHP\Enums\BitMapEnum;
use PHP\Enums\Enum;
use PHP\Enums\IntegerEnum;
use PHP\Enums\StringEnum;
use PHP\ObjectClass;
use PHP\Tests\Enums\TestEnumDefinitions\GoodBitMapEnum;
use PHP\Tests\Enums\TestEnumDefinitions\GoodIntegerEnum;
use PHP\Tests\Enums\TestEnumDefinitions\GoodStringEnum;
use PHP\Tests\Enums\TestEnumDefinitions\GoodEnum;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Test Enum class
 */
class EnumTest extends TestCase
{




    /*******************************************************************************************************************
    *                                                     INHERITANCE
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
            'new GoodEnum( GoodEnum::ONE_STRING )' => [
                new GoodEnum( GoodEnum::ONE_STRING ),
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
    *                                                 ABSTRACT CLASS TEST
    *******************************************************************************************************************/


    /**
     * Ensure that all base Enum class definitions are abstract
     * 
     * @dataProvider getEnumClassNames()
     * @return void
     **/
    public function testAbstractClass( string $className )
    {
        $this->assertTrue(
            ( new ReflectionClass( $className ) )->isAbstract(),
            "All Enum base classes should be abstract. {$className} is not abstract."
        );
    }


    public function getEnumClassNames(): array
    {
        return [
            [ Enum::class ],
            [ IntegerEnum::class ],
            [ StringEnum::class ],
            [ BitMapEnum::class ]
        ];
    }




    /*******************************************************************************************************************
    *                                                    getConstants()
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
                    'ONE_INTEGER' => GoodEnum::ONE_INTEGER,
                    'ONE_STRING'  => GoodEnum::ONE_STRING,
                    'ARRAY'       => GoodEnum::ARRAY
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
            'new GoodEnum( GoodEnum::ONE_INTEGER )' => [function() {
                return new GoodEnum( 'foobar' );
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
     * @dataProvider getEnumAndPrimitiveComparisonData()
     */
    public function testEquals( Enum $enum, $value, bool $expected )
    {
        $this->assertEquals(
            $expected,
            $enum->equals( $value ),
            'Enum->equals() did not return the correct result'
        );
    }




    /*******************************************************************************************************************
    *                                                     getValue()
    *******************************************************************************************************************/


    /**
     * Test the construction of Enums
     * 
     * @dataProvider getPrimitiveValueComparisonData()
     */
    public function testGetValue( Enum $enum, $value, bool $expected )
    {
        $this->assertEquals(
            $expected,
            $enum->getValue() === $value,
            'Enum->getValue() did not return the expected value'
        );
    }




    /*******************************************************************************************************************
    *                                                 Comparison Data
    *******************************************************************************************************************/


    /**
     * Returns Enum comparison data against other Enums and Primitive data types
     * 
     * @return array
     */
    public function getEnumAndPrimitiveComparisonData(): array
    {
        return array_merge(
            $this->getPrimitiveValueComparisonData(),
            [
                // GoodEnum
                'GoodEnum( ONE_INTEGER ) === <same enum>' => [
                    new GoodEnum( GoodEnum::ONE_INTEGER ),
                    new GoodEnum( GoodEnum::ONE_INTEGER ),
                    true
                ],
                'GoodEnum( ONE_STRING ) === <same enum>' => [
                    new GoodEnum( GoodEnum::ONE_STRING ),
                    new GoodEnum( GoodEnum::ONE_STRING ),
                    true
                ],
                'GoodEnum( ARRAY ) === <same enum>' => [
                    new GoodEnum( GoodEnum::ARRAY ),
                    new GoodEnum( GoodEnum::ARRAY ),
                    true
                ],

                // IntegerEnum
                'GoodIntegerEnum( GoodIntegerEnum::ONE ) === <same enum>' => [
                    new GoodIntegerEnum( GoodIntegerEnum::ONE ),
                    new GoodIntegerEnum( GoodIntegerEnum::ONE ),
                    true
                ],
                'GoodIntegerEnum( GoodIntegerEnum::ONE ) === GoodStringEnum( GoodStringEnum::ONE )' => [
                    new GoodIntegerEnum( GoodIntegerEnum::ONE ),
                    new GoodStringEnum( GoodStringEnum::ONE ),
                    false
                ],

                // StringEnum
                'GoodStringEnum( GoodStringEnum::ONE ) === <same enum>' => [
                    new GoodStringEnum( GoodStringEnum::ONE ),
                    new GoodStringEnum( GoodStringEnum::ONE ),
                    true
                ],
                'GoodStringEnum( GoodStringEnum::ONE ) === GoodIntegerEnum( GoodIntegerEnum::ONE )' => [
                    new GoodStringEnum( GoodStringEnum::ONE ),
                    new GoodIntegerEnum( GoodIntegerEnum::ONE ),
                    false
                ],

                // BitMapEnum
                'GoodBitMapEnum( GoodBitMapEnum::ONE ) === <same enum>' => [
                    new GoodBitMapEnum( GoodBitMapEnum::ONE ),
                    new GoodBitMapEnum( GoodBitMapEnum::ONE ),
                    true
                ],
                'GoodBitMapEnum( GoodBitMapEnum::TWO ) === <same enum>' => [
                    new GoodBitMapEnum( GoodBitMapEnum::TWO ),
                    new GoodBitMapEnum( GoodBitMapEnum::TWO ),
                    true
                ],
                'GoodBitMapEnum( GoodBitMapEnum::FOUR ) === <same enum>' => [
                    new GoodBitMapEnum( GoodBitMapEnum::FOUR ),
                    new GoodBitMapEnum( GoodBitMapEnum::FOUR ),
                    true
                ],
                'GoodBitMapEnum( GoodBitMapEnum::ONE ) === GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR )' => [
                    new GoodBitMapEnum( GoodBitMapEnum::ONE ),
                    new GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR ),
                    false
                ],
                'GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR ) === <same enum>' => [
                    new GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR ),
                    new GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR ),
                    true
                ],
                'GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR ) === GoodBitMapEnum( GoodBitMapEnum::ONE )' => [
                    new GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR ),
                    new GoodBitMapEnum( GoodBitMapEnum::ONE ),
                    false
                ],
                'GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR ) === GoodBitMapEnum( GoodBitMapEnum::TWO )' => [
                    new GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR ),
                    new GoodBitMapEnum( GoodBitMapEnum::TWO ),
                    false
                ],
                'GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR ) === GoodBitMapEnum( GoodBitMapEnum::FOUR )' => [
                    new GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR ),
                    new GoodBitMapEnum( GoodBitMapEnum::FOUR ),
                    false
                ],
                'GoodBitMapEnum( GoodBitMapEnum::ONE ) === GoodIntegerEnum( GoodIntegerEnum::ONE )' => [
                    new GoodBitMapEnum( GoodBitMapEnum::ONE ),
                    new GoodIntegerEnum( GoodIntegerEnum::ONE ),
                    true
                ],
                'GoodBitMapEnum( GoodBitMapEnum::ONE ) === GoodStringEnum( GoodStringEnum::ONE )' => [
                    new GoodBitMapEnum( GoodBitMapEnum::ONE ),
                    new GoodStringEnum( GoodStringEnum::ONE ),
                    false
                ]
            ]
        );
    }


    /**
     * Returns Enum comparison data against Primitive data types
     * 
     * @return array
     */
    public function getPrimitiveValueComparisonData(): array
    {
        return [

            // GoodEnum
            'GoodEnum( ONE_INTEGER ) === <value>' => [
                new GoodEnum( GoodEnum::ONE_INTEGER ),
                GoodEnum::ONE_INTEGER,
                true
            ],
            'GoodEnum( ONE_INTEGER ) === GoodEnum::ONE_STRING' => [
                new GoodEnum( GoodEnum::ONE_INTEGER ),
                GoodEnum::ONE_STRING,
                false
            ],
            'GoodEnum( ONE_STRING ) === <value>' => [
                new GoodEnum( GoodEnum::ONE_STRING ),
                GoodEnum::ONE_STRING,
                true
            ],
            'GoodEnum( ONE_STRING ) === GoodEnum::ONE_INTEGER' => [
                new GoodEnum( GoodEnum::ONE_STRING ),
                GoodEnum::ONE_INTEGER,
                false
            ],
            'GoodEnum( ARRAY ) === <value>' => [
                new GoodEnum( GoodEnum::ARRAY ),
                GoodEnum::ARRAY,
                true
            ],
            'GoodEnum( ARRAY ) === (string) <value>' => [
                new GoodEnum( GoodEnum::ARRAY ),
                GoodEnum::GetStringArray(),
                false
            ],


            // IntegerEnum
            'GoodIntegerEnum( GoodIntegerEnum::ONE ) === <value>' => [
                new GoodIntegerEnum( GoodIntegerEnum::ONE ),
               GoodIntegerEnum::ONE,
               true
            ],
            'GoodIntegerEnum( GoodIntegerEnum::ONE ) === (string) <value>' => [
                new GoodIntegerEnum( GoodIntegerEnum::ONE ),
               '' . GoodIntegerEnum::ONE,
               false
            ],

            // StringEnum
            'GoodStringEnum( GoodStringEnum::ONE ) === <value>' => [
                new GoodStringEnum( GoodStringEnum::ONE ),
               GoodStringEnum::ONE,
               true
            ],
            'GoodStringEnum( GoodStringEnum::ONE ) === (int) <value>' => [
                new GoodStringEnum( GoodStringEnum::ONE ),
               intval( GoodStringEnum::ONE ),
               false
            ],

            // BitMapEnum
            'GoodBitMapEnum( GoodBitMapEnum::ONE ) === <value>' => [
                new GoodBitMapEnum( GoodBitMapEnum::ONE ),
                GoodBitMapEnum::ONE,
                true
            ],
            'GoodBitMapEnum( GoodBitMapEnum::TWO ) === <value>' => [
                new GoodBitMapEnum( GoodBitMapEnum::TWO ),
                GoodBitMapEnum::TWO,
                true
            ],
            'GoodBitMapEnum( GoodBitMapEnum::FOUR ) === <value>' => [
                new GoodBitMapEnum( GoodBitMapEnum::FOUR ),
                GoodBitMapEnum::FOUR,
                true
            ],
            'GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::TWO ) === <value>' => [
                new GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::TWO ),
                GoodBitMapEnum::ONE | GoodBitMapEnum::TWO,
                true
            ],
            'GoodBitMapEnum( GoodBitMapEnum::TWO | GoodBitMapEnum::FOUR ) === <value>' => [
                new GoodBitMapEnum( GoodBitMapEnum::TWO | GoodBitMapEnum::FOUR ),
                GoodBitMapEnum::TWO | GoodBitMapEnum::FOUR,
                true
            ],
            'GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR ) === <value>' => [
                new GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR ),
                GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR,
                true
            ],
            'GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::TWO | GoodBitMapEnum::FOUR ) === <value>' => [
                new GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::TWO | GoodBitMapEnum::FOUR ),
                GoodBitMapEnum::ONE | GoodBitMapEnum::TWO | GoodBitMapEnum::FOUR,
                true
            ],
            'GoodBitMapEnum( GoodBitMapEnum::ONE ) === ( ONE_string ) <value>' => [
                new GoodBitMapEnum( GoodBitMapEnum::ONE ),
                '' . GoodBitMapEnum::ONE,
                false
            ],
            'GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR ) === ( ONE_string ) <value>' => [
                new GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR ),
                '' . ( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR ),
                false
            ]
        ];
    }
}