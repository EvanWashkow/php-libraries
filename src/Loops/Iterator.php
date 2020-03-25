<?php
declare( strict_types = 1 );

namespace PHP\Loops;

use PHP\Exceptions\NotImplementedException;

/**
 * Traverses an Iterable item in a foreach() loop, retrieving that item's key and value.
 */
abstract class Iterator implements \Iterator
{


    final public function current()
    {
        throw new NotImplementedException( __FUNCTION__ . '() is not implemented, yet.' );
    }


    final public function key()
    {
        throw new NotImplementedException( __FUNCTION__ . '() is not implemented, yet.' );
    }


    final public function next(): void
    {
        throw new NotImplementedException( __FUNCTION__ . '() is not implemented, yet.' );
    }


    final public function valid(): bool
    {
        throw new NotImplementedException( __FUNCTION__ . '() is not implemented, yet.' );
    }
}