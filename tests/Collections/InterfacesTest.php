<?php
declare( strict_types = 1 );

namespace PHP\Tests\Collections;

use PHP\Collections\ICountable;
use PHP\Collections\IReadOnlyCollection;
use PHP\Collections\Iteration\IIterable;
use PHPUnit\Framework\TestCase;

/**
 * Tests Collection Interfaces
 */
class InterfacesTest extends TestCase
{

    /**
     * Test inheritance
     * 
     * @dataProvider getInheritanceTestData
     */
    public function testInheritance( string $interface, string $expectedParent )
    {
        $this->assertInstanceOf(
            $expectedParent,
            $this->createMock( $interface ),
            "Interface does not extend parent. Interace: \\{$interface}; Parent: \\{$expectedParent}."
        );
    }

    public function getInheritanceTestData(): array
    {
        return [
            ICountable::class => [
                ICountable::class,
                \Countable::class
            ]
        ];
    }
}