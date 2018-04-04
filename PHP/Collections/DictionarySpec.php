<?php
namespace PHP\Collections;

use PHP\Collections\CollectionSpec;
use PHP\Collections\Collection\ReadOnlyCollectionSpec;
use PHP\Collections\Dictionary\ReadOnlyDictionarySpec;

/**
 * Specifications for a mutable, unordered set of keyed values
 */
interface DictionarySpec extends CollectionSpec, ReadOnlyDictionarySpec
{
    
    /**
     * Store the value at the specified key
     *
     * Fails if the key already exists or if the key or value doesn't match
     * its type requirement.
     *
     * @param mixed $key The key to store the value at
     * @param mixed $value The value to store
     * @return bool Whether or not the operation was successful
     */
    public function add( $key, $value ): bool;
    
    /**
     * Duplicate every key and value into a new instance
     *
     * @return DictionarySpec
     */
    public function clone(): ReadOnlyCollectionSpec;
}
