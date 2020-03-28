<?php
declare( strict_types = 1 );

namespace PHP\Loops;

use PHP\Exceptions\NotFoundException;

/**
 * Uses integer indices to traverse an Iterable item in a foreach() loop, retrieving the item's value for that index.
 * 
 * In order to use this class, extend it and define getValue()
 */
abstract class IndexedIterator extends Iterator
{


    /**
     * Create a new integer-indexed iterator to traverse an Iterable
     * 
     * @internal Using "count" rather than "endingIndex" for two primary reasons:
     * 1. "endingIndex" cannot ever indicate "there are no values." i.e. start = 0, end = 0 means one value. Arguing
     * that "no values" should be represented by end = ( start - 1 ) complicates point #2.
     * 2. If the direction is reversed, "endingIndex" must be inverted to the negative. This defeats the purpose of the
     * bi-directional "incrementBy" argument, and makes switching directions much more difficult.
     * 
     * @param int $startingIndex The index to start at.
     * @param int $count         How many items to iterate over.
     * @param int $incrementBy   Value to increment (or decrement) the index by (on goToNext()).
     */
    public function __construct( int $startingIndex, int $count, int $incrementBy = 1 )
    {
        return;
    }


    public function rewind(): void
    {
        throw new NotFoundException( __FUNCTION__ . '() is not implemented, yet.' );
    }


    public function hasCurrent(): bool
    {
        throw new NotFoundException( __FUNCTION__ . '() is not implemented, yet.' );
    }


    public function getKey()
    {
        throw new NotFoundException( __FUNCTION__ . '() is not implemented, yet.' );
    }


    public function goToNext(): void
    {
        throw new NotFoundException( __FUNCTION__ . '() is not implemented, yet.' );
    }
}