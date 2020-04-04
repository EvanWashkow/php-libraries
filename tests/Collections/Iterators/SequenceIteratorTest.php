<?php
declare( strict_types = 1 );

namespace PHP\Tests\Collections\Iterators;

use PHP\Collections\Iterators\CollectionIterator;
use PHP\Collections\Iterators\SequenceIterator;
use PHP\Collections\Sequence;
use PHPUnit\Framework\TestCase;

/**
 * Tests SequenceIterator
 */
class SequenceIteratorTest extends TestCase
{


    /**
     * Ensure SequenceIterator is an instance of a CollectionIterator
     */
    public function testIsCollectionIterator()
    {
        $this->assertInstanceOf(
            CollectionIterator::class,
            new SequenceIterator( new Sequence( 'int' )),
            'SequenceIterator is not an CollectionIterator instance.'
        );
    }
}