<?php
namespace PHP\Collections;

/**
 * Specifications for a mutable, ordered, and iterable set of key-value pairs
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
     * Duplicate every key and value into a new instance
     *
     * @return SequenceSpec
     */
    public function clone(): ReadOnlyCollectionSpec;
    
    /**
     * Insert the value at the key, shifting remaining values up
     *
     * @param int   $key The key to insert the value at
     * @param mixed $value The value
     * @return bool Whether or not the operation was successful
     */
    public function insert( int $key, $value ): bool;
    
    /**
     * Clone a subset of entries from this sequence
     *
     * Why use a start index and a count rather than start / end indices?
     * Because the starting / ending indices must be inclusive to retrieve the
     * first / last items respectively. Doing so, however, prevents an empty
     * list from ever being created, which is to be expected for certain
     * applications. For this reason, dropping the ending index for count
     * solves the problem entirely while reducing code complexity.
     *
     * @param int $offset Starting key (inclusive)
     * @param int $limit  Number of items to copy
     * @return SequenceSpec
     */
    public function slice( int $offset, int $limit ): ReadOnlySequenceSpec;
    
    /**
     * Chop these entries into groups, using the given value as a delimiter
     *
     * @param mixed $delimiter Value separating each group
     * @param int   $limit     Maximum number of entries to return; negative to return all.
     * @return SequenceSpec
     */
    public function split( $delimiter, int $limit = -1 ): ReadOnlySequenceSpec;
    
    /**
     * Reverse all entries
     *
     * @return SequenceSpec
     */
    public function reverse(): ReadOnlySequenceSpec;
}
