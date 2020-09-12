<?php
declare( strict_types = 1 );

namespace PHP\Tests\Enums;

use PHP\Collections\ByteArray;
use PHP\Enums\Enum;
use PHP\Enums\IntegerEnum;
use PHP\Interfaces\IIntegerable;
use PHP\Tests\Enums\TestEnumDefinitions\GoodIntegerEnum;
use PHP\Tests\Interfaces\IEquatableTestTrait;
use PHPUnit\Framework\TestCase;

/**
 * Tests IntegerEnum
 */
class IntegerEnumTest extends TestCase
{




    /*******************************************************************************************************************
    *                                                     INHERITANCE
    *******************************************************************************************************************/


    /**
     * Test inheritance
     * 
     * @dataProvider getInheritanceTestData()
     */
    public function testInheritance( string $expectedParent )
    {
        $this->assertInstanceOf(
            $expectedParent,
            $this->createMock( IntegerEnum::class ),
            'IntegerEnum does not have the expected parent.'
        );
    }

    public function getInheritanceTestData(): array
    {
        return [
            Enum::class         => [ Enum::class ],
            IIntegerable::class => [ IIntegerable::class ]
        ];
    }




    /*******************************************************************************************************************
     *                                                   IEquatable Tests
     *******************************************************************************************************************/

    use IEquatableTestTrait;


    public function getEqualsTestData(): array
    {
        $enum1 = new GoodIntegerEnum(GoodIntegerEnum::ONE);
        return [
            'GoodIntegerEnum(GoodIntegerEnum::ONE)->equals(GoodIntegerEnum::ONE)' => [
                $enum1, GoodIntegerEnum::ONE, true
            ],
            'GoodIntegerEnum(GoodIntegerEnum::ONE)->equals(GoodIntegerEnum::TWO)' => [
                $enum1, GoodIntegerEnum::TWO, false
            ]
        ];
    }


    public function getHashTestData(): array
    {
        // Integer Enum
        $enum1 = new GoodIntegerEnum(GoodIntegerEnum::ONE);
        $enum2 = new GoodIntegerEnum(GoodIntegerEnum::TWO);
        $enum4 = new GoodIntegerEnum(GoodIntegerEnum::FOUR);

        // Byte Array
        $byteArray1 = new ByteArray(GoodIntegerEnum::ONE);
        $byteArray2 = new ByteArray(GoodIntegerEnum::TWO);
        $byteArray4 = new ByteArray(GoodIntegerEnum::FOUR);

        return [
            'enum1->hash() === byteArray1' => [
                $enum1, $byteArray1, true
            ],
            'enum1->hash() === byteArray2' => [
                $enum1, $byteArray2, false
            ],
            'enum2->hash() === byteArray2' => [
                $enum2, $byteArray2, true
            ],
            'enum2->hash() === byteArray4' => [
                $enum2, $byteArray4, false
            ],
            'enum4->hash() === byteArray4' => [
                $enum4, $byteArray4, true
            ],
            'enum4->hash() === byteArray1' => [
                $enum4, $byteArray1, false
            ]
        ];
    }


    public function getEqualsAndHashConsistencyTestData(): array
    {
        // Integer Enum
        $enum1 = new GoodIntegerEnum(GoodIntegerEnum::ONE);
        $enum2 = new GoodIntegerEnum(GoodIntegerEnum::TWO);
        $enum4 = new GoodIntegerEnum(GoodIntegerEnum::FOUR);

        return [
            'enum1' => [ $enum1, clone $enum1 ],
            'enum2' => [ $enum2, clone $enum2 ],
            'enum4' => [ $enum4, clone $enum4 ]
        ];
    }




    /*******************************************************************************************************************
     *                                                     getValue()
     ******************************************************************************************************************/

    /**
     * Test getValue() to ensure that finalizing it did not break the base implementation
     */
    public function testGetValue()
    {
        $this->assertEquals(
            GoodIntegerEnum::ONE,
            (new GoodIntegerEnum(GoodIntegerEnum::ONE))->getValue(),
            'IntegerEnum->getValue() did not return the expected value'
        );
    }




    /*******************************************************************************************************************
    *                                                       toInt()
    *******************************************************************************************************************/


    /**
     * Test toInt()
     * 
     * @dataProvider getToIntTestData
     */
    public function testToInt( int $value )
    {
        $this->assertEquals(
            $value,
            ( new GoodIntegerEnum( $value ) )->toInt(),
            'IntegerEnum->toInt() did not return the expected value.'
        );
    }

    public function getToIntTestData(): array
    {
        return [
            GoodIntegerEnum::ONE  => [ GoodIntegerEnum::ONE ],
            GoodIntegerEnum::TWO  => [ GoodIntegerEnum::TWO ],
            GoodIntegerEnum::FOUR => [ GoodIntegerEnum::FOUR ]
        ];
    }
}