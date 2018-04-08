<?php
namespace PHP\Collections\Sequence;

use PHP\Collections\Collection\ReadOnlyCollection;
use PHP\Collections\SequenceSpec;

/**
 * Defines a read-only, ordered, and iterable set of key-value pairs
 */
class ReadOnlySequence extends ReadOnlyCollection implements ReadOnlySequenceSpec
{
    
    /**
     * Create a read-only sequence instance
     *
     * As entries are added to / removed from the sequence, the changes will
     * be reflected here. To change that, simply clone() this after creation.
     *
     * @param SequenceSpec &$sequence The sequence to make read-only
     */
    public function __construct( SequenceSpec &$sequence )
    {
        parent::__construct( $sequence );
    }
    
    
    public function convertToArray(): array
    {
        return $this->collection->convertToArray();
    }
    
    public function getFirstKey(): int
    {
        return $this->collection->getFirstKey();
    }
    
    public function getLastKey(): int
    {
        return $this->collection->getLastKey();
    }
    
    public function getKeyOf( $value, int $offset = 0, bool $isReverseSearch = false ): int
    {
        return $this->collection->getKeyOf( $value, $offset, $isReverseSearch );
    }
    
    public function slice( int $start, int $count ): ReadOnlySequenceSpec
    {
        $sequence = $this->collection->slice( $start, $count );
        return new self( $sequence );
    }
    
    public function split( $delimiter, int $limit = -1 ): ReadOnlySequenceSpec
    {
        $sequence = $this->collection->split( $delimiter, $limit );
        return new self( $sequence );
    }
}
