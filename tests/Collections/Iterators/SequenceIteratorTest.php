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


    /**
     * Test hasCurrent() returns the correct result
     * 
     * @dataProvider getHasCurrentTestData
     */
    public function testHasCurrent( SequenceIterator $iterator, bool $expected )
    {
        $this->assertEquals(
            $expected,
            $iterator->hasCurrent(),
            'SequenceIterator->hasCurrent() returned the wrong result.'
        );
    }

    public function getHasCurrentTestData(): array
    {
        return [
            'Empty Sequence' => [
                new SequenceIterator( new Sequence( 'int' ) ),
                false
            ],
            'Sequence with one value' => [
                new SequenceIterator( new Sequence( 'int', [ 1 ] ) ),
                true
            ],
            'Sequence with two values' => [
                new SequenceIterator( new Sequence( 'int', [ 1, 2 ] ) ),
                true
            ],
            'Sequence with one value => goToNext()' => [
                (function() {
                    $iterator = new SequenceIterator( new Sequence( 'int', [ 1 ] ) );
                    $iterator->goToNext();
                    return $iterator;
                })(),
                false
            ],
            'Sequence with two values => goToNext()' => [
                (function() {
                    $iterator = new SequenceIterator( new Sequence( 'int', [ 1, 2 ] ) );
                    $iterator->goToNext();
                    return $iterator;
                })(),
                true
            ],
            'Sequence with two values => goToNext() => goToNext()' => [
                (function() {
                    $iterator = new SequenceIterator( new Sequence( 'int', [ 1, 2 ] ) );
                    $iterator->goToNext();
                    $iterator->goToNext();
                    return $iterator;
                })(),
                false
            ]
        ];
    }


    /**
     * Test getValue() returns the correct result
     * 
     * @dataProvider getValueTestData
     */
    public function testGetValue( SequenceIterator $iterator, $expected )
    {
        $this->assertEquals(
            $expected,
            $iterator->getValue(),
            'SequenceIterator->getValue() returned the wrong result.'
        );
    }

    public function getValueTestData(): array
    {
        $iterator = new SequenceIterator( new Sequence( 'int', [ 1, 2, 3 ] ) );

        return [
            'Unmoved Sequence' => [
                clone $iterator,
                1
            ],
            'Sequence => goToNext()' => [
                (function() use ( $iterator ) {
                    $iterator = clone $iterator;
                    $iterator->goToNext();
                    return $iterator;
                })(),
                2
            ],
            'Sequence => goToNext() => goToNext()' => [
                (function() use ( $iterator ) {
                    $iterator = clone $iterator;
                    $iterator->goToNext();
                    $iterator->goToNext();
                    return $iterator;
                })(),
                3
            ]
        ];
    }
}