<?php
namespace PHP\Collections\Dictionary;

use PHP\Collections\Collection\ReadOnlyCollectionSpec;
use PHP\Collections\Sequence\ReadOnlySequenceSpec;

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
    public function clone(): ReadOnlyCollectionSpec;
    
    /**
     * Retrieve all entry indices
     *n
     * @return ReadOnlySequenceSpec
     */
    public function getIndices(): ReadOnlySequenceSpec;
    
    /**
     * Retrieve all entry values
     *n
     * @return ReadOnlySequenceSpec
     */
    public function getValues(): ReadOnlySequenceSpec;
}
