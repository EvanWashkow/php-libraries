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
     * @param int  $startingIndex The index to start at
     * @param int  $endingIndex   The index to stop at
     * @param bool $isForward     The direction of the index increment. "true" to increment, "false" to decrement.
     */
    public function __construct( int $startingIndex, int $endingIndex, bool $isForward = true )
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