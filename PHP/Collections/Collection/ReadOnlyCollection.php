<?php
namespace PHP\Collections\Collection;

use PHP\Collections\CollectionSpec;
use PHP\Collections\Iterator;

/**
 * Defines a set of read-only key-value pairs
 */
class ReadOnlyCollection extends Iterator implements ReadOnlyCollectionSpec
{
    
    /**
     * The collection instance
     *
     * @var CollectionSpec
     */
    private $collection;
    
    
    /**
     * Create a new read-only Collection instance
     *
     * @param CollectionSpec $collection The collection to make read-only
     */
    public function __construct( CollectionSpec $collection )
    {
        $this->collection = $collection;
    }
    
    
    public function clone(): ReadOnlyCollectionSpec
    {
        $class           = get_class( $this );
        $dictionaryClone = $this->collection->clone();
        return new $class( $dictionaryClone );
    }
    
    public function convertToArray(): array
    {
        return $this->collection->convertToArray();
    }
    
    public function count(): int
    {
        return $this->collection->count();
    }
    
    public function get( $key )
    {
        return $this->collection->get( $key );
    }
    
    public function hasKey( $key ): bool
    {
        return $this->collection->hasKey( $key );
    }
    
    
    
    
    /***************************************************************************
    *                              ITERATOR METHODS
    ***************************************************************************/
    
    final public function current()
    {
        return $this->collection->current();
    }
    
    final public function key()
    {
        return $this->collection->key();
    }
    
    final public function next()
    {
        $this->collection->next();
    }
    
    final public function rewind()
    {
        $this->collection->rewind();
    }
    
    final public function valid()
    {
        return $this->collection->valid();
    }
}
