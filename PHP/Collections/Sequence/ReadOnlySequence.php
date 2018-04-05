<?php
namespace PHP\Collections\Sequence;

use PHP\Collections\Collection\ReadOnlyCollection;
use PHP\Collections\SequenceSpec;

/**
 * Defines a read-only, ordered set of keyed values
 */
class ReadOnlySequence extends ReadOnlyCollection implements ReadOnlySequenceSpec
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
        parent::__construct( $sequence );
        $this->sequence = $sequence;
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
}
