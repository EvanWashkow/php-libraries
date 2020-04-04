<?php
declare( strict_types = 1 );

namespace PHP\Tests\Iteration;

use PHP\Iteration\IndexedIterator;
use PHP\Iteration\Iterator;
use PHPUnit\Framework\MockObject\MockBuilder;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the IndexedIterator
 */
class IndexedIteratorTest extends TestCase
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
            $this->mockIndexedIterator( 0 )->getMock(),
            'IndexedIterator is not an Iterator instance.'
        );
    }

    /**
     * Test rewind()
     * 
     * @dataProvider getStartingIndices
     */
    public function testRewind( int $startingKey )
    {
        $iterator = $this->mockIndexedIterator( $startingKey )->getMock();
        $iterator->goToNext();
        $iterator->goToNext();
        $iterator->goToNext();

        $iterator->rewind();
        $this->assertEquals(
            $startingKey,
            $iterator->getKey(),
            'IndexedIterator->rewind() did not reset the current index to the starting index.'
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
            $this->mockIndexedIterator( $startingKey )->getMock()->getKey(),
            'IndexedIterator->getKey() did not return the expected key.'
        );
    }


    /**
     * Test goToNext()
     * 
     * @dataProvider getStartingIndices
     */
    public function testGoToNext( int $startingKey )
    {
        $iterator = $this->mockIndexedIterator( $startingKey )->getMock();

        $iterator->goToNext();
        $this->assertEquals(
            $startingKey + 1,
            $iterator->getKey(),
            'IndexedIterator->goToNext() did not increment the current index.'
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
     * Mock a new IndexedIterator instance
     * 
     * @return MockBuilder
     */
    private function mockIndexedIterator( int $startingIndex, int $increment = 1 ): MockBuilder
    {
        return $this->getMockBuilder( IndexedIterator::class )
            ->setConstructorArgs([ $startingIndex, $increment ])
            ->setMethodsExcept([ 'rewind', 'getKey', 'goToNext' ]);
    }
}