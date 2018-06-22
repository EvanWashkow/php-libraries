<?php
namespace PHP\Collections;

/**
 * Specifications for a mutable, unordered, and iterable set of key-value pairs
 */
interface IDictionary extends ICollection, IReadOnlyDictionary
{
    
    /**
     * Duplicate every key and value into a new instance
     *
     * @return IDictionary
     */
    public function clone(): IReadOnlyCollection;
}
