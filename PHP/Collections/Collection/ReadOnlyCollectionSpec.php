<?php
namespace PHP\Collections\Collection;

use PHP\Collections\IterableSpec;
use PHP\Collections\Sequence\ReadOnlySequenceSpec;

/**
 * Defines the type for a set of indexed, read-only values
 */
interface ReadOnlyCollectionSpec extends IterableSpec
{
    
    /**
     * Duplicate every index and value into a new instance
     *
     * @return ReadOnlyCollectionSpec
     */
    public function clone(): ReadOnlyCollectionSpec;
    
    /**
     * Convert to a native PHP array
     *
     * @return array
     */
    public function convertToArray(): array;
    
    /**
     * Count all entries, returning the result
     *
     * @return int
     */
    public function count(): int;
    
    /**
     * Retrieve the value stored at the specified index
     *
     * @param mixed $index        The index to retrieve the value from
     * @param mixed $defaultValue The value to return if the index does not exist
     * @return mixed The value if the index exists. NULL otherwise.
     */
    public function get( $index, $defaultValue = null );
    
    /**
     * Retrieve all entry indices
     *n
     * @return ReadOnlySequenceSpec
     */
    public function getIndices(): ReadOnlySequenceSpec;
    
    /**
     * Determine if the index exists
     *
     * @param mixed $index The index to check
     * @return bool
     */
    public function hasIndex( $index ): bool;
}
