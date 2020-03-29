<?php
declare( strict_types = 1 );

namespace PHP\Tests\Loops;

use PHP\Loops\IndexedIterator;
use PHP\Loops\Iterator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Tests for IndexedIterator
 */
class IndexedIteratorTest extends TestCase
{




    /*******************************************************************************************************************
    *                                                     INHERITANCE
    *******************************************************************************************************************/


    /**
     * Ensure IndexedIterator is an Iterator
     */
    public function testIsIterator()
    {
        $indexedIterator = $this->createIndexedIterator( 0, 1 );
        $this->assertInstanceOf(
            Iterator::class,
            $indexedIterator,
            'IndexedIterator does not extend Iterator.'
        );
    }




    /*******************************************************************************************************************
    *                                                     hasCurrent()
    *******************************************************************************************************************/


    /**
     * Ensure hasCurrent() returns the expected result
     * 
     * @dataProvider getHasCurrentData
     */
    public function testHasCurrent( IndexedIterator $iterator, bool $expected )
    {
        $this->assertEquals(
            $expected,
            $iterator->hasCurrent(),
            'IndexedIterator->hasCurrent() returned the wrong result.'
        );
    }

    public function getHasCurrentData(): array
    {
        return [

            'start = 0, end = 1, increment = 1 )' => [
                $this->createIndexedIterator( 0, 1, 1 ),
                true
            ],
            'start = 0, end = 0, increment = 1 )' => [
                $this->createIndexedIterator( 0, 0, 1 ),
                true
            ],
            'start = 0, end = -1, increment = 1 )' => [
                $this->createIndexedIterator( 0, -1, 1 ),
                false
            ],

            'start = 0, end = -1, increment = -1 )' => [
                $this->createIndexedIterator( 0, -1, -1 ),
                true
            ],
            'start = 0, end = 0, increment = -1 )' => [
                $this->createIndexedIterator( 0, 0, -1 ),
                true
            ],
            'start = 0, end = 1, increment = -1 )' => [
                $this->createIndexedIterator( 0, 1, -1 ),
                false
            ]
        ];
    }




    /*******************************************************************************************************************
    *                                                      UTILITIES
    *******************************************************************************************************************/


    /**
     * Create a new mock IndexedIterator with the given constructor arguments
     * 
     * @param int $start
     * @param int $end
     * @param int $increment
     * @return MockObject
     */
    private function createIndexedIterator( int $start, int $end, int $increment = 1 ): MockObject
    {
        $iterator = $this->getMockBuilder( IndexedIterator::class )
            ->setConstructorArgs([ $start, $end, $increment ])
            ->setMethods([ 'getValue' ])
            ->getMock();
        $iterator->method( 'getValue' )->willReturn( 1 );
        return $iterator;
    }
}