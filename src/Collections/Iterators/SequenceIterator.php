<?php
declare( strict_types = 1 );

namespace PHP\Collections\Iterators;

use PHP\Collections\Sequence;
use PHP\Iteration\IndexedIterator;

/**
 * Defines an Iterator to traverse Sequences
 */
class SequenceIterator extends IndexedIterator
{

    /** @var Sequence $sequence The Sequence to traverse */
    private $sequence;


    /**
     * Create a new Sequence Iterator
     * 
     * @param Sequence $sequence The Sequence to traverse
     */
    public function __construct( Sequence $sequence )
    {
        parent::__construct( $sequence->getFirstKey() );
        $this->sequence = $sequence;
    }


    public function hasCurrent(): bool
    {
        return $this->getKey() <= $this->sequence->getLastKey();
    }


    public function getValue()
    {
        // Exit. Currently at an invalid index.
        if ( !$this->hasCurrent() ) {
            throw new \OutOfBoundsException(
                'Cannot retrieve the current value: the index is at an invalid position.'
            );
        }

        // Return Key-Value Pair for this entry
        $key = $this->getKey();
        return new IteratedKeyValue( $key, $this->sequence->get( $key ) );
    }
}