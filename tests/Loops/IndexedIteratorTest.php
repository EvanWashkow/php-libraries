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
        $indexedIterator = $this->createIndexedIterator( 0, 1, 1 );
        $this->assertInstanceOf(
            Iterator::class,
            $indexedIterator,
            'IndexedIterator does not extend Iterator.'
        );
    }




    /*******************************************************************************************************************
    *                                                    __construct()
    *******************************************************************************************************************/


    /**
     * Ensure __construct() throws DomainException on zero increments
     */
    public function testConstructThrowsDomainExceptionOnIncrementOfZero()
    {
        $this->expectException( \DomainException::class );
        $this->createIndexedIterator( 0, 0, 0 );
    }




    /*******************************************************************************************************************
    *                                                       rewind()
    *******************************************************************************************************************/


    /**
     * Ensure rewind() resets the index to the start
     * 
     * @dataProvider getRewindData
     */
    public function testRewind( IndexedIterator $iterator, int $start )
    {
        $iterator->rewind();
        $this->assertEquals(
            $start,
            $iterator->getKey(),
            'IndexedIterator->rewind() did not set current to start.'
        );
    }

    public function getRewindData(): array
    {
        return [
            'Brand new iterator' => [
                $this->createIndexedIterator( 20, 40, 1 ),
                20
            ],
            'Dirty iterator' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 18, 20, 1 );
                    $iterator->rewind();
                    $iterator->goToNext();
                    $iterator->goToNext();
                    $iterator->goToNext();
                    $iterator->goToNext();
                    $iterator->goToNext();
                    $iterator->goToNext();
                    return $iterator;
                })(),
                18
            ]
        ];
    }




    /*******************************************************************************************************************
    *                                                       hasCurrent()
    *******************************************************************************************************************/


    /**
     * Ensure hasCurrent() returns the expected results
     * 
     * @dataProvider getHasCurrentData
     */
    public function testHasCurrent( IndexedIterator $iterator, bool $expected )
    {
        $this->assertEquals(
            $expected,
            $iterator->hasCurrent(),
            'IndexedIterator->hasCurrent() did not return the correct result.'
        );
    }

    public function getHasCurrentData(): array
    {
        return [

            // No rewind()
            '( 0, 0, 1 ), no rewind()' => [
                $this->createIndexedIterator( 0, 0, 1 ),
                false
            ],
            '( 0, 0, -1 ), no rewind()' => [
                $this->createIndexedIterator( 0, 0, -1 ),
                false
            ],
            '( -5, 24, 3 ), no rewind()' => [
                $this->createIndexedIterator( -5, 24, 3 ),
                false
            ],
            '( 7, -8, -2 ), no rewind()' => [
                $this->createIndexedIterator( 7, -8, -2 ),
                false
            ],


            // Current is past the end
            '( 4, 3, 1 )' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 4, 3, 1 );
                    $iterator->rewind();
                    return $iterator;
                })(),
                false
            ],
            '( 8, 9, -1 )' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 8, 9, -1 );
                    $iterator->rewind();
                    return $iterator;
                })(),
                false
            ],


            // Current is at or before the end
            '( 3, 3, 1 )' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 3, 3, 1 );
                    $iterator->rewind();
                    return $iterator;
                })(),
                true
            ],
            '( 3, 4, 1 )' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 3, 4, 1 );
                    $iterator->rewind();
                    return $iterator;
                })(),
                true
            ],
            '( 8, 8, -1 )' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 8, 8, -1 );
                    $iterator->rewind();
                    return $iterator;
                })(),
                true
            ],
            '( 9, 8, -1 )' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 9, 8, -1 );
                    $iterator->rewind();
                    return $iterator;
                })(),
                true
            ]
        ];
    }




    /*******************************************************************************************************************
    *                                              hasCurrent() and getKey()
    *******************************************************************************************************************/


    /**
     * Ensure hasCurrent() and getKey() returns the expected result
     * 
     * @dataProvider getIndexedIterators
     */
    public function testHasCurrentAndGetKey( IndexedIterator $iterator, bool $expectedHasCurrent, ?int $expectedKey )
    {
        $this->assertEquals(
            $expectedHasCurrent,
            $iterator->hasCurrent(),
            'IndexedIterator->hasCurrent() returned the wrong result.'
        );

        if ( $expectedHasCurrent ) {
            $this->assertEquals(
                $expectedKey,
                $iterator->getKey(),
                'IndexedIterator->getKey() returned the wrong value.'
            );
        }
    }




    /*******************************************************************************************************************
    *                                                       getKey()
    *
    * The return value is verified by other tests.
    *******************************************************************************************************************/


    /**
     * Ensure getKey() throws an OutOfBoundsException when hasCurrent() returns false
     */
    public function testGetKeyThrowsOutOfBoundsException()
    {
        $iterator = $this->getMockBuilder( IndexedIterator::class )
            ->disableOriginalConstructor()
            ->setMethods([ 'getValue', 'hasCurrent' ])
            ->getMock();
        $iterator->method( 'getValue' )->willReturn( 1 );
        $iterator->method( 'hasCurrent' )->willReturn( false );
        $this->expectException( \OutOfBoundsException::class );
        $iterator->getKey();
    }




    /*******************************************************************************************************************
    *                                                     goToNext()
    *******************************************************************************************************************/


    /**
     * Ensure goToNext() retrieves the expected keys
     * 
     * @dataProvider getGoToNextData
     */
    public function testGoToNext( IndexedIterator $iterator, array $expectedKeys )
    {
        $actualKeys = [];
        $iterator->rewind();
        while ( $iterator->hasCurrent() ) {
            $actualKeys[] = $iterator->getKey();
            $iterator->goToNext();
        }

        $this->assertEquals(
            $expectedKeys,
            $actualKeys,
            'IndexedIterator->goToNext() did not correctly proceed to the next value.'
        );
    }

    public function getGoToNextData(): array
    {
        return [

            // Forwards
            'start = 24, end = 35, increment = 1' => [
                $this->createIndexedIterator( 24, 35, 1 ),
                [ 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35 ]
            ],
            'start = 7, end = 28, increment = 2' => [
                $this->createIndexedIterator( 7, 28, 2 ),
                [ 7, 9, 11, 13, 15, 17, 19, 21, 23, 25, 27 ]
            ],
            'start = 7, end = 23, increment = 3' => [
                $this->createIndexedIterator( 7, 23, 3 ),
                [ 7, 10, 13, 16, 19, 22 ]
            ],

            // Backwards
            'start = -5, end = -13, increment = -1' => [
                $this->createIndexedIterator( -5, -13, -1 ),
                [ -5, -6, -7, -8, -9, -10, -11, -12, -13 ]
            ],
            'start = -1, end = -13, increment = -2' => [
                $this->createIndexedIterator( -1, -13, -2 ),
                [ -1, -3, -5, -7, -9, -11, -13 ]
            ],
            'start = -7, end = -15, increment -3' => [
                $this->createIndexedIterator( -7, -25, -3 ),
                [ -7, -10, -13, -16, -19, -22, -25 ]
            ]
        ];
    }




    /*******************************************************************************************************************
    *                                                   SHARED DATA PROVIDERS
    *******************************************************************************************************************/


    /**
     * Retrieve sample IndexedIterator, expected hasCurrent(), and expected getKey() data
     * 
     * @return array
     */
    public function getIndexedIterators(): array
    {
        return [

            // Not rewound
            '(-1, -1, -1)' => [
                $this->createIndexedIterator( -1, -1, -1 ),
                false,
                null
            ],
            '(0, 0, 1)' => [
                $this->createIndexedIterator( 0, 0, 1 ),
                false,
                null
            ],
            '(1, 1, 1)' => [
                $this->createIndexedIterator( 1, 1, 1 ),
                false,
                null
            ],


            // First Rewind
            '(-1, -1, 1)->rewind()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( -1, -1, 1 );
                    $iterator->rewind();
                    return $iterator;
                })(),
                true,
                -1
            ],
            '(0, 0, 1)->rewind()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 0, 0, 1 );
                    $iterator->rewind();
                    return $iterator;
                })(),
                true,
                0
            ],
            '(1, 1, 1)->rewind()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 1, 1, 1 );
                    $iterator->rewind();
                    return $iterator;
                })(),
                true,
                1
            ],
            '(0, -1, 1)->rewind()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 0, -1, 1 );
                    $iterator->rewind();
                    return $iterator;
                })(),
                false,
                null
            ],


            // Forward - Go To Next
            '(0, 1, 1)->goToNext()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 0, 1, 1 );
                    $iterator->goToNext();
                    return $iterator;
                })(),
                false,
                null
            ],
            '(0, 1, 1)->rewind()->goToNext()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 0, 1, 1 );
                    $iterator->rewind();
                    $iterator->goToNext();
                    return $iterator;
                })(),
                true,
                1
            ],
            '(0, 0, 1)->rewind()->goToNext()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 0, 0, 1 );
                    $iterator->rewind();
                    $iterator->goToNext();
                    return $iterator;
                })(),
                false,
                null
            ],
            '(0, 4, 2)->rewind()->goToNext()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 0, 4, 2 );
                    $iterator->rewind();
                    $iterator->goToNext();
                    return $iterator;
                })(),
                true,
                2
            ],
            '(0, 4, 2)->rewind()->goToNext()->goToNext()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 0, 4, 2 );
                    $iterator->rewind();
                    $iterator->goToNext();
                    $iterator->goToNext();
                    return $iterator;
                })(),
                true,
                4
            ],
            '(0, 1, 2)->rewind()->goToNext()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 0, 1, 2 );
                    $iterator->rewind();
                    $iterator->goToNext();
                    return $iterator;
                })(),
                false,
                null
            ],
            '(0, 6, 3)->rewind()->goToNext()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 0, 6, 3 );
                    $iterator->rewind();
                    $iterator->goToNext();
                    return $iterator;
                })(),
                true,
                3
            ],
            '(0, 6, 3)->rewind()->goToNext()->goToNext()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 0, 6, 3 );
                    $iterator->rewind();
                    $iterator->goToNext();
                    $iterator->goToNext();
                    return $iterator;
                })(),
                true,
                6
            ],
            '(0, 2, 3)->rewind()->goToNext()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 0, 2, 3 );
                    $iterator->rewind();
                    $iterator->goToNext();
                    return $iterator;
                })(),
                false,
                null
            ],


            // Forward - Go to invalid position, and rewind
            '(0, 0, 1)->rewind()-goToNext()->rewind()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 0, 0, 1 );
                    $iterator->rewind();
                    $iterator->goToNext();
                    $iterator->rewind();
                    return $iterator;
                })(),
                true,
                0
            ],


            // Reverse - Go To Next
            '(0, -1, -1)->goToNext()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 0, -1, -1 );
                    $iterator->goToNext();
                    return $iterator;
                })(),
                false,
                null
            ],
            '(0, -1, -1)->rewind()->goToNext()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 0, -1, -1 );
                    $iterator->rewind();
                    $iterator->goToNext();
                    return $iterator;
                })(),
                true,
                -1
            ],
            '(0, 0, -1)->rewind()->goToNext()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 0, 0, -1 );
                    $iterator->rewind();
                    $iterator->goToNext();
                    return $iterator;
                })(),
                false,
                null
            ],
            '(0, -4, -2)->rewind()->goToNext()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 0, -4, -2 );
                    $iterator->rewind();
                    $iterator->goToNext();
                    return $iterator;
                })(),
                true,
                -2
            ],
            '(0, -4, -2)->rewind()->goToNext()->goToNext()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 0, -4, -2 );
                    $iterator->rewind();
                    $iterator->goToNext();
                    $iterator->goToNext();
                    return $iterator;
                })(),
                true,
                -4
            ],
            '(0, -1, -2)->rewind()->goToNext()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 0, -1, -2 );
                    $iterator->rewind();
                    $iterator->goToNext();
                    return $iterator;
                })(),
                false,
                null
            ],
            '(0, -6, -3)->rewind()->goToNext()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 0, -6, -3 );
                    $iterator->rewind();
                    $iterator->goToNext();
                    return $iterator;
                })(),
                true,
                -3
            ],
            '(0, -6, -3)->rewind()->goToNext()->goToNext()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 0, -6, -3 );
                    $iterator->rewind();
                    $iterator->goToNext();
                    $iterator->goToNext();
                    return $iterator;
                })(),
                true,
                -6
            ],
            '(0, -2, -3)->rewind()->goToNext()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 0, -2, -3 );
                    $iterator->rewind();
                    $iterator->goToNext();
                    return $iterator;
                })(),
                false,
                null
            ],


            // Reverse - Go to invalid position, and rewind
            '(0, 0, -1)->rewind()-goToNext()->rewind()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 0, 0, -1 );
                    $iterator->rewind();
                    $iterator->goToNext();
                    $iterator->rewind();
                    return $iterator;
                })(),
                true,
                0
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
    private function createIndexedIterator( int $start, int $end, int $increment ): MockObject
    {
        $iterator = $this->getMockBuilder( IndexedIterator::class )
            ->setConstructorArgs([ $start, $end, $increment ])
            ->setMethods([ 'getValue' ])
            ->getMock();
        $iterator->method( 'getValue' )->willReturn( 1 );
        return $iterator;
    }
}