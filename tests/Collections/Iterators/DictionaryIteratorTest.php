<?php
declare( strict_types = 1 );

namespace PHP\Tests\Collections\Iterators;

use PHP\Collections\Dictionary;
use PHP\Collections\Iterators\DictionaryIterator;
use PHP\Iteration\IndexedIterator;
use PHPUnit\Framework\TestCase;

/**
 * Tests the DictionaryIterator implementation
 */
class DictionaryIteratorTest extends TestCase
{



    /**
     * Ensure DictionaryIterator is an instance of a IndexedIterator
     */
    public function testIsIndexedIterator()
    {
        $this->assertInstanceOf(
            IndexedIterator::class,
            new DictionaryIterator( new Dictionary( 'string', 'string' )),
            'DictionaryIterator is not an IndexedIterator instance.'
        );
    }
}