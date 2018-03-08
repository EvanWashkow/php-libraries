<?php
namespace PHP\Types;

/**
 * Base definition for a non-mutable list of values
 */
abstract class _Enumerable extends Object
{
    
    /**
     * Retrieve the number of entries
     *
     * @return int
     */
    abstract public function Count(): int;
    
    
    /**
     * Interates through each entry, until the end of the list is reached, or a
     * non-null value is returned from the callback function.
     *
     * @param callable $function Callback function( $value, $index )
     */
    abstract public function ForEach( callable $function );
    
    
    /**
     * Retrieve the value from the corresponding index or null if the index does not exist.
     *
     * @param int $index Index to retrieve the value from
     * @return mixed Value from the index; null if the index does not exist.
     */
    abstract public function Get( int $index );
    
    
    /**
     * Retrieve the index for the first entry with a matching value, or -1 if
     * the item could not be found.
     *
     * @param mixed $value  Value to get the index for
     * @param int   $offset Search starts at this index
     * @return int
     */
    abstract public function IndexOf( $value, int $offset = 0 ): int;
    
    
    /**
     * Creates a subset of entries from the current entries
     *
     * @param int $start Starting index
     * @param int $end   Ending index
     * @return _Enumerable
     */
    abstract public function Slice( int $start, int $end ): _Enumerable;
    
    
    /**
     * Convert the entries to an array
     *
     * @return array
     */
    abstract public function ToArray(): array;
}
