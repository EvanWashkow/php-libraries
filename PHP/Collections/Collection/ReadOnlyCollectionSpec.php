<?php
namespace PHP\Collections\Collection;

use PHP\Collections\IteratorSpec;

/**
 * Specifications for a set of read-only key-value pairs
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
    
    /**
     * Determine if the key type is valid for the collection
     *
     * @param mixed $key The key to check
     * @return bool
     */
    public function isValidKeyType( $key ): bool;
    
    /**
     * Determine if the value type is valid for the collection
     *
     * @param mixed $value The value to check
     * @return bool
     */
    public function isValidValueType( $value ): bool;
}
