<?php
namespace PHP\Collections\Collection;

use PHP\Collections\IteratorSpec;

/**
 * Defines the type for a set of keyed, read-only values
 */
interface ReadOnlyCollectionSpec extends IteratorSpec
{
    
    /**
     * Duplicate every key and value into a new instance
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
     * Retrieve the value stored at the specified key
     *
     * @param mixed $key The key to retrieve the value from
     * @return mixed The value if the key exists. NULL otherwise.
     */
    public function get( $key );
    
    /**
     * Determine if the key exists
     *
     * @param mixed $key The key to check for
     * @return bool
     */
    public function hasKey( $key ): bool;
}
