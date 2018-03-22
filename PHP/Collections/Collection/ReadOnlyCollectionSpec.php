<?php
namespace PHP\Collections\Collection;

use PHP\Collections\IterableSpec;

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
     * @param mixed $index The index to retrieve the value from
     * @return mixed The value if the index exists. NULL otherwise.
     */
    public function get( $index );
    
    /**
     * Determine if the index exists
     *
     * @param mixed $index The index to check
     * @return bool
     */
    public function hasIndex( $index ): bool;
}
