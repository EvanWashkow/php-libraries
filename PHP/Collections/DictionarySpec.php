<?php
namespace PHP\Collections;

use PHP\Collections\CollectionSpec;
use PHP\Collections\Collection\ReadOnlyCollectionSpec;
use PHP\Collections\Dictionary\ReadOnlyDictionarySpec;

/**
 * Specifications for a mutable, unordered set of indexed values
 */
interface DictionarySpec extends \Iterator, CollectionSpec, ReadOnlyDictionarySpec
{
    
    /**
     * Store the value at the specified index
     *
     * Fails if the index already exists or if the index or value doesn't match
     * its type requirement.
     *
     * @param mixed $index The index to store the value at
     * @param mixed $value The value to store
     * @return bool Whether or not the operation was successful
     */
    public function add( $index, $value ): bool;
    
    /**
     * Duplicate every index and value into a new instance
     *
     * @return DictionarySpec
     */
    public function clone(): ReadOnlyCollectionSpec;
}
