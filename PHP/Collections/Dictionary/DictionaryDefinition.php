<?php
namespace PHP\Collections\Dictionary;

use PHP\Collections\CollectionDefinition;

/**
 * Define the type for a mutable, unordered set of indexed values
 */
interface DictionaryDefinition extends CollectionDefinition, ReadOnlyDictionaryDefinition
{
    
    /**
     * Store the value at the specified index
     *
     * Fails if the index already exists or if the index or value doesn't match
     * its type requirement.
     *
     * @param mixed $index The index to store the value at
     * @param mixed $value The value to store
     * @return mixed The index or NULL on failure.
     */
    public function Add( $index, $value );
}
