<?php
namespace PHP\Collections\Sequence;

use PHP\Collections\Collection\ReadOnlyCollectionSpec;
use PHP\Collections\SequenceSpec;

/**
 * Defines a read-only, ordered set of indexed values
 */
class ReadOnlySequence extends \PHP\Object implements ReadOnlySequenceSpec
{
    
    /**
     * The sequence instance
     *
     * @var SequenceSpec
     */
    private $sequence;
    
    
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
        $this->sequence = $sequence;
    }
    
    
    final public function clone(): ReadOnlyCollectionSpec
    {
        $sequenceClone = $this->sequence->clone();
        return new static( $sequenceClone );
    }
    
    
    final public function convertToArray(): array
    {
        return $this->sequence->convertToArray();
    }
    
    
    final public function count(): int
    {
        return $this->sequence->count();
    }
    
    
    final public function get( $index, $defaultValue = null )
    {
        return $this->sequence->get( $index, $defaultValue );
    }
    
    
    final public function getFirstIndex(): int
    {
        return $this->sequence->getFirstIndex();
    }
    
    
    final public function getLastIndex(): int
    {
        return $this->sequence->getLastIndex();
    }
    
    
    final public function getIndexOf( $value, int $offset = 0, bool $isReverseSearch = false ): int
    {
        return $this->sequence->getIndexOf( $value, $offset, $isReverseSearch );
    }
    
    final public function hasIndex( $index ): bool
    {
        return $this->sequence->hasIndex( $index );
    }
    
    
    final public function loop( callable $function, &...$args )
    {
        $parameters = array_merge( [ $function ], $args );
        return call_user_func_array( [ $this->sequence, 'loop' ], $parameters );
    }
    
    
    final public function slice( int $start, int $end ): ReadOnlySequenceSpec
    {
        return $this->sequence->slice( $start, $end );
    }
    
    
    final public function split( $delimiter, int $limit = -1 ): ReadOnlySequenceSpec
    {
        return $this->sequence->split( $delimiter, $limit );
    }
}
