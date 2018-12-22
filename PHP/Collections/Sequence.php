<?php
declare( strict_types = 1 );

namespace PHP\Collections;

/**
 * Defines a mutable, ordered, and iterable set of key-value pairs (similar to Lists in other languages)
 *
 * @see PHP\Collections\Iterator
 */
class Sequence extends Collection
{


    /***************************************************************************
    *                               PROPERTIES
    ***************************************************************************/


    /**
     * List of values
     *
     * @var array
     */
    private $entries;




    /***************************************************************************
    *                               CONSTRUCTOR
    ***************************************************************************/


    /**
     * Create a new enumerated instance
     *
     * @param string $type Specifies the type requirement for all values (see `is()`). An empty string permits all types.
     */
    public function __construct( string $type = '*' )
    {
        // Throw error for NULL value types
        if ( 'null' === strtolower( $type )) {
            throw new \Exception( 'Sequence values cannot be NULL' );
        }
        
        // Set properties
        parent::__construct( 'int', $type );
        $this->clear();
    }




    /***************************************************************************
    *                             COLLECTION OVERRIDES
    ***************************************************************************/


    /**
     * @see Collection->clear()
     */
    final public function clear(): bool
    {
        $this->entries = [];
        return true;
    }


    /**
     * @see Collection->count()
     */
    final public function count(): int
    {
        return count( $this->entries );
    }


    /**
     * @see Collection->get()
     */
    final public function get( $key )
    {
        if ( !is( $key, 'integer' )) {
            throw new \InvalidArgumentException( 'Cannot get value from non-integer key' );
        }
        elseif ( !$this->hasKey( $key )) {
            throw new \InvalidArgumentException( 'Cannot get value from key that does not exist' );
        }
        return $this->entries[ $key ];
    }


    /**
     * @see Collection->hasKey()
     */
    final public function hasKey( $key ): bool
    {
        return (
            $this->getKeyType()->equals( $key ) &&
            array_key_exists( $key, $this->entries )
        );
    }


    /**
     * @see Collection->hasValue()
     */
    final public function hasValue( $value ): bool
    {
        return (
            $this->getValueType()->equals( $value ) &&
            in_array( $value, $this->entries, true )
        );
    }


    /**
     * @see Collection->remove()
     */
    final public function remove( $key ): bool
    {
        $isSuccessful = false;
        if ( !$this->hasKey( $key )) {
            trigger_error( 'The key does not exist.' );
        }
        else {
            unset( $this->entries[ $key ] );
            $this->entries = array_values( $this->entries );
            $isSuccessful = true;
        }
        return $isSuccessful;
    }


    /**
     * @see Collection->set()
     */
    final public function set( $key, $value ): bool
    {
        // Variables
        $isSuccessful = false;
        
        // Log meaningful errors
        if ( !$this->getKeyType()->equals( $key )) {
            trigger_error( 'Wrong key type' );
        }
        elseif ( !$this->getValueType()->equals( $value )) {
            trigger_error( 'Wrong value type' );
        }
        elseif ( $key < $this->getFirstKey() ) {
            trigger_error( 'Key is too small' );
        }
        elseif (( $this->getLastKey() + 1 ) < $key ) {
            trigger_error( 'Key is too large' );
        }
        
        // Set value
        else {
            $this->entries[ $key ] = $value;
            $isSuccessful          = true;
        }
        
        return $isSuccessful;
    }




    /***************************************************************************
    *                     ITERATOR INTERFACE OVERRIDES
    ***************************************************************************/

    /**
     * @see Iterator->current()
     */
    final public function current()
    {
        return current( $this->entries );
    }

    /**
     * @see Iterator->key()
     */
    final public function key()
    {
        return key( $this->entries );
    }

    /**
     * @see Iterator->next()
     */
    final public function next()
    {
        next( $this->entries );
    }

    /**
     * @see Iterator->rewind()
     */
    final public function rewind()
    {
        reset( $this->entries );
    }




    /***************************************************************************
    *                               OWN METHODS
    ***************************************************************************/


    /**
     * Add value to the end of the sequence
     *
     * @param mixed $value The value to add
     * @return bool Whether or not the operation was successful
     */
    final public function add( $value ): bool
    {
        return $this->set( $this->getLastKey() + 1, $value );
    }


    /**
     * Retrieve the key for the first entry
     * 
     * @return int
     */
    public function getFirstKey(): int
    {
        return 0;
    }


    /**
     * Retrieve the key for the last entry
     *
     * @return int
     */
    final public function getLastKey(): int
    {
        return ( $this->getFirstKey() + ( $this->count() - 1 ));
    }


