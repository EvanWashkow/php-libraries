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
     * Create a new collection of entries, stored sequentially
     * 
     * Throws exception when value type is NULL or unknown.
     *
     * @param string $type    Type requirement for values. '*' allows all types.
     * @param array  $entries Initial entries [ key => value ]
     * @throws \InvalidArgumentException On bad value type
     */
    public function __construct( string $type = '*', array $entries = [] )
    {
        // Set parent properties
        parent::__construct( 'int', $type );

        // For each entry, make sure it is the right type
        $valueType = $this->getValueType();
        if ( !is_a( $valueType, Collection\WildcardType::class )) {
            foreach ( $entries as $key => $value ) {
                if ( !$valueType->equals( $value )) {
                    trigger_error( 'Wrong value type' );
                    unset( $entries[ $key ] );
                }
            }
        }

        // Initialize entries
        $this->entries = array_values( $entries );
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
        $this->rewind();
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
     * @see Collection->getKeys()
     */
    final public function getKeys(): Sequence
    {
        return new self(
            $this->getKeyType()->getName(),
            array_keys( $this->entries )
        );
    }


    /**
     * Retrieve the key of the first value found
     * 
     * Throws exception when key not found, or offset is too large or too small.
     * This *always* has to be handled by the caller, even if a default value
     * was returned. Throwing an exception provides more information to the
     * caller about what happened.
     *
     * @param mixed $value     Value to find
     * @param int   $offset    Start search from this key. If the value is found at this key, the key will be returned.
     * @param bool  $isReverse Search backwards
     * @return int The key
     * @throws \Exception If key not found or offset too large or too small
     */
    final public function getKeyOf(      $value,
                                    int  $offset = 0,
                                    bool $isReverse = false ): int
    {
        // Variables
        $key;
        $firstKey = $this->getFirstKey();
        $lastKey  = $this->getLastKey();

        /**
         * Throw exceptions for a bad offset
         * 
         * Do not try to fix the offset! Prefer correctness over convenience.
         * A recursive search with an incremental offset will result in an
         * invalid offset: the returned key should be invalid.
         */
        if ( $offset < $firstKey ) {
            throw new \InvalidArgumentException( 'Offset too small' );
            
        }
        elseif ( $lastKey < $offset ) {
            throw new \InvalidArgumentException( 'Offset too large' );
        }

        // Get sub-sequence to search
        $sequence;
        if ( $isReverse ) {
            if ( $lastKey === $offset ) {
                $sequence = $this;
            }
            else {
                $sequence = $this->slice( $firstKey, $offset + 1 );
            }
            $sequence = $sequence->reverse();
        }
        else {
            if ( $firstKey === $offset ) {
                $sequence = $this;
            }
            else {
                $sequence = $this->slice( $offset );
            }
        }
        
        // Search the sub-sequence for the value
        $searchResult = array_search( $value, $sequence->toArray(), true );

        // Compensate for the offset and reverse search
        if ( false === $searchResult ) {
            throw new \Exception( 'Value not found' );
        }
        else {
            if ( $isReverse ) {
                $key = $offset - $searchResult;
            }
            else {
                $key = $searchResult + $offset;
            }
        }

        return $key;
    }


    /**
     * @see Collection->hasKey()
     */
    final public function hasKey( $key ): bool
    {
        return (is_int( $key ) && array_key_exists( $key, $this->entries ));
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


    /**
     * @see Collection->toArray()
     */
    final public function toArray(): array
    {
        return $this->entries;
    }




    /***************************************************************************
    *                       ITERATOR INTERFACE OVERRIDES
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
    public function add( $value ): bool
    {
        $isSuccessful = $this->getValueType()->equals( $value );
        if ( $isSuccessful ) {
            $this->entries[] = $value;
        }
        else {
            trigger_error( 'Wrong value type' );
        }
        return $isSuccessful;
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
        return new self(
            $this->getKeyType()->getName(),
            array_reverse( $this->entries, false )
        );
    }


    /**
     * Retrieve a subset of entries from this Sequence
     *
     * @internal Why was the decision made to use a starting key and a count
     * as the parameters, rather than starting and ending keys? There are two
     * main reasons:
     * 1. That's how humans do it, because that's how math works. When given a
     * ruler, starting at the 3rd inch, and told to measure 5 inches, humans
     * count (add) another 5 inches to the 3 inch mark: 8 inches.
     * 2. Starting and ending keys have a fatal flaw: In order for them to
     * be able to (respectively) specify the first / last items in the sequence,
     * they *must* be inclusive. However, this inclusivity prevents them from
     * ever selecting an empty list---which is completely valid---without
     * specifying some erroneous state (such as start = 5 and end = 4).
     * 
     * @internal Even though "array_slice()" supports a negative offset and
     * length, we don't. It is a bad practice to specify starting keys before
     * the beginning of the array and negative lengths. They are not only
     * impossible, but confusing and prevent useful errors when there is an
     * arithmetic error in the caller's logic.
     *
     * @param int $offset Starting key (inclusive)
     * @param int $count  Number of items to copy
     * @return Sequence
     */
    public function slice( int $offset, int $count = PHP_INT_MAX ): Sequence
    {
        // Sanitize the starting key
        if ( $offset < $this->getFirstKey() ) {
            trigger_error( 'Starting key cannot be before the first key of the sequence.' );
            $offset = $this->getFirstKey();
        }
        
        // Sanitize count
        if ( $count < 0 ) {
            trigger_error( 'Cannot copy a negative number of items.' );
            $count = 0;
        }
        
        // Slice and copy entries to the sub-sequence
        $entries  = array_slice( $this->entries, $offset, $count );
        $sequence = new self( $this->getValueType()->getName(), $entries );
        
        // Return sub-sequence
        return $sequence;
    }


    /**
     * Split this sequence into sub-sequences, using a value as the delimiter
     * 
     * The delimiter is not included in the resulting sub-sequences
     *
     * @param mixed $delimiter Value to divide the sequence over
     * @param int   $limit     Maximum number of entries to return
     * @return Sequence
     */
    public function split( $delimiter, int $limit = PHP_INT_MAX ): Sequence
    {
        // Variables
        $start    = $this->getFirstKey();
        $lastKey  = $this->getLastKey();
        $sequence = new self( self::class );
        
        // Continue looping until all the requirements are satisfied
        while (( $start <= $lastKey ) && ( $sequence->count() < $limit )) {
            
            // Try to find the next delimiter value
            try {
                $end   = $this->getKeyOf( $delimiter, $start );
                $count = $end - $start;
            }

            // Value not found: gather all the remaining entries
            catch ( \Throwable $th ) {
                $end   = $lastKey;
                $count = ( $end + 1 ) - $start;
            }
            
            // Append entry group to the outer sequence, excluding the delimiter
            if ( 0 < $count ) {
                $innerSequence = $this->slice( $start, $count );
                $sequence->add( $innerSequence );
            }
            
            // Move one past the delimiter
            $start = $end + 1;
        }
        
        return $sequence;
    }
}
