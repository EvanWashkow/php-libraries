<?php
namespace PHP\Collections\Sequence;

use PHP\Collections\iCollection;

/**
 * Define the type for a mutable, ordered set of indexed values
 */
interface iSequence extends iCollection, iReadOnlySequence
{
    
    /**
     * Store the value at the end of the sequence
     *
     * Fails if the value doesn't match its type requirement
     *
     * @param mixed $value The value to add
     * @return mixed The index or NULL on failure
     */
    public function Add( $value );
}
