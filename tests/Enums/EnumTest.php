<?php
declare(strict_types=1);

namespace PHP\Tests\Enums;

use PHP\Collections\ByteArray;
use PHP\Collections\Dictionary;
use PHP\Enums\BitMapEnum;
use PHP\Enums\Enum;
use PHP\Enums\IntegerEnum;
use PHP\Enums\StringEnum;
use PHP\ObjectClass;
use PHP\Serialization\PHPSerializer;
use PHP\Tests\Enums\TestEnumDefinitions\GoodBitMapEnum;
use PHP\Tests\Enums\TestEnumDefinitions\GoodIntegerEnum;
use PHP\Tests\Enums\TestEnumDefinitions\GoodStringEnum;
use PHP\Tests\Enums\TestEnumDefinitions\GoodEnum;
use PHP\Tests\Interfaces\IEquatableTestTrait;
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
            'Enum is ObjectClass' => [
                $this->createMock( Enum::class ),
                ObjectClass::class
            ],
            'BitmapEnum is IntegerEnum' => [
                $this->createMock( BitMapEnum::class ),
                IntegerEnum::class
            ],
            'StringEnum is Enum' => [
                $this->createMock( StringEnum::class ),
                Enum::class
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
                    'ONE_FLOAT'   => GoodEnum::ONE_FLOAT,
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
            'new GoodBitMapEnum( 4 | 8 )' => [function() {
                return new GoodBitMapEnum( 4 | 8 );
            }]
        ];
    }




    /*******************************************************************************************************************
     *                                                   IEquatable Tests
     *******************************************************************************************************************/

    use IEquatableTestTrait;


    public function getEqualsTestData(): array
    {
        return $this->getEnumAndPrimitiveComparisonData();
    }


    public function getHashTestData(): array
    {
        // Enums
        $enumArray     = new GoodEnum(GoodEnum::ARRAY);
        $enumOneInt    = new GoodEnum(GoodEnum::ONE_INTEGER);
        $enumOneString = new GoodEnum(GoodEnum::ONE_STRING);

        // ByteArrays
        $byteArrayOneInt    = new ByteArray(GoodEnum::ONE_INTEGER);
        $byteArrayOneString = new ByteArray(GoodEnum::ONE_STRING);

        // Test data
        return [
            'GoodEnum(GoodEnum::ARRAY)->hash() === (clone self)->hash()' => [
                $enumArray, (clone $enumArray)->hash(), true
            ],
            'GoodEnum(GoodEnum::ARRAY)->hash() === GoodEnum(GoodEnum::ONE_INTEGER)->hash()' => [
                $enumArray, $enumOneInt->hash(), false
            ],
            'GoodEnum(GoodEnum::ONE_INTEGER)->hash() === ByteArray(GoodEnum::ONE_INTEGER)' => [
                $enumOneInt, $byteArrayOneInt, true
            ],
            'GoodEnum(GoodEnum::ONE_INTEGER)->hash() === ByteArray(GoodEnum::ONE_STRING)' => [
                $enumOneInt, $byteArrayOneString, false
            ],
            'GoodEnum(GoodEnum::ONE_STRING)->hash() === (clone self)->hash()' => [
                $enumOneString, (clone $enumOneString)->hash(), true
            ],
            'GoodEnum(GoodEnum::ONE_STRING)->hash() === GoodEnum(GoodEnum::ONE_INTEGER)->hash()' => [
                $enumOneString, $enumOneInt->hash(), false
            ]
        ];
    }


    public function getEqualsAndHashConsistencyTestData(): array
    {
        // Enums
        $enumArray     = new GoodEnum(GoodEnum::ARRAY);
        $enumOneInt    = new GoodEnum(GoodEnum::ONE_INTEGER);
        $enumOneString = new GoodEnum(GoodEnum::ONE_STRING);

        // Test data
        return [
            'GoodEnum(GoodEnum::ARRAY)'       => [ $enumArray,     clone $enumArray ],
            'GoodEnum(GoodEnum::ONE_INTEGER)' => [ $enumOneInt,    clone $enumOneInt ],
            'GoodEnum(GoodEnum::ONE_STRING)'  => [ $enumOneString, clone $enumOneString ]
        ];
    }




    /*******************************************************************************************************************
    *                                                     getValue()
    *******************************************************************************************************************/


    /**
     * Test getValue()
     * 
     * @dataProvider getPrimitiveValueComparisonData()
     */
    public function testGetValue( Enum $enum, $value, bool $expected )
    {
        if ( $expected ) {
            $this->assertEquals(
                $enum->getValue(),
                $value,
                'Enum->getValue() did not return the expected value'
            );
        }
        else {
            $this->assertEquals(
                $expected,
                $enum->getValue() === $value,
                'Enum->getValue() should NOT be equal to the value.'
            );
        }
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
        // Enums
        $enumArray     = new GoodEnum(GoodEnum::ARRAY);
        $enumOneInt    = new GoodEnum(GoodEnum::ONE_INTEGER);
        $enumOneString = new GoodEnum(GoodEnum::ONE_STRING);

        return array_merge(
            $this->getPrimitiveValueComparisonData(),
            [
                /**
                 * GoodEnum
                 */
                'GoodEnum( ONE_INTEGER ) === (clone self)' => [
                    $enumOneInt,
                    clone $enumOneInt,
                    true
                ],
                'GoodEnum( ONE_INTEGER ) === ONE_INTEGER' => [
                    $enumOneInt,
                    GoodEnum::ONE_INTEGER,
                    true
                ],
                'GoodEnum( ONE_INTEGER ) === GoodEnum( ONE_STRING )' => [
                    $enumOneInt,
                    $enumOneString,
                    false
                ],
                'GoodEnum( ONE_INTEGER ) === ONE_STRING' => [
                    $enumOneInt,
                    GoodEnum::ONE_STRING,
                    false
                ],

                'GoodEnum( ONE_STRING ) === (clone self)' => [
                    $enumOneString,
                    clone $enumOneString,
                    true
                ],
                'GoodEnum( ONE_STRING ) === ONE_STRING' => [
                    $enumOneString,
                    GoodEnum::ONE_STRING,
                    true
                ],
                'GoodEnum( ONE_STRING ) === GoodEnum( ONE_INTEGER )' => [
                    $enumOneString,
                    $enumOneInt,
                    false
                ],
                'GoodEnum( ONE_STRING ) === ONE_INTEGER' => [
                    $enumOneString,
                    GoodEnum::ONE_INTEGER,
                    false
                ],

                'GoodEnum( ARRAY ) === (clone self)' => [
                    $enumArray,
                    clone $enumArray,
                    true
                ],
                'GoodEnum( ARRAY ) === ARRAY' => [
                    $enumArray,
                    GoodEnum::ARRAY,
                    true
                ],
                'GoodEnum( ARRAY ) === GoodEnum( ONE_INTEGER )' => [
                    $enumArray,
                    $enumOneInt,
                    false
                ],
                'GoodEnum( ARRAY ) === ONE_INTEGER' => [
                    $enumArray,
                    GoodEnum::ONE_INTEGER,
                    false
                ],


                /**
                 * StringEnum
                 */
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

                // StringEnum cross-Enum equality checks
                'GoodStringEnum( GoodStringEnum::ONE ) === new GoodEnum( GoodEnum::ONE_STRING )' => [
                    new GoodStringEnum( GoodStringEnum::ONE ),
                    new GoodEnum( GoodEnum::ONE_STRING ),
                    true
                ],
                'GoodStringEnum( GoodStringEnum::ONE ) === new GoodEnum( GoodEnum::ONE_INTEGER )' => [
                    new GoodStringEnum( GoodStringEnum::ONE ),
                    new GoodEnum( GoodEnum::ONE_INTEGER ),
                    false
                ],


                /**
                 * BitMapEnum
                 * 
                 * This is a less comprehensive test, as the primitive test already covers all the different variations
                 * and combination of bit map equality. This shortened test makes sure that all the major pieces are in
                 * place as the code simply converts the BitMapEnum to its primitive integer form.
                 */
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

                // BitEnum cross-Enum equality checks
                'GoodBitMapEnum( GoodBitMapEnum::ONE ) === new GoodEnum( GoodEnum::ONE_INTEGER )' => [
                    new GoodBitMapEnum( GoodBitMapEnum::ONE ),
                    new GoodEnum( GoodEnum::ONE_INTEGER ),
                    true
                ],
                'GoodBitMapEnum( GoodBitMapEnum::ONE ) === new GoodIntegerEnum( GoodIntegerEnum::ONE )' => [
                    new GoodBitMapEnum( GoodBitMapEnum::ONE ),
                    new GoodIntegerEnum( GoodIntegerEnum::ONE ),
                    true
                ],
                'GoodBitMapEnum( GoodBitMapEnum::ONE ) === new GoodEnum( GoodEnum::ONE_STRING )' => [
                    new GoodBitMapEnum( GoodBitMapEnum::ONE ),
                    new GoodEnum( GoodEnum::ONE_STRING ),
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

            /**
             * GoodEnum
             */
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

            // Enum cross-Enum equality checks
            'GoodEnum( GoodEnum::ONE_INTEGER ) === GoodIntegerEnum::ONE' => [
                new GoodEnum( GoodEnum::ONE_INTEGER ),
                GoodIntegerEnum::ONE,
                true
            ],
            'GoodEnum( GoodEnum::ONE_STRING ) === GoodIntegerEnum::ONE' => [
                new GoodEnum( GoodEnum::ONE_STRING ),
                GoodIntegerEnum::ONE,
                false
            ],
            'GoodEnum( GoodEnum::ONE_STRING ) === GoodStringEnum::ONE' => [
                new GoodEnum( GoodEnum::ONE_STRING ),
                GoodStringEnum::ONE,
                true
            ],
            'GoodEnum( GoodEnum::ONE_INTEGER ) === GoodStringEnum::ONE' => [
                new GoodEnum( GoodEnum::ONE_INTEGER ),
                GoodStringEnum::ONE,
                false
            ],
            'GoodEnum( GoodEnum::ONE_INTEGER ) === GoodBitMapEnum::ONE' => [
                new GoodEnum( GoodEnum::ONE_INTEGER ),
                GoodBitMapEnum::ONE,
                true
            ],
            'GoodEnum( GoodEnum::ONE_STRING ) === GoodBitMapEnum::ONE' => [
                new GoodEnum( GoodEnum::ONE_STRING ),
                GoodBitMapEnum::ONE,
                false
            ],


            /**
             * IntegerEnum
             */
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

            // IntegerEnum cross-Enum equality checks
            'GoodIntegerEnum( GoodIntegerEnum::ONE ) === GoodEnum::ONE_INTEGER' => [
                new GoodIntegerEnum( GoodIntegerEnum::ONE ),
                GoodEnum::ONE_INTEGER,
                true
            ],
            'GoodIntegerEnum( GoodIntegerEnum::ONE ) === GoodEnum::ONE_STRING' => [
                new GoodIntegerEnum( GoodIntegerEnum::ONE ),
                GoodEnum::ONE_STRING,
                false
            ],
            'GoodIntegerEnum( GoodIntegerEnum::ONE ) === GoodBitMapEnum::ONE' => [
                new GoodIntegerEnum( GoodIntegerEnum::ONE ),
                GoodBitMapEnum::ONE,
                true
            ],


            /** 
             * StringEnum
             */
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

            // StringEnum cross-Enum equality checks
            'GoodStringEnum( GoodStringEnum::ONE ) === GoodEnum::ONE_STRING' => [
                new GoodStringEnum( GoodStringEnum::ONE ),
                GoodEnum::ONE_STRING,
                true
            ],
            'GoodStringEnum( GoodStringEnum::ONE ) === GoodEnum::ONE_INTEGER' => [
                new GoodStringEnum( GoodStringEnum::ONE ),
                GoodEnum::ONE_INTEGER,
                false
            ],


            /**
             * BitMapEnum
             */
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
            ],

            // BitEnum cross-Enum equality checks
            'GoodBitMapEnum( GoodBitMapEnum::ONE ) === GoodEnum::ONE_INTEGER' => [
                new GoodBitMapEnum( GoodBitMapEnum::ONE ),
                GoodEnum::ONE_INTEGER,
                true
            ],
            'GoodBitMapEnum( GoodBitMapEnum::ONE ) === GoodIntegerEnum::ONE' => [
                new GoodBitMapEnum( GoodBitMapEnum::ONE ),
                GoodIntegerEnum::ONE,
                true
            ],
            'GoodBitMapEnum( GoodBitMapEnum::ONE ) === GoodEnum::ONE_STRING' => [
                new GoodBitMapEnum( GoodBitMapEnum::ONE ),
                GoodEnum::ONE_STRING,
                false
            ]
        ];
    }
}