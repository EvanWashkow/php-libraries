<?php
declare( strict_types = 1 );

namespace PHP\Collections\Iterators;

use PHP\Collections\Dictionary;
use PHP\Collections\KeyValuePair;
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
        return array_key_exists( $this->getKey(), $this->getIndexedKeys() );
    }


    public function getValue(): KeyValuePair
    {
        // Exit. Currently at an invalid index.
        if ( !$this->hasCurrent() ) {
            throw new \OutOfBoundsException(
                'Cannot retrieve the current key-value pair: the index is at an invalid position.'
            );
        }

        // Convert the Dictionary keys to an indexed array, and get the current loop index key
        $key = $this->getIndexedKeys()[ $this->getKey() ];

        // Convert the current key to the Dictionary key type
        $keyType = $this->dictionary->getKeyType();
        if ( $keyType->is( 'int') ) {
            $key = intval( $key );
        }
        elseif ( $keyType->is( 'string' )) {
            $key = "$key";
        }

        return new DeprecatedKeyValuePair( $key, $this->dictionary->get( $key ) );
    }


    /**
     * Retrieve the dictionary keys as an indexed array
     * 
     * @return array
     */
    private function getIndexedKeys(): array
    {
        return array_keys( $this->dictionary->toArray() );
    }
}