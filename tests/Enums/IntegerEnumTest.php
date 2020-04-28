<?php
declare( strict_types = 1 );

namespace PHP\Tests\Enums;

use PHP\Enums\Enum;
use PHP\Enums\IntegerEnum;
use PHP\Interfaces\IIntegerable;
use PHP\Tests\Enums\TestEnumDefinitions\GoodIntegerEnum;
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