<?php
namespace PHP\Collections;

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
