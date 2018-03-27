<?php
namespace PHP\Collections;

use PHP\Collections\Collection\ReadOnlyCollectionSpec;
use PHP\Collections\Sequence\ReadOnlySequenceSpec;

/**
 * Defines a mutable, ordered set of indexed values
 *
 * This would have been named "List" had that not been reserved by PHP
 */
class Sequence extends \PHP\PHPObject implements SequenceSpec
{
    
    /**
     * List of values
     *
     * @var array
     */
    private $entries;
    
    /**
     * Type requirement for all values
     *
     * @var string
     */
    private $type;
    
    
    /**
     * Create a new enumerated instance
     *
     * @param string $type Specifies the type requirement for all values (see `is()`). An empty string permits all types.
     */
    public function __construct( string $type = '' )
    {
        // Throw error for NULL value types
        if ( 'null' === strtolower( $type )) {
            throw new \Exception( 'Sequence values cannot be NULL' );
        }
        
        $this->clear();
        $this->type = $type;
    }
    
    
    public function add( $value ): bool
    {
        $isSuccessful = false;
        if ( $this->isValueValidType( $value )) {
            $this->entries[] = $value;
            $isSuccessful    = true;
        }
        else {
            trigger_error( "Cannot add non-{$this->type} values" );
        }
        return $isSuccessful;
    }
    
    
    public function clear()
    {
        return $this->entries = [];
    }
    
    
    public function clone(): ReadOnlyCollectionSpec
    {
        $clone = new static( $this->type );
        $this->loop( function( $index, $value, &$clone ) {
            $clone->add( $value );
        }, $clone );
        return $clone;
    }
    
    
    public function convertToArray(): array
    {
        return $this->entries;
    }
    
    
    public function count(): int
    {
        return count( $this->entries );
    }
    
    
    public function get( $index )
    {
        if ( !is( $index, 'integer' )) {
            throw new \Exception( 'Cannot get value from non-integer index' );
        }
        elseif ( !$this->hasIndex( $index )) {
            throw new \Exception( 'Cannot get value from index that does not exist' );
        }
        return $this->entries[ $index ];
    }
    
    
    public function getFirstIndex(): int
    {
        return 0;
    }
    
    
    public function getLastIndex(): int
    {
        return ( $this->count() - 1 );
    }
    
    
    public function getIndexOf( $value, int $offset = 0, bool $isReverseSearch = false ): int
    {
        // Variables
        $index = -1;
    
        // Exit. Offset cannot be negative.
        if ( $offset < $this->getFirstIndex() ) {
            trigger_error( 'Offset cannot be less than the first entry\'s index' );
            return $index;
        }
        
        // Exit. Offset cannot surpass the end of the array.
        elseif ( $this->getLastIndex() < $offset ) {
            trigger_error( 'Offset cannot be greater than the last entry\'s index' );
            return $index;
        }
            
        // Get the sub-sequence to traverse
        $sequence = $this->clone();
        if ( $isReverseSearch ) {
            $sequence->reverse();
        }
        $sequence = $sequence->slice( $offset, $sequence->getLastIndex() );
        
        // Search the sub-sequence for the value
        $_index = array_search( $value, $sequence->convertToArray() );
        if ( false !== $_index ) {
            
            // Invert index for reverse search. Keep in mind that the last
            // index is actually the first in the original order.
            if ( $isReverseSearch ) {
                $index = $sequence->getLastIndex() - $_index;
            }
            
            // Add the offset to forward searches
            else {
                $index = $_index + $offset;
            }
        }
    
        return $index;
    }
    
    
    public function hasIndex( $index ): bool
    {
        return ( is( $index, 'integer' ) && array_key_exists( $index, $this->entries ));
    }
    
    
    public function insert( int $index, $value ): bool
    {
        // Variables
        $isSuccessful = false;
        
        // Index too small
        if ( $index < $this->getFirstIndex() ) {
            trigger_error( 'Cannot insert value before the beginning' );
        }
        
        // Index too large
        elseif (( $this->getLastIndex() + 1 ) < $index ) {
            trigger_error( 'Cannot insert value after the end' );
        }
        
        // Invalid value type
        elseif ( !$this->isValueValidType( $value )) {
            trigger_error( "Cannot insert non-{$this->type} values" );
        }
        
        // Insert value at the index
        else {
            array_splice( $this->entries, $index, 0, $value );
            $isSuccessful = true;
        }
        
        return $isSuccessful;
    }
    
    
    public function loop( callable $function, &...$args )
    {
        $parameters = array_merge( [ $function ], $args );
        $iterable   = new Traversable( $this->entries );
        return call_user_func_array( [ $iterable, 'loop' ], $parameters );
    }
    
    
    public function remove( $index ): bool
    {
        $isSuccessful = false;
        if ( !is( $index, 'integer' )) {
            trigger_error( 'Index is not an integer' );
        }
        elseif ( !$this->hasIndex( $index )) {
            trigger_error( 'Cannot remove value: the index does not exist.' );
        }
        else {
            unset( $this->entries[ $index ] );
            $this->entries = array_values( $this->entries );
            $isSuccessful = true;
        }
        return $isSuccessful;
    }
    
    
    public function reverse()
    {
        $this->entries = array_reverse( $this->entries, false );
    }
    
    
    public function slice( int $start, int $end ): ReadOnlySequenceSpec
    {
        // Variables
        $subArray = [];
        
        // Error. Ending index cannot be less than the starting index.
        if ( $end < $start ) {
            trigger_error( 'Ending index cannot be less than the starting index.' );
        }
        
        // Create array subset
        else {
            
            // Sanitize the starting index
            if ( $start < $this->getFirstIndex() ) {
                trigger_error( 'Starting index cannot be less than the first index of the entry list.' );
                $start = $this->getFirstIndex();
            }
            
            // Sanitize the ending index
            if ( $this->getLastIndex() < $end ) {
                trigger_error( 'Ending index cannot surpass the last index of the entry list.' );
                $end = $this->getLastIndex();
            }
            
            // For each entry in the index range, push them into the subset array
            for ( $i = $start; $i <= $end; $i++ ) {
                $subArray[] = $this->entries[ $i ];
            }
        }
        
        // Create Sequence subset
        $subSequence = new static( $this->type );
        foreach ( $subArray as $value ) {
            $subSequence->add( $value );
        }
        
        return $subSequence;
    }
    
    
    public function split( $delimiter, int $limit = -1 ): ReadOnlySequenceSpec
    {
        // Variables
        $start       = $this->getFirstIndex();
        $sequences   = [];
        $canContinue = true;
        
        // While there are entries left
        do {
            
            // Halt loop if there are no entries
            if ( 0 === $this->count() ) {
                $canContinue = false;
            }
            
            // Halt loop if the limit has been reached.
            elseif (( 0 <= $limit ) && ( $limit === count( $sequences ))) {
                $canContinue = false;
            }
            
            else {
                
                // Get index of the next delimiter
                $end = $this->getIndexOf( $delimiter, $start );
                
                // Delimiter not found. The end is the very last element.
                if ( $end < 0 ) {
                    $end = $this->getLastIndex() + 1;
                }
                    
                // Group the entries between the start and end, excluding the delimiter
                $sequence = $this->slice( $start, $end - 1 );
                if ( 1 <= $sequence->count() ) {
                    $sequences[] = $sequence;
                }
                
                // Move start index and halt loop if at the end of the sequence
                $start = $end + 1;
                if ( $this->getLastIndex() <= $start ) {
                    $canContinue = false;
                }
            }
        } while ( $canContinue );
        
        // Return sequence of sequences
        $sequence = new static( $this->getType() );
        foreach ( $sequences as $_sequence ) {
            $sequence->add( $_sequence );
        }
        return $sequence;
    }
    
    
    public function update( $index, $value ): bool
    {
        $isSuccessful = false;
        if ( !$this->hasIndex( $index )) {
            trigger_error( 'Update index does not exist' );
        }
        elseif ( !$this->isValueValidType( $value )) {
            trigger_error( "Cannot update entry to a non-{$this->type} value" );
        }
        else {
            $this->entries[ $index ] = $value;
            $isSuccessful = true;
        }
        return $isSuccessful;
    }
    
    
    /**
     * Determine if the value meets the type requirements
     *
     * @param mixed $value The value to check
     * @return bool
     */
    final protected function isValueValidType( $value ): bool
    {
        return (( '' === $this->type ) || is( $value, $this->type ));
    }
}
