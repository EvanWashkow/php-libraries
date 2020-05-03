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
     * @param IArrayable $arrayable     The IArrayable object instance
     * @param int        $startingIndex The starting index
     * @param int        $incrementBy   The amount to increment the current index by on every goToNext()
     * @throws \DomainException If incrementBy is zero
     */
    public function __construct( IArrayable $arrayable, int $startingIndex = 0, int $incrementBy = 1 )
    {
        try {
            parent::__construct( $startingIndex, $incrementBy );
        } catch ( \DomainException $de ) {
            throw new \DomainException( $de->getMessage(), $de->getCode(), $de );
        }
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