<?php
namespace PHP\Types;

/**
 * Defines a set of items, with arbitrary indexes, that can be iterated over
 */
class Iterable
{
    
    /**
     * The indexed set of items
     *
     * @var array
     */
    protected $items;
    
    
    /**
     * Creates a new Iterable instance for the items
     *
     * @param array $items The indexed set of items
     */
    public function __construct( array $items )
    {
        $this->items = $items;
    }
    
    
    /**
     * Retrieve the number of items
     *
     * @return int
     */
    public function Count(): int
    {
        return count( $this->items );
    }
}
