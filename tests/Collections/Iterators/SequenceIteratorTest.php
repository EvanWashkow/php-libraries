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
            new SequenceIterator( new Sequence( 'int', [] )),
            'SequenceIterator is not an Iterator instance.'
        );
    }
}