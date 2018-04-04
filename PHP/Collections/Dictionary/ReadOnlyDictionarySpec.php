<?php
namespace PHP\Collections\Dictionary;

use PHP\Collections\Collection\ReadOnlyCollectionSpec;
use PHP\Collections\Sequence\ReadOnlySequenceSpec;

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
    
    /**
     * Retrieve all entry keys
     *n
     * @return ReadOnlySequenceSpec
     */
    public function getKeys(): ReadOnlySequenceSpec;
    
    /**
     * Retrieve all entry values
     *n
     * @return ReadOnlySequenceSpec
     */
    public function getValues(): ReadOnlySequenceSpec;
}
