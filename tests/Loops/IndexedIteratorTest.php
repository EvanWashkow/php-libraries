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
    *                                                       rewind()
    *
    * This method is tested in due course of testing hasCurrent() and getKey()
    *******************************************************************************************************************/




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

            // Not rewound
            '0, 0, 1 - No rewind()' => [
                $this->createIndexedIterator( 0, 0, 1 ),
                false
            ],
            '1, 1, 1 - No rewind()' => [
                $this->createIndexedIterator( 1, 1, 1 ),
                false
            ],
            '2, 2, 1 - No rewind()' => [
                $this->createIndexedIterator( 2, 2, 1 ),
                false
            ],


            // Forward
            '0, 1, 1 - First rewind()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 0, 1, 1 );
                    $iterator->rewind();
                    return $iterator;
                })(),
                true
            ],
            '0, 0, 1 - First rewind()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 0, 0, 1 );
                    $iterator->rewind();
                    return $iterator;
                })(),
                true
            ],
            '0, -1, 1 - First rewind()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 0, -1, 1 );
                    $iterator->rewind();
                    return $iterator;
                })(),
                false
            ],

            // Reverse
            '0, -1, -1 - First rewind()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 0, -1, -1 );
                    $iterator->rewind();
                    return $iterator;
                })(),
                true
            ],
            '0, 0, -1 - First rewind()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 0, 0, -1 );
                    $iterator->rewind();
                    return $iterator;
                })(),
                true
            ],
            '0, 1, -1 - First rewind()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 0, 1, -1 );
                    $iterator->rewind();
                    return $iterator;
                })(),
                false
            ]
        ];
    }




    /*******************************************************************************************************************
    *                                                       getKey()
    *******************************************************************************************************************/


    /**
     * Ensure getKey() returns the correct values
     * 
     * @dataProvider getKeyReturnData
     */
    public function testGetKeyReturn( IndexedIterator $iterator, int $expected )
    {
        $this->assertEquals(
            $expected,
            $iterator->getKey(),
            'IndexedIterator->getKey() returned the wrong value.'
        );
    }

    public function getKeyReturnData(): array
    {
        return [

            '0, 0, 1 - First rewind()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 0, 0, 1 );
                    $iterator->rewind();
                    return $iterator;
                })(),
                0
            ],
            '1, 1, 1 - First rewind()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 1, 1, 1 );
                    $iterator->rewind();
                    return $iterator;
                })(),
                1
            ],
            '2, 2, 1 - First rewind()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 2, 2, 1 );
                    $iterator->rewind();
                    return $iterator;
                })(),
                2
            ]
        ];
    }


    /**
     * Ensure getKey() throws an OutOfBoundsException
     * 
     * @dataProvider getKeyOutOfBoundsExceptionData
     */
    public function testGetKeyOutOfBoundsException( IndexedIterator $iterator )
    {
        $this->expectException( \OutOfBoundsException::class );
        $iterator->getKey();
    }

    public function getKeyOutOfBoundsExceptionData(): array
    {
        return [

            '0, -1, 1 - First rewind()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 0, -1, 1 );
                    $iterator->rewind();
                    return $iterator;
                })()
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