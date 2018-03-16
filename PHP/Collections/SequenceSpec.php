<?php
namespace PHP\Collections;

use PHP\Collections\Sequence\ReadOnlySequenceSpec;
use PHP\Collections\Collection\ReadOnlyCollectionSpec;

/**
 * Specifications for a mutable, ordered set of indexed values
 */
interface SequenceSpec extends CollectionSpec, ReadOnlySequenceSpec
{
    
    /**
     * Store the value at the end of the sequence
     *
     * @param mixed $value The value to add
     * @return int The index or -1 on failure
     */
    public function add( $value ): int;
    
    /**
     * Duplicate every index and value into a new instance
     *
     * @return SequenceSpec
     */
    public function clone(): ReadOnlyCollectionSpec;
    
    /**
     * Insert the value at the index, shifting remaining values up
     *
     * @param int   $index The index to insert the value at
     * @param mixed $value The value
     * @return int  The index or -1 on failure
     */
    public function insert( int $index, $value ): int;
    
    /**
     * Put all entries in reverse order
     */
    public function reverse();
    
    /**
     * Create a subset of entries from this one
     *
     * @param int $start Starting index
     * @param int $end   Ending index
     * @return SequenceSpec
     */
    public function slice( int $start, int $end ): ReadOnlySequenceSpec;
    
    /**
     * Chop these entries into groups, using the given value as a delimiter
     *
     * @param mixed $delimiter Value separating each group
     * @param int   $limit     Maximum number of entries to return; negative to return all.
     * @return SequenceSpec
     */
    public function split( $delimiter, int $limit = -1 ): ReadOnlySequenceSpec;
    
    /**
     * Overwrite the value at the index, if it exists
     *
     * @param mixed $index The index to store the value at
     * @param mixed $value The value to store
     * @return int The index or -1 on failure
     */
    public function update( $index, $value ): int;
}
