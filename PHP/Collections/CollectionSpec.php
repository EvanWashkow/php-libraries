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
     * Store the value at the key
     *
     * Adds the key if it doesn't exist or updates the value at the existing key
     *
     * Fails if the key or value don't meet their type requirements
     *
     * @param mixed $key The key to store the value at
     * @param mixed $value The value to store
     * @return bool Whether or not the operation was successful
     */
    public function set( $key, $value ): bool;
    
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
