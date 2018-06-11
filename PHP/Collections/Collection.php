<?php
namespace PHP\Collections;

/**
 * Defines an iterable set of mutable, key-value pairs
 *
 * @see PHP\Collections\Iterator
 */
abstract class Collection extends Iterator implements ICollection
{
    
    /**
     * Type requirement for all keys
     *
     * @var string
     */
    private $keyType;
    
    /**
     * Type requirement for all values
     *
     * @var string
     */
    private $valueType;
    
    
    /**
     * Create a new Collection
     *
     * @param string $keyType Specifies the type requirement for all keys (see `is()`). An empty string permits all types. Must be 'string' or 'integer'.
     * @param string $valueType Specifies the type requirement for all values (see `is()`). An empty string permits all types.
     */
    public function __construct( string $keyType = '', string $valueType = '' )
    {
        // Sanitize
        $keyType   = trim( $keyType );
        $valueType = trim( $valueType );
        
        // Check for invalid value types
        if ( 'null' === strtolower( $keyType )) {
            throw new \Exception( 'Key types cannot be NULL' );
        }
        else if ( 'null' === strtolower( $valueType )) {
            throw new \Exception( 'Value types cannot be NULL' );
        }
        
        // Set properties
        $this->keyType   = $keyType;
        $this->valueType = $valueType;
    }
    
    
    public function getKeys(): IReadOnlySequence
    {
        $keys = new Sequence( $this->keyType );
        $this->loop( function( $key, $value ) use ( &$keys ) {
            $keys->add( $key );
        });
        return new ReadOnlySequence( $keys );
    }
    
    
    public function getValues(): IReadOnlySequence
    {
        $values = new Sequence( $this->valueType );
        $this->loop( function( $key, $value ) use ( &$values ) {
            $values->add( $value );
        });
        return new ReadOnlySequence( $values );
    }
    
    
    final public function isOfKeyType( $key ): bool
    {
        return (
            ( null !== $key ) &&
            (
                ( '' === $this->keyType ) ||
                is( $key, $this->keyType )
            )
        );
    }
    
    
    final public function isOfValueType( $value ): bool
    {
        return (( '' === $this->valueType ) || is( $value, $this->valueType ));
    }
    
    
    
    
    /***************************************************************************
    *                              ITERATOR METHODS
    ***************************************************************************/
    
    final public function seek( $key )
    {
        if ( $this->hasKey( $key )) {
            parent::seek( $key );
        }
        else {
            $this->throwSeekError( $key );
        }
    }
    
    
    final public function valid()
    {
        return $this->hasKey( $this->key() );
    }
}
