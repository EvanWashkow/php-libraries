<?php
declare( strict_types = 1 );

namespace PHP\Collections\Iterators;

use PHP\Collections\Sequence;
use PHP\Exceptions\NotImplementedException;
use PHP\Iteration\Iterator;

/**
 * Defines an Iterator to traverse Sequences
 */
class SequenceIterator extends Iterator
{


    /**
     * Create a new Sequence Iterator
     * 
     * @param Sequence $sequence The Sequence to iterate over
     */
    public function __construct( Sequence $sequence )
    {
        return;
    }


    public function rewind(): void
    {
        throw new NotImplementedException( 'Not implemented, yet' );
    }


    public function hasCurrent(): bool
    {
        throw new NotImplementedException( 'Not implemented, yet' );
    }


    public function getKey()
    {
        throw new NotImplementedException( 'Not implemented, yet' );
    }


    public function getValue()
    {
        throw new NotImplementedException( 'Not implemented, yet' );
    }


    public function goToNext(): void
    {
        throw new NotImplementedException( 'Not implemented, yet' );
    }
}