<?php
namespace PHP\Collections;

/**
 * Specifications for a read-only, ordered, and iterable set of key-value pairs
 */
interface IReadOnlySequence extends IReadOnlyCollection
{
    
    /**
     * Duplicate every key and value into a new instance
     *
     * @return IReadOnlySequence
     */
    public function clone(): IReadOnlyCollection;
    
    /**
     * Retrieve the key for the last entry
     *
     * @return int
     */
    public function getFirstKey(): int;
    
    /**
     * Retrieve the key for the last entry
     *
     * @return int
     */
    public function getLastKey(): int;
    
    /**
     * Search and retrieve key for the first instance of the specified value
     *
     * @param mixed $value           Value to get the key for
     * @param int   $offset          Start search from this key
     * @param bool  $isReverseSearch Start search from the end, offsetting as necessary from the end of the list.
     * @return int The key of the value, or -1
     */
    public function getKeyOf( $value, int $offset = 0, bool $isReverseSearch = false ): int;
    
    /**
     * Reverse all entries
     *
     * @return IReadOnlySequence
     */
    public function reverse(): IReadOnlySequence;
    
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
     * @return IReadOnlySequence
     */
    public function slice( int $offset, int $limit ): IReadOnlySequence;
    
    /**
     * Chop these entries into groups, using the given value as a delimiter
     *
     * @param mixed $delimiter Value separating each group
     * @param int   $limit     Maximum number of entries to return; negative to return all.
     * @return IReadOnlySequence
     */
    public function split( $delimiter, int $limit = PHP_INT_MAX ): IReadOnlySequence;
    
    /**
     * Convert to a native PHP array
     *
     * @return array
     */
    public function toArray(): array;
}
