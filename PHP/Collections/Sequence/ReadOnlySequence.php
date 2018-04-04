<?php
namespace PHP\Collections\Sequence;

use PHP\Collections\Collection\ReadOnlyCollectionSpec;
use PHP\Collections\SequenceSpec;

/**
 * Defines a read-only, ordered set of indexed values
 */
class ReadOnlySequence extends \PHP\PHPObject implements ReadOnlySequenceSpec
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
    
    
    public function clone(): ReadOnlyCollectionSpec
    {
        $class = get_class( $this );
        $clone = $this->sequence->clone();
        return new $class( $clone );
    }
    
    
    public function convertToArray(): array
    {
        return $this->sequence->convertToArray();
    }
    
    
    public function count(): int
    {
        return $this->sequence->count();
    }
    
    
    public function get( $index )
    {
        return $this->sequence->get( $index );
    }
    
    
    public function getFirstIndex(): int
    {
        return $this->sequence->getFirstIndex();
    }
    
    
    public function getLastIndex(): int
    {
        return $this->sequence->getLastIndex();
    }
    
    
    public function getIndexOf( $value, int $offset = 0, bool $isReverseSearch = false ): int
    {
        return $this->sequence->getIndexOf( $value, $offset, $isReverseSearch );
    }
    
    public function hasIndex( $index ): bool
    {
        return $this->sequence->hasIndex( $index );
    }
    
    
    public function loop( callable $function, &...$args )
    {
        $parameters = array_merge( [ $function ], $args );
        return call_user_func_array( [ $this->sequence, 'loop' ], $parameters );
    }
    
    
    public function slice( int $start, int $end ): ReadOnlySequenceSpec
    {
        $class    = get_class( $this );
        $sequence = $this->sequence->slice( $start, $end );
        return new $class( $sequence );
    }
    
    
    public function split( $delimiter, int $limit = -1 ): ReadOnlySequenceSpec
    {
        $class    = get_class( $this );
        $sequence = $this->sequence->split( $delimiter, $limit );
        return new $class( $sequence );
    }
    
    
    /***************************************************************************
    *                              ITERATOR METHODS
    ***************************************************************************/
    
    final public function current()
    {
        return $this->sequence->current();
    }
    
    final public function key()
    {
        return $this->sequence->key();
    }
    
    final public function next()
    {
        $this->sequence->next();
    }
    
    final public function rewind()
    {
        $this->sequence->rewind();
    }
    
    final public function valid()
    {
        return $this->sequence->valid();
    }
}
