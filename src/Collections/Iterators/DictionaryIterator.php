<?php
declare( strict_types = 1 );

namespace PHP\Collections\Iterators;

use PHP\Collections\Dictionary;
use PHP\Collections\KeyValuePair;
use PHP\Exceptions\NotImplementedException;
use PHP\Iteration\IndexedIterator;

/**
 * Defines an Iterator to traverse a dictionary
 */
class DictionaryIterator extends IndexedIterator
{


    /**
     * Create a new Dictionary Iterator
     * 
     * @param Dictionary $dictionary
     */
    public function __construct( Dictionary $dictionary )
    {
        
    }


    public function hasCurrent(): bool
    {
        throw new NotImplementedException( 'Not implemented, yet' );
    }


    public function getValue(): KeyValuePair
    {
        throw new NotImplementedException( 'Not implemented, yet' );
    }
}