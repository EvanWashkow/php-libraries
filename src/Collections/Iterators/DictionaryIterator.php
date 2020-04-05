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

    /** @var Dictionary $dictionary The Dictionary to traverse */
    private $dictionary;


    /**
     * Create a new Dictionary Iterator
     * 
     * @param Dictionary $dictionary The Dictionary to traverse
     */
    public function __construct( Dictionary $dictionary )
    {
        parent::__construct( 0 );
        $this->dictionary = $dictionary;
    }


    public function hasCurrent(): bool
    {
        // Convert the Dictionary keys to an indexed array, and check the current loop index against that
        $keys = array_keys( $this->dictionary->toArray() );
        return array_key_exists( $this->getKey(), $keys );
    }


    public function getValue(): KeyValuePair
    {
        throw new NotImplementedException( 'Not implemented, yet' );
    }
}