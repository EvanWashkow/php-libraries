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
            new ArrayableIndexedIterator( $this->createArrayable( [ 1, 2, 3 ] ) ),
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
            $this->createArrayable( [ 1, 2, 3 ] ),
            0,
            0
        );
    }


    /**
     * Test __construct() sets parent constructor values
     * 
     * @dataProvider getParentConstructorTestData
     */
    public function testParentConstructor( int $startingIndex, int $incrementBy )
    {
        $arrayable = $this->createArrayable( [ 1, 2, 3 ] );
        $iterator  = new ArrayableIndexedIterator( $arrayable, $startingIndex, $incrementBy );

        $iterator->goToNext();
        $this->assertEquals(
            ( $startingIndex + $incrementBy ),
            $iterator->getKey(),
            'ArrayableIndexedIterator->getKey() did not return the expected index.'
        );
    }

    public function getParentConstructorTestData(): array
    {
        return [
            'start = 0, increment by = 1'  => [ 0, 1 ],
            'start = 1, increment by = 1'  => [ 1, 1 ],
            'start = 2, increment by = -1' => [ 2, -1 ]
        ];
    }




    /*******************************************************************************************************************
    *                                                     hasCurrent()
    *******************************************************************************************************************/


    /**
     * Test hasCurrent() return value
     * 
     * @dataProvider getHasCurrentTestData
     */
    public function testHasCurrent( array $array, int $startingIndex, int $incrementBy, bool $expected )
    {
        // Create IArrayable object instance
        $arrayable = $this->createArrayable( $array );

        // Run test
        $this->assertEquals(
            $expected,
            ( new ArrayableIndexedIterator( $arrayable, $startingIndex, $incrementBy ))->hasCurrent(),
            'ArrayableIndexedIterator->hasCurrent() did not return the expected value.'
        );
    }

    public function getHasCurrentTestData(): array
    {
        return [
            '[], 0, 1' => [
                [],
                0,
                1,
                false
            ],
            '[ 1, 2, 3 ], 0, 1' => [
                [ 1, 2, 3 ],
                0,
                1,
                true
            ],
            '[ 1, 2, 3 ], 3, 1' => [
                [ 1, 2, 3 ],
                3,
                1,
                false
            ]
        ];
    }




    /*******************************************************************************************************************
    *                                                       UTILITIES
    *******************************************************************************************************************/


    /**
     * Create an IArrayable instance
     * 
     * @param array $array The return value of toArray()
     * @return IArrayable
     */
    private function createArrayable( array $array ): IArrayable
    {
        $arrayable = $this->createMock( IArrayable::class );
        $arrayable->method( 'toArray' )->willReturn( $array );
        return $arrayable;
    }
}