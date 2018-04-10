<?php
namespace PHP\Collections;

/**
 * Specifications for a mutable, unordered, and iterable set of key-value pairs
 */
interface DictionarySpec extends CollectionSpec, ReadOnlyDictionarySpec
{
    
    /**
     * Duplicate every key and value into a new instance
     *
     * @return DictionarySpec
     */
    public function clone(): ReadOnlyCollectionSpec;
}
