<?php
namespace PHP\Collections;

/**
 * Specifications for a read-only, unordered, and iterable set of key-value pairs
 */
interface IReadOnlyDictionary extends IReadOnlyCollection
{
    
    /**
     * Duplicate every key and value into a new instance
     *
     * @return IReadOnlyDictionary
     */
    public function clone(): IReadOnlyCollection;
}
