<?php
namespace PHP\Collections;

use PHP\Collections\Collection\ReadOnlyCollectionSpec;
use PHP\Collections\Sequence\ReadOnlySequenceSpec;

/**
 * Defines a mutable, ordered, and iterable set of key-value pairs
 *
 * This would have been named "List" had that not been reserved by PHP
 */
class Sequence extends Collection implements SequenceSpec
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
        
        parent::__construct( 'integer', $type );
        $this->clear();
        $this->type = $type;
    }
    
    
    
    
    /***************************************************************************
    *                              EDITING METHODS
    ***************************************************************************/
    
    public function add( $value ): bool
    {
        $isSuccessful = false;
        if ( $this->isOfValueType( $value )) {
            $this->entries[] = $value;
            $isSuccessful    = true;
        }
        else {
            trigger_error( "Cannot add non-{$this->type} values" );
        }
        return $isSuccessful;
    }
    
    
    public function clear(): bool
    {
        $this->entries = [];
        return true;
    }
    
    
    public function insert( int $key, $value ): bool
    {
        // Variables
        $isSuccessful = false;
        
        // Key too small
        if ( $key < $this->getFirstKey() ) {
            trigger_error( 'Cannot insert value before the beginning' );
        }
        
        // Key too large
        elseif (( $this->getLastKey() + 1 ) < $key ) {
            trigger_error( 'Cannot insert value after the end' );
        }
        
        // Invalid value type
        elseif ( !$this->isOfValueType( $value )) {
            trigger_error( "Cannot insert non-{$this->type} values" );
        }
        
        // Insert value at the key
        else {
            array_splice( $this->entries, $key, 0, $value );
            $isSuccessful = true;
        }
        
        return $isSuccessful;
    }
    
    
    public function remove( $key ): bool
    {
        $isSuccessful = false;
        if ( !is( $key, 'integer' )) {
            trigger_error( 'Key is not an integer' );
        }
        elseif ( !$this->hasKey( $key )) {
            trigger_error( 'Cannot remove value: the key does not exist.' );
        }
        else {
            unset( $this->entries[ $key ] );
            $this->entries = array_values( $this->entries );
            $isSuccessful = true;
        }
        return $isSuccessful;
    }
    
    
    public function reverse()
    {
        $this->entries = array_reverse( $this->entries, false );
    }
    
    
    public function update( $key, $value ): bool
    {
        $isSuccessful = false;
        if ( !$this->hasKey( $key )) {
            trigger_error( 'Update key does not exist' );
        }
        elseif ( !$this->isOfValueType( $value )) {
            trigger_error( "Cannot update entry to a non-{$this->type} value" );
        }
        else {
            $this->entries[ $key ] = $value;
            $isSuccessful = true;
        }
        return $isSuccessful;
    }
    
    
    
    
    /***************************************************************************
    *                            READ-ONLY METHODS
    ***************************************************************************/
    
    public function clone(): ReadOnlyCollectionSpec
    {
        $class = get_class( $this );
        $clone = new $class( $this->type );
        $this->loop( function( $key, $value, &$clone ) {
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
    
    
    public function get( $key )
    {
        if ( !is( $key, 'integer' )) {
            throw new \Exception( 'Cannot get value from non-integer key' );
        }
        elseif ( !$this->hasKey( $key )) {
            throw new \Exception( 'Cannot get value from key that does not exist' );
        }
        return $this->entries[ $key ];
    }
    
    
    public function getFirstKey(): int
    {
        return 0;
    }
    
    
    public function getLastKey(): int
    {
        return ( $this->count() - 1 );
    }
    
    
    public function getKeyOf( $value, int $offset = 0, bool $isReverseSearch = false ): int
    {
        // Variables
        $key = -1;
    
        // Exit. Offset cannot be negative.
        if ( $offset < $this->getFirstKey() ) {
            trigger_error( 'Offset cannot be less than the first entry\'s key' );
            return $key;
        }
        
        // Exit. Offset cannot surpass the end of the array.
        elseif ( $this->getLastKey() < $offset ) {
            trigger_error( 'Offset cannot be greater than the last entry\'s key' );
            return $key;
        }
            
        // Get the sub-sequence to traverse
        $sequence = $this->clone();
        if ( $isReverseSearch ) {
            $sequence->reverse();
        }
        $sequence = $sequence->slice( $offset, $sequence->getLastKey() );
        
        // Search the sub-sequence for the value
        $_key = array_search( $value, $sequence->convertToArray() );
        if ( false !== $_key ) {
            
            // Invert key for reverse search. Keep in mind that the last
            // key is actually the first in the original order.
            if ( $isReverseSearch ) {
                $key = $sequence->getLastKey() - $_key;
            }
            
            // Add the offset to forward searches
            else {
                $key = $_key + $offset;
            }
        }
    
        return $key;
    }
    
    
    public function hasKey( $key ): bool
    {
        return (
            $this->isOfKeyType( $key )    &&
            ( $this->getFirstKey() <= $key ) &&
            ( $key <= $this->getLastKey() )
        );
    }
    
    
    public function slice( int $start, int $count ): ReadOnlySequenceSpec
    {
        // Variables
        $sequence = new self( $this->type );
        $lastKey  = $this->getLastKey();
        
        // Sanitize the starting key
        if ( $start < $this->getFirstKey() ) {
            trigger_error( 'Starting key cannot be less than the first key of the sequence.' );
            $start = $this->getFirstKey();
        }
        
        // Copy entries to the sub-sequence
        while (( $sequence->count() < $count ) && ( $start <= $lastKey )) {
            $sequence->add( $this->get( $start ));
            $start++;
        }
        
        return $sequence;
    }
    
    
    public function split( $delimiter, int $limit = -1 ): ReadOnlySequenceSpec
    {
        // Sequence variables
        $thisClass     = get_class( $this );
        $outerSequence = new $thisClass( $thisClass );
        
        // Loop control variables
        $start = $this->getFirstKey();
        
        while (
            // Haven't exceeded requested items
            (( $limit < 0 ) || ( $outerSequence->count() < $limit )) &&
            // Starting index is not past the end of this sequence
            ( $start <= $this->getLastKey() )
        ) {
            
            // Get the ending index of this section
            $end = $this->getKeyOf( $delimiter, $start );
            
            // When start and end are the same, the current element is the delimiter
            if ( $start === $end ) {
                $start = $end + 1;
            }
            
            else
            {
                // Move ending index to the final element
                if ( $end < 0 ) {
                    $end = $this->getLastKey();
                }
                
                // Or, move ending index to the previous entry, skipping delimiter
                else {
                    $end = $end - 1;
                }
                
                // Cut out the sub-section of this sequence from start => end
                $innerSequence = $this->slice( $start, $end );
                $outerSequence->add( $innerSequence );
                
                // Move start index two past the ending index, skipping the delimiter
                $start = $end + 2;
            }
        }
        
        return $outerSequence;
    }
    
    
    
    
    /***************************************************************************
    *                              ITERATOR METHODS
    ***************************************************************************/
    
    final public function current()
    {
        return current( $this->entries );
    }
    
    final public function key()
    {
        return key( $this->entries );
    }
    
    final public function next()
    {
        next( $this->entries );
    }
    
    final public function rewind()
    {
        reset( $this->entries );
    }
    
    final public function valid()
    {
        return array_key_exists( $this->key(), $this->entries );
    }
}
