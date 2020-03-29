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
            '(0, 1, 1)' => [
                $this->createIndexedIterator( 0, 1, 1 ),
                false
            ],
            '(1, 2, 1)' => [
                $this->createIndexedIterator( 1, 2, 1 ),
                false
            ],
            '(0, -1, -1)' => [
                $this->createIndexedIterator( 0, -1, -1 ),
                false
            ],
            '(-1, -2, -1)' => [
                $this->createIndexedIterator( -1, -2, -1 ),
                false
            ],


            // Forward - First Rewind
            '(0, 1, 1)->rewind()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 0, 1, 1 );
                    $iterator->rewind();
                    return $iterator;
                })(),
                true
            ],
            '(0, 0, 1)->rewind()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 0, 0, 1 );
                    $iterator->rewind();
                    return $iterator;
                })(),
                true
            ],
            '(0, -1, 1)->rewind()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 0, -1, 1 );
                    $iterator->rewind();
                    return $iterator;
                })(),
                false
            ],

            // Reverse - First Rewind
            '(0, -1, -1)->rewind()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 0, -1, -1 );
                    $iterator->rewind();
                    return $iterator;
                })(),
                true
            ],
            '(0, 0, -1)->rewind()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 0, 0, -1 );
                    $iterator->rewind();
                    return $iterator;
                })(),
                true
            ],
            '(0, 1, -1)->rewind()' => [
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

            // First Rewind
            '(-1, -1, -1)->rewind()' => [
                (function() {
                    $iterator = $this->createIndexedIterator(  -1, -1, -1 );
                    $iterator->rewind();
                    return $iterator;
                })(),
                -1
            ],
            '(0, 0, 1)->rewind()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 0, 0, 1 );
                    $iterator->rewind();
                    return $iterator;
                })(),
                0
            ],
            '(1, 1, 1)->rewind()' => [
                (function() {
                    $iterator = $this->createIndexedIterator( 1, 1, 1 );
                    $iterator->rewind();
                    return $iterator;
                })(),
                1
            ]
        ];
    }


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