<?php
namespace PHP\Collections;

/**
 * Specifications for an iterable set of mutable, key-value pairs
 */
interface CollectionSpec extends ReadOnlyCollectionSpec
{
    
    /**
     * Duplicate every key and value into a new instance
     *
     * @return CollectionSpec
     */
    public function clone(): ReadOnlyCollectionSpec;
    
    /**
     * Remove all stored values
     *
     * @return bool
     */
    public function clear(): bool;
    
    /**
     * Remove the value from the key
     *
     * @param mixed $key The key to remove the value from
     * @return bool Whether or not the operation was successful
     */
    public function remove( $key ): bool;
    
    /**
     * Overwrite the value at the key, if it exists
     *
     * Fails if the key or value doesn't match its type requirement
     *
     * @param mixed $key The key to store the value at
     * @param mixed $value The value to store
     * @return bool Whether or not the operation was successful
     */
    public function update( $key, $value ): bool;
}
