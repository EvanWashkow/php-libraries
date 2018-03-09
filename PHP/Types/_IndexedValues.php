<?php
namespace PHP\Types;

/**
 * Defines structure for a set of indexed, mutable values
 */
abstract class _IndexedValues extends _IndexedValues\_ReadOnly
{
    
    /**
     * Add the value to the list
     *
     * @param mixed $value The value to store
     * @return mixed The index or NULL on failure
     */
    abstract public function Add( $value );
    
    /**
     * Remove all stored values
     */
    abstract public function Clear();
    
    /**
     * Remove the value from the index
     *
     * @param mixed $index The index to remove the value from
     */
    abstract public function Remove( $index );
    
    /**
     * Store the value at the index, overwriting any pre-existing values
     *
     * Fails if the index or value doesn't match its type requirement
     *
     * @param mixed $index The index to store the value at
     * @param mixed $value The value to store
     * @return mixed The index or NULL on failure.
     */
    abstract public function Update( $index, $value );
}
