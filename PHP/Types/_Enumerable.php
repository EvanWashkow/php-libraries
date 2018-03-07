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
}
