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
     * @dataProvider getKeys
     */
    public function testGetKeys( int $key )
    {
        $this->assertEquals(
            $key,
            $this->mockCollectionIterator( $key )->getMock()->getKey(),
            'CollectionIterator->getKey() did not return the expected key.'
        );
    }

    public function getKeys(): array
    {
        return [
            '-3' => [ -3 ],
            '0' => [ 0 ],
            '1' => [ 1 ],
            '2' => [ 2 ],
            '3' => [ 3 ]
        ];
    }




    /*******************************************************************************************************************
    *                                                     UTILITIES
    *******************************************************************************************************************/


    /**
     * Mock a new CollectionIterator instance
     * 
     * @return MockBuilder
     */
    private function mockCollectionIterator( int $startingIndex ): MockBuilder
    {
        return $this->getMockBuilder( CollectionIterator::class )
            ->setConstructorArgs([ $startingIndex ])
            ->setMethodsExcept([ 'getKey' ]);
    }
}