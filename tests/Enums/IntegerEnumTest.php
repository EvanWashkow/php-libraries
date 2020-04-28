<?php
declare( strict_types = 1 );

namespace PHP\Tests\Enums;

use PHP\Enums\Enum;
use PHP\Enums\IntegerEnum;
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
            Enum::class => [ Enum::class ]
        ];
    }
}