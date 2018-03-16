<?php
namespace PHP\Collections;

use PHP\Collections\Collection\ReadOnlyCollectionSpec;

/**
 * Specifications for a set of indexed, mutable values
 */
interface CollectionSpec extends ReadOnlyCollectionSpec
{
    
    /**
     * Remove all stored values
     */
    public function clear();
    
    /**
     * Remove the value from the index
     *
     * @param mixed $index The index to remove the value from
     */
    public function remove( $index );
    
    /**
     * Overwrite the value at the index, if it exists
     *
     * Fails if the index or value doesn't match its type requirement
     *
     * @param mixed $index The index to store the value at
     * @param mixed $value The value to store
     * @return mixed The index or NULL on failure
     */
    public function update( $index, $value );
}
