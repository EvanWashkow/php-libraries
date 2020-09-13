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
        $enumOneFloat  = new GoodEnum(GoodEnum::ONE_FLOAT);
        $enumOneInt    = new GoodEnum(GoodEnum::ONE_INTEGER);
        $enumOneString = new GoodEnum(GoodEnum::ONE_STRING);

        // ByteArrays
        $byteArrayOneFloat  = new ByteArray(GoodEnum::ONE_FLOAT);
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
            'GoodEnum(GoodEnum::ONE_FLOAT)->hash() === ByteArray(GoodEnum::ONE_FLOAT)' => [
                $enumOneFloat, $byteArrayOneFloat, true
            ],
            'GoodEnum(GoodEnum::ONE_FLOAT)->hash() === ByteArray(GoodEnum::ONE_INTEGER)' => [
                $enumOneFloat, $byteArrayOneInt, false
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
        $enumOneFloat  = new GoodEnum(GoodEnum::ONE_FLOAT);
        $enumOneInt    = new GoodEnum(GoodEnum::ONE_INTEGER);
        $enumOneString = new GoodEnum(GoodEnum::ONE_STRING);

        // Test data
        return [
            'GoodEnum(GoodEnum::ARRAY)'       => [ $enumArray,     clone $enumArray ],
            'GoodEnum(GoodEnum::ONE_FLOAT)'   => [ $enumOneFloat,  clone $enumOneFloat ],
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
        $enumOneFloat  = new GoodEnum(GoodEnum::ONE_FLOAT);
        $enumOneInt    = new GoodEnum(GoodEnum::ONE_INTEGER);
        $enumOneString = new GoodEnum(GoodEnum::ONE_STRING);

        return array_merge(
            $this->getPrimitiveValueComparisonData(),
            [
                'GoodEnum( ARRAY ) === (clone self)' => [
                    $enumArray,
                    clone $enumArray,
                    true
                ],
                'GoodEnum( ARRAY ) === GoodEnum( ONE_INTEGER )' => [
                    $enumArray,
                    $enumOneInt,
                    false
                ],
                'GoodEnum( ONE_FLOAT ) === (clone self)' => [
                    $enumOneFloat,
                    clone $enumOneFloat,
                    true
                ],
                'GoodEnum( ONE_FLOAT ) === GoodEnum( self::self::ONE_INTEGER )' => [
                    $enumOneFloat,
                    $enumOneInt,
                    false
                ],
                'GoodEnum( ONE_INTEGER ) === (clone self)' => [
                    $enumOneInt,
                    clone $enumOneInt,
                    true
                ],
                'GoodEnum( ONE_INTEGER ) === GoodEnum( ONE_STRING )' => [
                    $enumOneInt,
                    $enumOneString,
                    false
                ],
                'GoodEnum( ONE_STRING ) === (clone self)' => [
                    $enumOneString,
                    clone $enumOneString,
                    true
                ],
                'GoodEnum( ONE_STRING ) === GoodEnum( ONE_INTEGER )' => [
                    $enumOneString,
                    $enumOneInt,
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
        // Enums
        $enumArray     = new GoodEnum(GoodEnum::ARRAY);
        $enumOneFloat  = new GoodEnum(GoodEnum::ONE_FLOAT);
        $enumOneInt    = new GoodEnum(GoodEnum::ONE_INTEGER);
        $enumOneString = new GoodEnum(GoodEnum::ONE_STRING);

        return [
            'GoodEnum( ARRAY ) === self->getValue()' => [
                $enumArray,
                GoodEnum::ARRAY,
                true
            ],
            'GoodEnum( ARRAY ) === (string) self->getValue()' => [
                $enumArray,
                GoodEnum::GetStringArray(),
                false
            ],
            'GoodEnum( ONE_FLOAT ) === self->getValue()' => [
                $enumOneFloat,
                GoodEnum::ONE_FLOAT,
                true
            ],
            'GoodEnum( ONE_FLOAT ) === (string) self->getValue()' => [
                $enumOneFloat,
                "{$enumOneFloat->getValue()}",
                false
            ],
            'GoodEnum( ONE_INTEGER ) === self->getValue()' => [
                $enumOneInt,
                GoodEnum::ONE_INTEGER,
                true
            ],
            'GoodEnum( ONE_INTEGER ) === GoodEnum::ONE_STRING' => [
                $enumOneInt,
                GoodEnum::ONE_STRING,
                false
            ],
            'GoodEnum( ONE_STRING ) === self->getValue()' => [
                $enumOneString,
                GoodEnum::ONE_STRING,
                true
            ],
            'GoodEnum( ONE_STRING ) === GoodEnum::ONE_INTEGER' => [
                $enumOneString,
                GoodEnum::ONE_INTEGER,
                false
            ]
        ];
    }
}