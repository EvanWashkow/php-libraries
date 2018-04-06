<?php
namespace PHP\Collections\Collection;

use PHP\Collections\CollectionSpec;
use PHP\Collections\Iterator;
use PHP\Collections\SequenceSpec;

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
    protected $collection;
    
    
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
    
    public function count(): int
    {
        return $this->collection->count();
    }
    
    public function get( $key )
    {
        return $this->collection->get( $key );
    }
    
    public function getKeys(): SequenceSpec
    {
        return $this->collection->getKeys();
    }
    
    public function getValues(): SequenceSpec
    {
        return $this->collection->getValues();
    }
    
    public function hasKey( $key ): bool
    {
        return $this->collection->hasKey( $key );
    }
    
    final public function isValidKeyType( $key ): bool
    {
        return $this->collection->isValidKeyType( $key );
    }
    
    final public function isValidValueType( $value ): bool
    {
        return $this->collection->isValidValueType( $value );
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
