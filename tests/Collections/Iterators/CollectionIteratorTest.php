<?php
declare( strict_types = 1 );

namespace PHP\Tests\Collections\Iterators;

use PHP\Collections\Iterators\CollectionIterator;
use PHP\Iteration\Iterator;
use PHPUnit\Framework\MockObject\MockBuilder;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the CollectionIterator
 */
class CollectionIteratorTest extends TestCase
{




    /*******************************************************************************************************************
    *                                                       TESTS
    *******************************************************************************************************************/


    /**
     * Ensure SequenceIterator is an instance of an Iterator
     */
    public function testIsIterator()
    {
        $this->assertInstanceOf(
            Iterator::class,
            $this->mockCollectionIterator( 0 )->getMock(),
            'CollectionIterator is not an Iterator instance.'
        );
    }


    /**
     * Test getKey()
     * 
     * @dataProvider getStartingIndices
     */
    public function testGetKeys( int $startingKey )
    {
        $this->assertEquals(
            $startingKey,
            $this->mockCollectionIterator( $startingKey )->getMock()->getKey(),
            'CollectionIterator->getKey() did not return the expected key.'
        );
    }


    /**
     * Test goToNext()
     * 
     * @dataProvider getStartingIndices
     */
    public function testGoToNext( int $startingKey )
    {
        $iterator = $this->mockCollectionIterator( $startingKey )->getMock();

        $iterator->goToNext();
        $this->assertEquals(
            $startingKey + 1,
            $iterator->getKey(),
            'CollectionIterator->goToNext() did not increment the index.'
        );
    }




    /*******************************************************************************************************************
    *                                                     UTILITIES
    *******************************************************************************************************************/


    /**
     * Retrieve starting indices for testing purposes
     * 
     * @return int[]
     */
    public function getStartingIndices(): array
    {
        return [
            '-3' => [ -3 ],
            '0' => [ 0 ],
            '2' => [ 2 ]
        ];
    }


    /**
     * Mock a new CollectionIterator instance
     * 
     * @return MockBuilder
     */
    private function mockCollectionIterator( int $startingIndex ): MockBuilder
    {
        return $this->getMockBuilder( CollectionIterator::class )
            ->setConstructorArgs([ $startingIndex ])
            ->setMethodsExcept([ 'getKey', 'goToNext' ]);
    }
}