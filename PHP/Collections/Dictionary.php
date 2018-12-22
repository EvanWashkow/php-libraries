<?php
declare( strict_types = 1 );

namespace PHP\Collections;

/**
 * Defines a mutable, unordered, and iterable set of key-value pairs
 *
 * @see PHP\Collections\Iterator
 */
class Dictionary extends Collection
{


    /***************************************************************************
    *                               PROPERTIES
    ***************************************************************************/

    /**
     * The set of key-value pairs
     *
     * @var array
     */
    private $entries;




    /***************************************************************************
    *                               CONSTRUCTOR
    ***************************************************************************/


    /**
     * Create a new Dictionary instance
     *
     * @param string $keyType Specifies the type requirement for all keys (see `is()`). An empty string permits all types. Must be 'string' or 'integer'.
     * @param string $valueType Specifies the type requirement for all values (see `is()`). An empty string permits all types.
     */
    public function __construct( string $keyType = '*', string $valueType = '*' )
    {
        // Set properties
        parent::__construct( $keyType, $valueType );
        $this->clear();

        // Exit. The key type must be either an integer or string.
        if ( !$this->getKeyType()->is( 'int' ) &&
             !$this->getKeyType()->is( 'string' ) )
        {
            throw new \InvalidArgumentException( 'Dictionary keys must either be integers or strings' );
        }
    }




    /***************************************************************************
    *                            COLLECTION OVERRIDES
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
        if ( !$this->hasKey( $key )) {
            throw new \InvalidArgumentException( "Key doesn't exist" );
        }
        return $this->entries[ $key ];
    }


    /**
     * @see Collection->hasKey()
     */
    final public function hasKey( $key ): bool
    {
        $hasKey = $this->getKeyType()->equals( $key );
        if ( $hasKey ) {
            
            // If the given key is an object, array_key_exists throws an error
            try {
                $hasKey = array_key_exists( $key, $this->entries );
            } catch ( \Exception $e ) {
                $hasKey = false;
            }
        }
        return $hasKey;
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
        if ( $this->getKeyType()->equals( $key ) && $this->hasKey( $key )) {
            unset( $this->entries[ $key ] );
            $isSuccessful = true;
        }
        else {
            trigger_error( "Key does not exist" );
        }
        return $isSuccessful;
    }


    /**
     * @see Collection->set()
     */
    final public function set( $key, $value ): bool
    {
        // Throw warnings
        $isSuccessful = false;
        if ( !$this->getKeyType()->equals( $key )) {
            trigger_error( 'Wrong key type' );
        }
        elseif ( !$this->getValueType()->equals( $value )) {
            trigger_error( 'Wrong value type' );
        }
        
        // Set the key value pair
        else {
            $this->entries[ $key ] = $value;
            $isSuccessful = true;
        }
        return $isSuccessful;
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
        $key = key( $this->entries );
        
        /**
         * PHP implicitly implicitly converts string indices--like "0"--to integers
         *
         * TODO: Remove this when converting to two internal sequences for keys
         * and values
         */
        if (( null !== $key ) && $this->getKeyType()->is( 'string' ) ) {
            $key = ( string ) $key;
        }
        return $key;
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
}
