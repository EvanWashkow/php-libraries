<?php
namespace PHP\Collections;

/**
 * Defines an iterable set of read-only, key-value pairs
 *
 * @see PHP\Collections\Iterator
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
        $clone = $this->collection->clone();
        return new self( $clone );
    }
    
    public function count(): int
    {
        return $this->collection->count();
    }
    
    public function get( $key )
    {
        return $this->collection->get( $key );
    }
    
    public function getKeys(): ReadOnlySequenceSpec
    {
        return $this->collection->getKeys();
    }
    
    public function getValues(): ReadOnlySequenceSpec
    {
        return $this->collection->getValues();
    }
    
    public function hasKey( $key ): bool
    {
        return $this->collection->hasKey( $key );
    }
    
    final public function isOfKeyType( $key ): bool
    {
        return $this->collection->isOfKeyType( $key );
    }
    
    final public function isOfValueType( $value ): bool
    {
        return $this->collection->isOfValueType( $value );
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
    
    final public function seek( $key )
    {
        $this->collection->seek( $key );
    }
    
    final public function valid()
    {
        return $this->collection->valid();
    }
}
