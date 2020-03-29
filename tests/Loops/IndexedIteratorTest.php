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
    *
    * This method is tested in due course of testing hasCurrent() and getKey()
    *******************************************************************************************************************/




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
    *
    * This method is tested in due course of testing hasCurrent() and getKey()
    *******************************************************************************************************************/




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