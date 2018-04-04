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
     * @return bool Whether or not the operation was successful
     */
    public function add( $value ): bool;
    
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
     * @return bool Whether or not the operation was successful
     */
    public function insert( int $index, $value ): bool;
    
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
}
