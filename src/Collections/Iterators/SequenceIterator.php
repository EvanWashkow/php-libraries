<?php
declare( strict_types = 1 );

namespace PHP\Collections\Iterators;

use PHP\Collections\Sequence;
use PHP\Exceptions\NotImplementedException;
use PHP\Iteration\IndexedIterator;

/**
 * Defines an Iterator to traverse Sequences
 */
class SequenceIterator extends IndexedIterator
{

    /** @var Sequence $sequence The Sequence to iterate over */
    private $sequence;


    /**
     * Create a new Sequence Iterator
     * 
     * @param Sequence $sequence The Sequence to iterate over
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
        return $this->sequence->get( $this->getKey() );
    }
}