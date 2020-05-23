<?php
declare( strict_types = 1 );

namespace PHP\Collections\Iterators;

use PHP\Collections\Iteration\ArrayableIterator;
use PHP\Collections\Sequence;
use PHP\Collections\Iteration\IndexedIterator;

/**
 * Defines an Iterator to traverse Sequences
 * 
 * @method Sequence getArrayable()
 */
class SequenceIterator extends ArrayableIterator
{


    /**
     * Create a new Sequence Iterator
     * 
     * @param Sequence $sequence The Sequence to traverse
     */
    public function __construct( Sequence $sequence )
    {
        parent::__construct( $sequence, $sequence->getFirstKey() );
    }
}