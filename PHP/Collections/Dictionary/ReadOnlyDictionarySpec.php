<?php
namespace PHP\Collections\Dictionary;

use PHP\Collections\Collection\ReadOnlyCollectionSpec;

/**
 * Specifications for a read-only, unordered set of indexed values
 */
interface ReadOnlyDictionarySpec extends ReadOnlyCollectionSpec
{
    
    /**
     * Duplicate every index and value into a new instance
     *
     * @return ReadOnlyDictionarySpec
     */
    public function Clone(): ReadOnlyCollectionSpec;
}
