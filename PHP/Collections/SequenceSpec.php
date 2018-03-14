<?php
namespace PHP\Collections;

use PHP\Collections\Sequence\ReadOnlySequenceSpec;

/**
 * Specifications for a mutable, ordered set of indexed values
 */
interface SequenceSpec extends iCollection, ReadOnlySequenceSpec
{
    
    /**
     * Store the value at the end of the sequence
     *
     * @param mixed $value The value to add
     * @return int The index or -1 on failure
     */
    public function Add( $value ): int;
    
    /**
     * Insert the value at the index, shifting remaining values up
     *
     * @param int   $index The index to insert the value at
     * @param mixed $value The value
     * @return int  The index or -1 on failure
     */
    public function Insert( int $index, $value ): int;
    
    /**
     * Put all entries in reverse order
     */
    public function Reverse();
    
    /**
     * Overwrite the value at the index, if it exists
     *
     * @param mixed $index The index to store the value at
     * @param mixed $value The value to store
     * @return int The index or -1 on failure
     */
    public function Update( $index, $value ): int;
}
