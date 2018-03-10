<?php
namespace PHP\Types;

/**
 * Defines the type for a set of indexed, mutable values
 */
interface CollectionDefinition extends CollectionDefinition\ReadOnlyCollectionDefinition
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
     * Store the value at the index, overwriting any pre-existing values
     *
     * Fails if the index or value doesn't match its type requirement
     *
     * @param mixed $index The index to store the value at
     * @param mixed $value The value to store
     * @return mixed The index or NULL on failure.
     */
    public function Update( $index, $value );
}
