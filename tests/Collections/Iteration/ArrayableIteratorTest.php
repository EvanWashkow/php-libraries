<?php
declare( strict_types = 1 );

namespace PHP\Tests\Collections\Iteration;

use PHP\Collections\IArrayable;
use PHP\Collections\Iteration\ArrayableIterator;
use PHP\Collections\Iteration\IndexedIterator;
use PHPUnit\Framework\TestCase;

/**
 * Tests ArrayableIterator
 */
class ArrayableIteratorTest extends TestCase
{




    /*******************************************************************************************************************
    *                                                    INHERITANCE
    *******************************************************************************************************************/


    /**
     * Test inheritance
     * 
     * @dataProvider getInheritanceTestData
     */
    public function testInheritance( string $expectedParent )
    {
        $this->assertInstanceOf(
            $expectedParent,
            new ArrayableIterator( $this->createMock( IArrayable::class ) ),
            "ArrayableIterator is not of type \\{$expectedParent}."
        );
    }

    public function getInheritanceTestData(): array
    {
        return [
            IndexedIterator::class => [ IndexedIterator::class ]
        ];
    }
}