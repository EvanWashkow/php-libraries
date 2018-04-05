<?php
namespace PHP\Collections\Dictionary;

use PHP\Collections\Collection\ReadOnlyCollectionSpec;

/**
 * Specifications for a read-only, unordered set of keyed values
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
