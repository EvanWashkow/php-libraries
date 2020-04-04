<?php
declare( strict_types = 1 );

namespace PHP\Tests\Collections\Iterators;

use PHP\Collections\Iterators\SequenceIterator;
use PHP\Collections\Sequence;
use PHP\Iteration\IndexedIterator;
use PHPUnit\Framework\TestCase;

/**
 * Tests SequenceIterator
 */
class SequenceIteratorTest extends TestCase
{


    /**
     * Ensure SequenceIterator is an instance of a IndexedIterator
     */
    public function testIsIndexedIterator()
    {
        $this->assertInstanceOf(
            IndexedIterator::class,
            new SequenceIterator( new Sequence( 'int' )),
            'SequenceIterator is not an IndexedIterator instance.'
        );
    }


    /**
     * Test __construct() correctly sets the starting index
     * 
     * @dataProvider getConstructStartingIndexTestData
     */
    public function testConstructStartingIndex( Sequence $sequence )
    {
        $this->assertEquals(
            $sequence->getFirstKey(),
            ( new SequenceIterator( $sequence ) )->getKey(),
            'SequenceIterator->getKey() did not return the Sequence->getFirstKey().'
        );
    }

    public function getConstructStartingIndexTestData()
    {
        return [
            'Sequence->getFirstKey() === -2' => [
                (function() {
                    $sequence = $this->createMock( Sequence::class );
                    $sequence->method( 'getFirstKey' )->willReturn( -2 );
                    return $sequence;
                })()
            ],
            'Sequence->getFirstKey() === 0' => [
                new Sequence( '*' )
            ],
            'Sequence->getFirstKey() === 3' => [
                (function() {
                    $sequence = $this->createMock( Sequence::class );
                    $sequence->method( 'getFirstKey' )->willReturn( 3 );
                    return $sequence;
                })()
            ]
        ];
    }
}