<?php
namespace PHP\Collections;

/**
 * Defines a mutable, unordered, and iterable set of key-value pairs
 *
 * @see PHP\Collections\Iterator
 */
class Dictionary extends Collection implements IDictionary
{
    
    /**
     * The set of key-value pairs
     *
     * @var array
     */
    private $entries;
    
    /**
     * Specifies the type requirement for all keys
     *
     * @var string
     */
    private $keyType;
    
    /**
     * Specifies the type requirement for all values
     *
     * @var string
     */
    private $valueType;
    
    
    /**
     * Create a new Dictionary instance
     *
     * @param string $keyType Specifies the type requirement for all keys (see `is()`). An empty string permits all types. Must be 'string' or 'integer'.
     * @param string $valueType Specifies the type requirement for all values (see `is()`). An empty string permits all types.
     */
    public function __construct( string $keyType = '*', string $valueType = '*' )
    {
        // Invoke parent constructor
        parent::__construct( $keyType, $valueType );

        // Exit. The key type must be either an integer or string.
        if ( !$this->getKeyType()->is( 'int' ) &&
             !$this->getKeyType()->is( 'string' ) )
        {
            throw new \InvalidArgumentException( 'Dictionary keys must either be integers or strings' );
        }
        
        // Initialize properties
        $this->clear();
        $this->keyType = $keyType;
        $this->valueType = $valueType;
    }
    
    
    
    
    /***************************************************************************
    *                              EDITING METHODS
    ***************************************************************************/
    
    final public function clear(): bool
    {
        $this->entries = [];
        return true;
    }
    
    
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
    *                             READ-ONLY METHODS
    ***************************************************************************/
    
    public function clone(): IReadOnlyCollection
    {
        $clone = new self( $this->keyType, $this->valueType );
        $this->loop( function( $key, $value ) use ( &$clone ) {
            $clone->set( $key, $value );
        });
        return $clone;
    }
    
    
    final public function count(): int
    {
        return count( $this->entries );
    }
    
    
    final public function get( $key )
    {
        if ( !$this->getKeyType()->equals( $key )) {
            throw new \InvalidArgumentException( "Cannot get non-{$this->keyType} key" );
        }
        elseif ( !$this->hasKey( $key )) {
            throw new \InvalidArgumentException( "Cannot get value at non-existing key" );
        }
        return $this->entries[ $key ];
    }
    
    
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


    final public function hasValue( $value ): bool
    {
        return (
            $this->getValueType()->equals( $value ) &&
            in_array( $value, $this->entries )
        );
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
        $key = key( $this->entries );
        
        /**
         * PHP implicitly implicitly converts string indices--like "0"--to integers
         *
         * TODO: Remove this when converting to two internal sequences for keys
         * and values
         */
        if (( null !== $key ) && ( 'string' === $this->keyType )) {
            $key = ( string ) $key;
        }
        return $key;
    }
    
    final public function next()
    {
        next( $this->entries );
    }
    
    final public function rewind()
    {
        reset( $this->entries );
    }
}
