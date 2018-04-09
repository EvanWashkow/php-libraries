<?php
namespace PHP\Collections;

use PHP\Collections\Collection\ReadOnlyCollectionSpec;

/**
 * Specifications for a read-only, unordered, and iterable set of key-value pairs
 */
interface ReadOnlyDictionarySpec extends ReadOnlyCollectionSpec
{
    
    /**
     * Duplicate every key and value into a new instance
     *
     * @return ReadOnlyDictionarySpec
     */
    public function clone(): ReadOnlyCollectionSpec;
}
