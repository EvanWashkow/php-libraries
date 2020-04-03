<?php
declare( strict_types = 1 );

namespace PHP\Tests\Collections\Iterators;

use PHP\Collections\Iterators\SequenceIterator;
use PHP\Collections\Sequence;
use PHP\Iteration\Iterator;
use PHPUnit\Framework\TestCase;

/**
 * Tests SequenceIterator
 */
class SequenceIteratorTest extends TestCase
{


    /**
     * Ensure SequenceIterator is an instance of an Iterator
     */
    public function testIsIterator()
    {
        $this->assertInstanceOf(
            Iterator::class,
            new SequenceIterator( new Sequence( 'int' )),
            'SequenceIterator is not an Iterator instance.'
        );
    }


    /**
     * Ensure rewind() sets the current index to the first key
     * 
     * @dataProvider getRewindTestData
     */
    public function testRewind( Sequence $sequence, $expected )
    {
        $iterator     = new SequenceIterator( $sequence );
        $reflIterator = new \ReflectionClass( $iterator );
        $reflIndex    = $reflIterator->getProperty( 'index' );
        $reflIndex->setAccessible( true );

        // Test rewind()
        $iterator->rewind();
        $this->assertEquals(
            $expected,
            $reflIndex->getValue( $iterator ),
            'SequenceIterator->rewind() did not set the current index to the first element.'
        );
    }

    public function getRewindTestData(): array
    {
        return [
            'First key = 0' => [
                new Sequence( 'int' ),
                0
            ],
            'First key = 1' => [
                (function() {
                    $sequence = $this->createMock( Sequence::class );
                    $sequence->method( 'getFirstKey' )->willReturn( 1 );
                    return $sequence;
                })(),
                1
            ]
        ];
    }
}