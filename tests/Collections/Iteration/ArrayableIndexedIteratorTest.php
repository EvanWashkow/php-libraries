<?php
declare( strict_types = 1 );

namespace PHP\Tests\Collections\Iteration;

use PHP\Collections\IArrayable;
use PHP\Collections\Iteration\ArrayableIndexedIterator;
use PHP\Collections\Iteration\IndexedIterator;
use PHPUnit\Framework\TestCase;

/**
 * Tests ArrayableIndexedIterator
 */
class ArrayableIndexedIteratorTest extends TestCase
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
            new ArrayableIndexedIterator( $this->createMock( IArrayable::class ) ),
            "ArrayableIndexedIterator is not of type \\{$expectedParent}."
        );
    }

    public function getInheritanceTestData(): array
    {
        return [
            IndexedIterator::class => [ IndexedIterator::class ]
        ];
    }




    /*******************************************************************************************************************
    *                                                   __construct()
    *******************************************************************************************************************/


    /**
     * Test __construct() throws DomainException
     */
    public function testConstructThrowsDomainException()
    {
        $this->expectException( \DomainException::class );
        new ArrayableIndexedIterator(
            $this->createMock( IArrayable::class ),
            0,
            0
        );
    }
}