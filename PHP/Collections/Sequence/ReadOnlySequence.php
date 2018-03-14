<?php
namespace PHP\Collections\Sequence;

use PHP\Collections\Collection\ReadOnlyCollectionSpec;
use PHP\Collections\Sequence;

/**
 * Defines a read-only, ordered set of indexed values
 */
class ReadOnlySequence extends \PHP\Object implements ReadOnlySequenceSpec
{
    
    /**
     * The sequence instance
     *
     * @var Sequence
     */
    private $sequence;
    
    
    /**
     * Create a read-only sequence instance
     *
     * As entries are added to / removed from the sequence, the changes will
     * be reflected here. To change that, simply Clone() this after creation.
     *
     * @param Sequence $sequence The sequence to make read-only
     */
    public function __construct( Sequence &$sequence )
    {
        $this->sequence = $sequence;
    }
    
    
    final public function Clone(): ReadOnlyCollectionSpec
    {
        $sequenceClone = $this->sequence->Clone();
        return new static( $sequenceClone );
    }
    
    
    final public function ConvertToArray(): array
    {
        return $this->sequence->ConvertToArray();
    }
    
    
    final public function Count(): int
    {
        return $this->sequence->Count();
    }
    
    
    final public function Get( $index, $defaultValue = null )
    {
        return $this->sequence->Get( $index, $defaultValue );
    }
    
    
    final public function GetFirstIndex(): int
    {
        return $this->sequence->GetFirstIndex();
    }
    
    
    final public function GetLastIndex(): int
    {
        return $this->sequence->GetLastIndex();
    }
    
    
    final public function GetIndexOf( $value, int $offset = 0, bool $isReverseSearch = false ): int
    {
        return $this->sequence->GetIndexOf( $value, $offset, $isReverseSearch );
    }
    
    
    final public function HasIndex( $index ): bool
    {
        return $this->sequence->HasIndex( $index );
    }
    
    
    final public function Loop( callable $function, &...$args )
    {
        $parameters = array_merge( [ $function ], $args );
        return call_user_func_array( [ $this->sequence, 'Loop' ], $parameters );
    }
    
    
    final public function Slice( int $start, int $end ): ReadOnlySequenceSpec
    {
        return $this->sequence->Slice( $start, $end );
    }
    
    
    final public function Split( $delimiter, int $limit = -1 ): ReadOnlySequenceSpec
    {
        return $this->sequence->Split( $delimiter, $limit );
    }
}
