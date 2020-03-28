<?php
declare( strict_types = 1 );

namespace PHP\Loops;

use PHP\Exceptions\NotFoundException;

/**
 * Uses integer indices to traverse an Iterable item in a foreach() loop, retrieving the item's value for that index.
 */
class IndexedIterator extends Iterator
{


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


    public function getValue()
    {
        throw new NotFoundException( __FUNCTION__ . '() is not implemented, yet.' );
    }


    public function goToNext(): void
    {
        throw new NotFoundException( __FUNCTION__ . '() is not implemented, yet.' );
    }
}