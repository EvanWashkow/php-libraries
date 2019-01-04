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
     * @param array  $entries Initial entries
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
     * @see Collection->getValues()
     */
    final public function getValues(): Sequence
    {
        return ( clone $this );
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
        $start         = $this->getFirstKey();
        $lastKey       = $this->getLastKey();
        $outerSequence = new self( get_class( $this ) );
        
        while (
            // Starting index is not past the end of this sequence
            ( $start <= $lastKey ) &&
            // Haven't exceeded requested items
            ( $outerSequence->count() < $limit )
        ) {
            
            // Try to find the next delimiter
            try {
                $end   = $this->getKeyOf( $delimiter, $start );
                $count = $end - $start;
            }

            // Delimiter not found: gather all the remaining entries
            catch ( \Throwable $th ) {
                $end   = $lastKey;
                $count = ( $end + 1 ) - $start;
            }
            
            // There are items to slice and add to the outer sequence
            if ( 0 < $count ) {
                $innerSequence = $this->slice( $start, $count );
                $outerSequence->add( $innerSequence );
            }
            
            // Move to next entry
            $start = $end + 1;
        }
        
        return $outerSequence;
    }
}
