<?php
declare( strict_types = 1 );

namespace PHP\Collections\Iteration;

use PHP\Collections\IArrayable;
use PHP\Exceptions\NotImplementedException;

/**
 * Iterates over an IArrayable using Integer indexes from 0 to n-1.
 * 
 * Changes to the object will be reflected in the loop. Clone IArrayable entries before looping as necessary.
 */
class ArrayableIndexedIterator extends IndexedIterator
{


    /**
     * Create a new Arrayable Iterator
     * 
     * @param IArrayable $arrayable The Arrayable object
     */
    public function __construct( IArrayable $arrayable )
    {
        return;
    }


    public function hasCurrent(): bool
    {
        throw new NotImplementedException( 'Not implemented, yet.' );
    }


    public function getValue()
    {
        throw new NotImplementedException( 'Not implemented, yet.' );
    }
}