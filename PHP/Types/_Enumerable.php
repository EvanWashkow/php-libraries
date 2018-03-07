<?php
namespace PHP\Types;

/**
 * Base definition for a non-mutable list of values
 */
abstract class _Enumerable extends Object
{
    
    /**
     * Defines type requirement for all entries
     *
     * @var string
     */
    protected $type;
    
    
    /**
     * Create a new enumerated instance
     *
     * @param string $type Establishes type requirement for all entries. See `is()`.
     */
    public function __construct( string $type = '' )
    {
        $this->type = $type;
    }
    
    
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
     * Retrieves subset of entries starting from the given index
     *
     * Continues until the count or the last entry is reached, whichever is first.
     *
     * @param int $start Starting index
     * @param int $count Number of items to retrieve; negative to retrieve all remaining entries.
     * @param int $step  Rate at which to increment the index. Example: 2 "steps" to every other value, 3 every third, etc.
     * @return _Enumerable
     */
    abstract public function GetSubset( int $start, int $count = -1, int $step = 1 ): _Enumerable;
    
    
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
     * Convert the entries to an array
     *
     * @return array
     */
    abstract public function ToArray(): array;
}
