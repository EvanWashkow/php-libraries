<?php
namespace PHP\Collections\Sequence;

use PHP\Collections\Collection\ReadOnlyCollectionSpec;
use PHP\Collections\SequenceSpec;

/**
 * Defines a read-only, ordered set of keyed values
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
    
    
    
    
    /***************************************************************************
    *                             READ-ONLY METHODS
    ***************************************************************************/
    
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
    
    
    public function get( $key )
    {
        return $this->sequence->get( $key );
    }
    
    
    public function getFirstKey(): int
    {
        return $this->sequence->getFirstKey();
    }
    
    
    public function getLastKey(): int
    {
        return $this->sequence->getLastKey();
    }
    
    
    public function getKeyOf( $value, int $offset = 0, bool $isReverseSearch = false ): int
    {
        return $this->sequence->getKeyOf( $value, $offset, $isReverseSearch );
    }
    
    public function hasKey( $key ): bool
    {
        return $this->sequence->hasKey( $key );
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
