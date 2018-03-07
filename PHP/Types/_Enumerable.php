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
}