    /**
     * Retrieve the key of the first value found
     *
     * @param mixed $value           Value to get the key for
     * @param int   $offset          Start search from this key
     * @param bool  $isReverseSearch Start search from the end, offsetting as necessary from the end of the list.
     * @return int The key of the value, or -1
     */
    final public function getKeyOf( $value, int $offset = 0, bool $isReverseSearch = false ): int
    {
        // Variables
        $key = $this->getFirstKey() - 1;
    
        // Exit. Offset cannot be negative.
        if ( $offset < $this->getFirstKey() ) {
            trigger_error( 'Offset cannot be less than the first entry\'s key' );
            return $key;
        }
        
        // Exit. Offset cannot surpass the end of the array.
        elseif ( $this->getLastKey() < $offset ) {
            return $key;
        }
        
        // Exit. There are no entries.
        elseif ( 0 === $this->count() ) {
            return $key;
        }
            
        // Get the sub-sequence to traverse
        $sequence = $isReverseSearch ? $this->reverse() : ( clone $this );
        $sequence = $sequence->slice( $offset, $sequence->count() - $offset );
        
        // Search the sub-sequence for the value
        $searchResult = array_search( $value, $sequence->toArray(), true );
        if ( false !== $searchResult ) {
            
            // Invert key for reverse search. Keep in mind that the last
            // key is actually the first in the original order.
            if ( $isReverseSearch ) {
                $key = $sequence->getLastKey() - $searchResult;
            }
            
            // Add the offset to forward searches
            else {
                $key = $searchResult + $offset;
            }
        }
    
        return $key;
    }


    /**
     * Insert the value at the key, shifting remaining values up
     *
     * @param int   $key The key to insert the value at
     * @param mixed $value The value
     * @return bool Whether or not the operation was successful
     */
    final public function insert( int $key, $value ): bool
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
        elseif ( !$this->getValueType()->equals( $value )) {
            trigger_error( "Wrong value type" );
        }
        
        /**
         * Insert value at this key, shifting other values
         *
         * array_slice() ignores single, empty values, such as null and
         * stdClass(). First insert a placeholder at that entry and then
         * set that key.
         */
        else {
            array_splice( $this->entries, $key, 0, 'placeholder' );
            $this->set( $key, $value );
            $isSuccessful = true;
        }
        
        return $isSuccessful;
    }


    /**
     * Reverse all entries
     *
     * @return Sequence
     */
    public function reverse(): Sequence
    {
        $sequence = new self( $this->getKeyType()->getName() );
        $entries  = array_reverse( $this->entries, false );
        foreach ( $entries as $entry ) {
            $sequence->add( $entry );
        }
        return $sequence;
    }


    /**
     * Retrieve a subset of entries from this Sequence
     *
     * @internal Why use a start index and a count rather than start / end
     * indices? Because the starting / ending indices must be inclusive to
     * retrieve the first / last items respectively. Doing so, however,
     * prevents an empty list from ever being created, which is to be expected
     * for certain applications. For this reason, dropping the ending index for
     * count solves the problem entirely while reducing code complexity.
     *
     * @param int $offset Starting key (inclusive)
     * @param int $limit  Number of items to copy
     * @return Sequence
     */
    public function slice( int $offset, int $limit = PHP_INT_MAX ): Sequence
    {
        /**
         * Even though "array_slice()" supports a negative offset and length,
         * we don't support that. It is a bad practice to specify starting keys
         * before the beginning of the array and negative lengths. Not only are
         * they impossible (in that they do not exist), but are confusing and
         * prevent useful errors when there is an arithmetic error in the caller.
         */
        
        // Sanitize the starting key
        if ( $offset < $this->getFirstKey() ) {
            trigger_error( 'Starting key cannot be before the first key of the sequence.' );
            $offset = $this->getFirstKey();
        }
        
        // Sanitize count
        if ( $limit < 0 ) {
            trigger_error( 'Cannot copy a negative number of items.' );
            $limit = 0;
        }
        
        // Slice and copy entries to the sub-sequence
        $array    = array_slice( $this->entries, $offset, $limit );
        $sequence = new self( $this->getValueType()->getName() );
        foreach ( $array as $value ) {
            $sequence->add( $value );
        }
        
        return $sequence;
    }


    /**
     * Divide entries into groups, using the value as the delimeter
     *
     * @param mixed $delimiter Value separating each group
     * @param int   $limit     Maximum number of entries to return; negative to return all.
     * @return Sequence
     */
    public function split( $delimiter, int $limit = PHP_INT_MAX ): Sequence
    {
        // Variables
        $startingKey   = $this->getFirstKey();
        $outerSequence = new self( get_class( $this ) );
        
        while (
            // Haven't exceeded requested items
            ( $outerSequence->count() < $limit ) &&
            // Starting index is not past the end of this sequence
            ( $startingKey <= $this->getLastKey() )
        ) {
            
            // Find the next delimiter
            $end = $this->getKeyOf( $delimiter, $startingKey );
            
            // If start and end are the same, the current element is the delimiter
            if ( $startingKey !== $end ) {
                
                // Get number of items to cut
                $count = 0;
                if ( $end < 0 ) {
                    $end   = $this->getLastKey();
                    $count = $this->count() - $startingKey;
                }
                else {
                    $count = $end - $startingKey;
                }
                
                // Cut out the sub-section of this sequence
                if ( 0 < $count ) {
                    $innerSequence = $this->slice( $startingKey, $count );
                    $outerSequence->add( $innerSequence );
                }
            }
            
            // Move to next entry
            $startingKey = $end + 1;
        }
        
        return $outerSequence;
    }


    /**
     * Convert to a native PHP array
     * 
     * @return array
     */
    final public function toArray(): array
    {
        return $this->entries;
    }
}
