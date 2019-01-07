<?php
namespace PHP\Collections;

// Deprecate
\trigger_error( __NAMESPACE__ . "\\ReadOnlySequence is deprecated. Clone a Sequence instance instead." );

/**
 * Defines a read-only, ordered, and iterable set of key-value pairs
 *
 * @see PHP\Collections\Iterator
 */
class ReadOnlySequence extends ReadOnlyCollection
{
    
    /**
     * Create a read-only sequence instance
     *
     * As entries are added to / removed from the sequence, the changes will
     * be reflected here. To change that, simply clone() this after creation.
     *
     * @param Sequence &$sequence The sequence to make read-only
     */
    public function __construct( Sequence &$sequence )
    {
        parent::__construct( $sequence );
    }
    
    
    public function clone(): ReadOnlyCollection
    {
        return new self( $this->collection );
    }
    
    final public function toArray(): array
    {
        return $this->collection->toArray();
    }
    
    final public function getFirstKey(): int
    {
        return $this->collection->getFirstKey();
    }
    
    final public function getLastKey(): int
    {
        return $this->collection->getLastKey();
    }
    
    final public function getKeyOf( $value, int $offset = 0, bool $isReverseSearch = false ): int
    {
        return $this->collection->getKeyOf( $value, $offset, $isReverseSearch );
    }
    
    public function reverse(): ReadOnlySequence
    {
        $sequence = $this->collection->reverse();
        return new self( $sequence );
    }
    
    public function slice( int $offset, int $limit = PHP_INT_MAX ): ReadOnlySequence
    {
        $sequence = $this->collection->slice( $offset, $limit );
        return new self( $sequence );
    }
    
    public function split( $delimiter, int $limit = PHP_INT_MAX ): ReadOnlySequence
    {
        // Variables
        $splitSequence = $this->collection->split( $delimiter, $limit );
        $outerSequence = new \PHP\Collections\Sequence( __CLASS__ );
        
        // For each inner sequence, make it read-only and add it to the outer
        $splitSequence->loop( function( $key, $innerSequence ) use ( &$outerSequence ) {
            $outerSequence->add( new self( $innerSequence ));
            return true;
        });
        return new self( $outerSequence );
    }
}
