<?php
namespace PHP\Collections;

use PHP\Collections\Collection\ReadOnlyCollectionSpec;
use PHP\Collections\Sequence\ReadOnlySequence;
use PHP\Collections\Sequence\ReadOnlySequenceSpec;

/**
 * Defines a mutable, unordered set of keyed values
 */
class Dictionary extends \PHP\PHPObject implements DictionarySpec
{
    
    /**
     * The set of keyed values
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
    public function __construct( string $keyType = '', string $valueType = '' )
    {
        // Abort. The key type must be either an integer or string.
        if (( 'integer' !== $keyType ) && ( 'string' !== $keyType )) {
            throw new \Exception( 'Dictionary keys must either be integers or strings' );
        }
        
        // Abort. Value types cannot be null.
        elseif ( 'null' === strtolower( $valueType )) {
            throw new \Exception( 'Dictionary values cannot be NULL' );
        }
        
        
        // Initialize properties
        $this->clear();
        $this->keyType = $keyType;
        $this->valueType = $valueType;
    }
    
    
    
    
    /***************************************************************************
    *                              EDITING METHODS
    ***************************************************************************/
    
    public function add( $key, $value ): bool
    {
        $isSuccessful = false;
        if ( $this->hasKey( $key )) {
            trigger_error( 'Cannot add value: key already exists' );
        }
        else {
            $isSuccessful = $this->set( $key, $value );
        }
        return $isSuccessful;
    }
    
    
    public function clear()
    {
        $this->entries = [];
    }
    
    
    public function remove( $key ): bool
    {
        $isSuccessful = false;
        if ( !$this->isValidKeyType( $key )) {
            trigger_error( "Cannot remove entry with non-{$this->keyType} key" );
        }
        elseif ( !$this->hasKey( $key )) {
            trigger_error( 'Cannot remove value from non-existing key' );
        }
        else {
            unset( $this->entries[ $key ] );
            $isSuccessful = true;
        }
        return $isSuccessful;
    }
    
    
    public function update( $key, $value ): bool
    {
        $isSuccessful = false;
        if ( $this->hasKey( $key )) {
            $isSuccessful = $this->set( $key, $value );
        }
        else {
            trigger_error( 'Cannot update value: the key does not exist' );
        }
        return $isSuccessful;
    }
    
    
    
    
    /***************************************************************************
    *                             READ-ONLY METHODS
    ***************************************************************************/
    
    public function clone(): ReadOnlyCollectionSpec
    {
        $class = get_class( $this );
        $clone = new $class( $this->keyType, $this->valueType );
        $this->loop( function( $key, $value, &$clone ) {
            $clone->add( $key, $value );
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
        if ( !$this->isValidKeyType( $key )) {
            throw new \Exception( "Cannot get non-{$this->keyType} key" );
        }
        elseif ( !$this->hasKey( $key )) {
            throw new \Exception( "Cannot get value at non-existing key" );
        }
        return $this->entries[ $key ];
    }
    
    
    public function getKeys(): ReadOnlySequenceSpec
    {
        $keys = new Sequence( $this->keyType );
        foreach ( array_keys( $this->entries ) as $key ) {
            $keys->add( $key );
        }
        return new ReadOnlySequence( $keys );
    }
    
    
    public function getValues(): ReadOnlySequenceSpec
    {
        $values = new Sequence( $this->valueType );
        $this->loop(function( $key, $value, &$values ) {
            $values->add( $value );
        }, $values );
        return new ReadOnlySequence( $values );
    }
    
    
    public function hasKey( $key ): bool
    {
        return (
            $this->isValidKeyType( $key ) &&
            array_key_exists( $key, $this->entries )
        );
    }
    
    
    public function loop( callable $function, &...$args )
    {
        $iterable   = new Traversable( $this->entries );
        $parameters = array_merge( [ $function ], $args );
        return call_user_func_array( [ $iterable, 'loop' ], $parameters );
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
        return $this->hasKey( $this->key() );
    }
    
    
    
    
    /***************************************************************************
    *                               HELPER METHODS
    ***************************************************************************/
    
    /**
     * Determine if the key type meets its type constraints
     *
     * @param mixed $key The key to check
     * @return bool
     */
    final protected function isValidKeyType( $key ): bool
    {
        return (( '' === $this->keyType ) || is( $key, $this->keyType ));
    }
    
    
    /**
     * Determine if the value type meets its type constraints
     *
     * @param mixed $value The value to check
     * @return bool
     */
    final protected function isValidValueType( $value ): bool
    {
        return (( '' === $this->valueType ) || is( $value, $this->valueType ));
    }
    
    
    /**
     * Store the value at the specified key
     *
     * Fails if the key or value doesn't match its type requirement
     *
     * @param mixed $key The key to store the value at
     * @param mixed $value The value to store
     * @return bool Whether or not the operation was successful
     */
    private function set( $key, $value ): bool
    {
        $isSuccessful = false;
        if ( !$this->isValidKeyType( $key )) {
            trigger_error( "Cannot set value at a non-{$this->keyType} key" );
        }
        elseif ( !$this->isValidValueType( $value )) {
            trigger_error( "Cannot set non-{$this->valueType} values" );
        }
        else {
            $this->entries[ $key ] = $value;
            $isSuccessful = true;
        }
        return $isSuccessful;
    }
}
