<?php
namespace PHP\Collections;

/**
 * Specifications for a set of indexed, mutable values
 */
interface CollectionSpec extends iReadOnlyCollection
{
    
    /**
     * Remove all stored values
     */
    public function Clear();
    
    /**
     * Remove the value from the index
     *
     * @param mixed $index The index to remove the value from
     */
    public function Remove( $index );
    
    /**
     * Overwrite the value at the index, if it exists
     *
     * Fails if the index or value doesn't match its type requirement
     *
     * @param mixed $index The index to store the value at
     * @param mixed $value The value to store
     * @return mixed The index or NULL on failure
     */
    public function Update( $index, $value );
}
